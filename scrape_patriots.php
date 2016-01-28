<?php
include_once('parser/simple_html_dom.php');

function scrape_pats_games() {

    // create HTML DOM
    $html = file_get_html('http://www.footballdb.com/teams/nfl/new-england-patriots');
    foreach($html->find('div#lastgame') as $div) {
        $ret['last'] = $div->plaintext;
    }
    foreach($html->find('div#nextgame') as $div) {
        $ret['next'] = $div->plaintext;
    }
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}


// -----------------------------------------------------------------------------
// test it!
$games = scrape_pats_games();
// $last = explode("\n", $games['last']);
// $date = ltrim($last[0], "Last Game");
// $score = explode("Quarter", $last[1]);
// $score = $score[0];
?>

<!-- <dl>
    <dt>Last Game</dt>
    <dd><?php print $score; ?></dd>
</dl>
 -->
<?php
if (isset($games['next'])):
    $next = explode("\n", $games['next']);
    $ndate = ltrim($next[0], "Next Game");
    $nscore = explode("Recent", $next[1]);
    $nscore = $nscore[0];
?>

<dl class="patriots">
    <dt><img src="pats-logo-white.png" /> Next Game</dt>
    <dd><?php print $nscore; ?><br>
    <?php print $ndate; ?></dd>
</dl>
<?php else: ?>
<div class="patriots">
    <p><img src="pats-logo-white.png" /> No Upcoming Games</p>
</div>
<?php endif; ?>