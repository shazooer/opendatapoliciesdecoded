<?php

/**
 * The "About" page, explaining this State Decoded website.
 *
 * PHP version 5
 *
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.9
 * @link		http://www.statedecoded.com/
 * @since		0.1
 *
 */

/*
 * Create a container for our content.
 */
$content = new Content();

/*
 * Define some page elements.
 */
$content->set('browser_title', 'About');
$content->set('page_title', 'About');

$body = '
<h2>Introduction</h2>
<p>Open Data Policies Decoded is a non-profit, non-governmental, non-partisan implementation of <a href="http://www.statedecoded.com" target="_blank">The State Decoded</a> brought to you by the folks at the <a href="http://opengovfoundation.org">OpenGov Foundation</a>. The State Decoded is a free, open source project that provides a platform to display legal information in a friendly, accessible, modern fashion.</p>

<h2>Beta Testing</h2>
<p>Open Data Policies Decoded is currently in public beta, which is to say that the site is under active development, with known shortcomings, but it has reached a point where it would benefit from being used by the general public (who one hopes will likewise benefit from it.) While every effort is made to ensure that the data provided on Open Data Policies Decoded is accurate and up-to-date, it would be gravely unwise to rely on it for any matter of importance while it is in this beta testing phase.</p>

<h2>Data Sources</h2>
The information that makes up Open Data Policies Decoded comes entirely from public sources. Throughout the site, links are provided to original data sources, whenever possible. 

<h2>API</h2>
<p>The site has a RESTful, JSON-based API.  <a href="https://github.com/statedecoded/statedecoded/wiki/API-Documentation">read the documentation</a> for details.</p>

<h2>Thanks</h2>
<p>Open Data Policies Decoded wouldn’t be possible without the contributions and years of work by <a href="http://waldo.jaquith.org/">Waldo Jaquith</a>, and the many dozens of people who participated in private alpha and beta testing of <a href="http://vacode.org/about/">Virginia Decoded</a>, the first <a href="http://www.statedecoded.com/">State Decoded</a> site, over the course of a year and a half, beginning in 2010. This platform on which this site is based, <a href="http://www.statedecoded.com/">The State Decoded</a>.


<h2>Disclaimer</h2>
<p>This is not an official copy of the Open Data Policies from various jurisdictions. It is in no way authorized by the jurisdictions. No information that is found on Open Data Policies Decoded constitutes legal advice on any subject matter. Do not take action (or fail to take action) on a legal matter without consulting proper legal counsel. The contents of this website are provided as-is, with no warranty of any kind, including merchantability, non-infringement, or fitness for a particular purpose. This website is not your lawyer, and neither is the Sunlight Foundation.</p>
';

$sidebar = '';

/*
 * Put the shorthand $body variable into its proper place.
 */
$content->set('body', $body);
unset($body);

/*
 * Put the shorthand $sidebar variable into its proper place.
 */
$content->set('sidebar', $sidebar);
unset($sidebar);

/*
 * Add the custom classes to the body.
 */
$content->set('body_class', 'law inside');


/*
 * Fire up our templating engine.
 */
$template = Template::create();

/*
 * Parse the template, which is a shortcut for a few steps that culminate in sending the content
 * to the browser.
 */
$template->parse($content);
