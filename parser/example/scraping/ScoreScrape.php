<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="http://g.espncdn.com/ffl/static/css/main?v=24214192711" type="text/css">
</head>
<body>
<?php
require_once('../../simple_html_dom.php');

function scraping_espn() {
    // create HTML DOM
    $html = file_get_html('http://games.espn.go.com/ffl/scoreboard?leagueId=198429&seasonId=2012');

    // get scoreboard tables
    foreach($html->find('table.ptsBased') as $article) {
        // get away team
        $item['awayteam'] = trim($article->find('div.name', 0)->plaintext);
        // get home team
        $item['hometeam'] = trim($article->find('div.name', 1)->plaintext);
        // get away score
        $item['awayscore'] = trim($article->find('td.score', 0)->plaintext);
		// get home score
		$item['homescore'] = trim($article->find('td.score', 1)->plaintext);
        $ret[] = $item;
    }
    
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}


// -----------------------------------------------------------------------------
// run it!

// will check user_agent header...
ini_set('user_agent', 'My-Application/2.5');
$i = 1;
$ret = scraping_espn();
    echo '<table class="ptsBased matchup">';
foreach($ret as $v) {

    echo '<tr id="teamscrg_'.$i.'_activeteamrow">';
    echo '<td class="team"><div class="name">'.$v['awayteam'].'</div></td>';
    echo '<td class="score">'.$v['awayscore'].'</td>';
    echo '</tr><tr>';
    echo '<td class="team"><div class="name">'.$v['hometeam'].'</div></td>';
   	echo '<td class="score">'.$v['homescore'].'</td>';
    echo '</tr><tr><td colspan="2"><hr></td></tr>';
    $i++;
}
    echo '</table>';
?>
</body>
</html>