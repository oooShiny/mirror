<?php
// example of how to use basic selector to retrieve HTML contents
include('../simple_html_dom.php');

// get DOM from URL or file
$getlink = file_get_html('http://games.espn.go.com/ffl/leagueoffice?leagueId=198429');
// find the iframe link
foreach($getlink->find('iframe') as $e) 
    $iframe_link = $e->src;
    //echo $iframe_link;

$html = file_get_html($iframe_link);

// find all link
foreach($html->find('div.group_matchup img') as $e) 
    echo '<img src="http://ar-brown.net/fantasyfootball/'.$e->src . '" />';

foreach($html->find('div.field-name-field-featured-matchup p') as $e)
	echo '<p style="font-size: 75%">'.$e->innertext.'</p>';
/*
// find all image
foreach($html->find('img') as $e)
    echo $e->src . '<br>';

// find all image with full tag
foreach($html->find('img') as $e)
    echo $e->outertext . '<br>';

// find all div tags with id=gbar
foreach($html->find('div#gbar') as $e)
    echo $e->innertext . '<br>';

// find all span tags with class=gb1
foreach($html->find('span.gb1') as $e)
    echo $e->outertext . '<br>';

// find all td tags with attribite align=center
foreach($html->find('td[align=center]') as $e)
    echo $e->innertext . '<br>';
    
// extract text from table
echo $html->find('td[align="center"]', 1)->plaintext.'<br><hr>';

// extract text from HTML
echo $html->plaintext;
*/?>