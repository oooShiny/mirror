<?php
include_once('parser/simple_html_dom.php');
// To shut up the goddamn PHP warnings.
date_default_timezone_set('America/New_York');

function scrape_lunch() {

    // create HTML DOM
    $html = file_get_html('http://lunch.gilinux.dev/admin/');
    foreach($html->find('div.row') as $div) {
        foreach($div->find('div.label') as $day) {
            $date = $day->plaintext;
        }
        foreach($div->find('textarea') as $lunch) {
            $food = $lunch->plaintext;
        }
      $ret[$date] = $food;
    }
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}


// -----------------------------------------------------------------------------
// test it!
$days = scrape_lunch();
?>

<div class="lunch-list">
  <?php foreach ($days as $day => $lunch): ?>
    <?php if ($day == date('l')): ?>
      <span><strong>Lunch Today: </strong><?php print $lunch; ?></span>
    <?php endif; ?>
  <?php endforeach; ?>
</div>