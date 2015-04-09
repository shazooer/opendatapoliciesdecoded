<?php

require_once(INCLUDE_PATH . 'class.SearchEngineInterface.inc.php');

class SolrSearchEngine extends SearchEngineInterface
{
	/*
	 * Solr Config.
	 */
	protected $config;

	/*
	 * Our Solarium client.
	 */
	protected $client;

	/*
	 *The current transaction.
	 */
	protected $transaction;

	/*
	 * The type of transaction.
	 */
	protected $transaction_type;

	/*
	 * The documents to put into our current transaction.
	 */
	public $documents = array();

	/*
	 * Number of documents to store before automatically flushing.
	 */
	public $autocommit_size = 100;

	/*
	 * Hang on to our last result.
	 */
	protected $last_result;

	public function __construct($args = array())
	{
		parent::__construct($args);

		if(!isset($this->config) && defined('SEARCH_CONFIG'))
		{
			$this->config = json_decode(SEARCH_CONFIG, TRUE);
		}

		$this->client = new Solarium_Client(
			array(
				'adapteroptions' => $this->config
			)
		);
	}

	public function start_update()
	{
		if($this->transaction !== null)
		{
			trigger_error('Warning from SolrSearchEngine->start_update() - ' .
				'Starting update, stomping on existing transaction',
				E_USER_WARNING);
		}

		$this->transaction = $this->client->createUpdate();
		$this->transaction_type = 'update';
	}

	public function add_document($record)
	{
		if(strtolower(get_class($record)) === 'law')
		{
			$document = $this->law_to_document($record);
		}
		elseif(strtolower(get_class($record)) === 'structure')
		{
			$document = $this->structure_to_document($record);
		}
		else {
			throw new Exception('Record has a bad type in SolrSearchEngine->add_document');
		}

		$this->documents[] = $document;

		// If we've reached the maximum size, flush our documents to the index.
		// if(count($this->documents) >= $this->autocommit_size)
		// {
		// 	$this->commit();
		// 	$this->start_update();
		// }

		return $document;
	}

	public function commit()
	{
		if($this->transaction_type === 'update')
		{

			// Add the documents and a commit command to the update query.
			$this->transaction->addDocuments($this->documents);
			$this->transaction->addCommit();

			// This executes the query and returns the result.
			$this->last_result = $this->client->update($this->transaction);
		}

		if($this->last_result->getStatus() === 0)
		{
			unset($this->transaction);
			unset($this->documents);
			return TRUE;
		}

		throw new Exception('Solr query failed.');
		return FALSE;
	}

	public function debug()
	{
		echo 'Query type: ' . $this->transaction_type . "\n";
		echo 'Query status: ' . $result->getStatus(). "\n";
		echo 'Query time: ' . $result->getQueryTime() . "\n";
	}

	public function law_to_document($law)
	{
		$document = $this->transaction->createDocument();

		$document->id = 'l_' . $law->token;

		$document->section = $law->section;

		$document->edition_id = $law->edition->id;
		$document->edition = $law->edition->name;
		$document->edition_updated = $law->edition->last_import;
		$document->edition_current = $law->edition->current;

		$document->catch_line = $law->catch_line;
		$document->tags = $law->tags;

		$document->text = $law->full_text;

		$document->repealed = $law->metadata->repealed;

		$document->structure = array();
		foreach($law->ancestry as $key=>$value)
		{
			$document->structure[] = $value->name;
		}
		$document->structure = join('/', $document->structure);

		$document->refers_to = array();
		foreach($document->refers_to as $law)
		{
			$document->refers_to[] = $law->section;
		}

		$document->referred_to_by = array();
		foreach($document->referred_to_by as $law)
		{
			$document->referred_to_by[] = $law->section;
		}

		return $document;
	}

	public function structure_to_document($structure)
	{
	/*
		$document = $this->transaction->createDocument();

		$document->id =

		//$document->section =

		$document->edition_id = $structure->edition->id;
		$document->edition = $structure->edition->name;
		$document->edition_updated = $structure->edition->last_import;
		$document->edition_current = $structure->edition->current;

		$document->catch_line = $structure->name;
		//$document->tags =

		$document->text =

		$document->repealed =

		$document->structure =

		return $document;
	*/
	}


}