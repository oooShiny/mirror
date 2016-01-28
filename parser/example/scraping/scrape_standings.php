<?php
header('Content-type: text/html; charset=utf-8');
include_once('../../simple_html_dom.php');

function scraping_sox_scores() {
    // create HTML DOM
    $html = file_get_html('http://en.wikipedia.org/wiki/Template:2013_AL_East_standings');

    // get article block
    foreach($html->find('table.wikitable tr') as $standings) {

            $item['team'] = trim($standings->find('td', 0)->plaintext);
            $item['wins'] = trim($standings->find('td', 1)->plaintext);
            $item['losses'] = trim($standings->find('td', 2)->plaintext);
            $item['gb'] = trim($standings->find('td', 4)->plaintext);

        $ret[] = $item;
    }
    
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}

// -----------------------------------------------------------------------------
// test it!
$ret = scraping_sox_scores();
print '<table>';
foreach($ret as $v) {
    print '<tr>';
    print '<td>'.$v['team'].'</td>';
    print '<td>'.$v['wins'].'</td>';
    print '<td>'.$v['losses'].'</td>';
    print '<td>'.$v['gb'].'</td>';
    print '</tr>';
}
print '</table>';
?>