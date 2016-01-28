<?php
include_once('../../simple_html_dom.php');

function scraping_sox_scores() {
    // get yesterday's date

    // create HTML DOM
    $html = file_get_html('http://scores.espn.go.com/mlb/scoreboard');

    // get article block
    foreach($html->find('table.game-details') as $boxscore) {
            //get home team
            $item['home'] = trim($boxscore->find('tr td.team', 1)->plaintext);
            // get home scores by inning
            $item['hs1'] = trim($boxscore->find('td[id$=hls0]', 0)->plaintext);
            $item['hs2'] = trim($boxscore->find('td[id$=hls1]', 0)->plaintext);
            $item['hs3'] = trim($boxscore->find('td[id$=hls2]', 0)->plaintext);
            $item['hs4'] = trim($boxscore->find('td[id$=hls3]', 0)->plaintext);
            $item['hs5'] = trim($boxscore->find('td[id$=hls4]', 0)->plaintext);
            $item['hs6'] = trim($boxscore->find('td[id$=hls5]', 0)->plaintext);
            $item['hs7'] = trim($boxscore->find('td[id$=hls6]', 0)->plaintext);
            $item['hs8'] = trim($boxscore->find('td[id$=hls7]', 0)->plaintext);
            $item['hs9'] = trim($boxscore->find('td[id$=hls8]', 0)->plaintext);
            // get home runs
            $item['hruns'] = trim($boxscore->find('td[id$=hlsT]', 0)->plaintext);
            // get home hits
            $item['hhits'] = trim($boxscore->find('td[id$=hlsH]', 0)->plaintext);
            // get home errors
            $item['herrors'] = trim($boxscore->find('td[id$=hlsE]', 0)->plaintext);
            // get away team
            $item['away'] = trim($boxscore->find('tr td.team', 0)->plaintext);
            // get away scores by inning
            $item['as1'] = trim($boxscore->find('td[id$=als0]', 0)->plaintext);
            $item['as2'] = trim($boxscore->find('td[id$=als1]', 0)->plaintext);
            $item['as3'] = trim($boxscore->find('td[id$=als2]', 0)->plaintext);
            $item['as4'] = trim($boxscore->find('td[id$=als3]', 0)->plaintext);
            $item['as5'] = trim($boxscore->find('td[id$=als4]', 0)->plaintext);
            $item['as6'] = trim($boxscore->find('td[id$=als5]', 0)->plaintext);
            $item['as7'] = trim($boxscore->find('td[id$=als6]', 0)->plaintext);
            $item['as8'] = trim($boxscore->find('td[id$=als7]', 0)->plaintext);
            $item['as9'] = trim($boxscore->find('td[id$=als8]', 0)->plaintext);
            // get away runs
            $item['aruns'] = trim($boxscore->find('td[id$=alsT]', 0)->plaintext);
            // get away hits
            $item['ahits'] = trim($boxscore->find('td[id$=alsH]', 0)->plaintext);
            // get away errors
            $item['aerrors'] = trim($boxscore->find('td[id$=alsE]', 0)->plaintext);
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

foreach($ret as $v) {
    if (($v['home'] == 'BOS')||($v['away'] == 'BOS')){
        echo '<table>';
        echo '<tr>';
        echo '<td></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>R</td><td>H</td><td>E</td>';
        echo '</tr>';
        echo '<td id="away">'.$v['away'].'</td><td>';
            echo $v['as1']. '</td><td>';
            echo $v['as2']. '</td><td>';
            echo $v['as3']. '</td><td>';
            echo $v['as4']. '</td><td>';
            echo $v['as5']. '</td><td>';
            echo $v['as6']. '</td><td>';
            echo $v['as7']. '</td><td>';
            echo $v['as8']. '</td><td>';
            echo $v['as9']. '</td><td>';
            echo $v['aruns']. '</td><td>';
            echo $v['ahits']. '</td><td>';
            echo $v['aerrors']. '</td>';
            echo '</tr><tr>';
        echo '<td id="home">'.$v['home'].'</td><td>';
            echo $v['hs1']. '</td><td>';
            echo $v['hs2']. '</td><td>';
            echo $v['hs3']. '</td><td>';
            echo $v['hs4']. '</td><td>';
            echo $v['hs5']. '</td><td>';
            echo $v['hs6']. '</td><td>';
            echo $v['hs7']. '</td><td>';
            echo $v['hs8']. '</td><td>';
            echo $v['hs9']. '</td><td>';
            echo $v['hruns']. '</td><td>';
            echo $v['hhits']. '</td><td>';
            echo $v['herrors']. '</td>';
            echo '</tr>';
        echo '</table>';
    }
}
?>