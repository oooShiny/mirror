<?php
include_once('../../simple_html_dom.php');

function scraping_amazon() {
    // create HTML DOM
    $html = file_get_html('http://www.amazon.com/b?node=2350149011');

    // get news block
    foreach($html->find('div.fad-widget-large-footer') as $article) {
        // get title
        $item['title'] = trim($article->find('span', 0)->plaintext);
        // get details
        $item['author'] = trim($article->find('span', 1)->plaintext);
        // get sale price
        $item['rating'] = trim($article->find('span', 2)->plaintext);
		// get original price
		$item['text'] = trim($article->find('img', 0)->plaintext);
		// get discount percent
//		$item['percent'] = trim($article->find('span', 2)->plaintext);
        $ret[] = $item;
    }
    
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}


// -----------------------------------------------------------------------------
// test it!

// "http://digg.com" will check user_agent header...
ini_set('user_agent', 'My-Application/2.5');

$ret = scraping_amazon();

foreach($ret as $v) {
    echo '<h3>'.$v['title'].'</h3>';
    echo '<ul>';
    echo '<li>'.$v['author'].'</li>';
    echo '<li>'.$v['rating'].'</li>';
	echo '<li>'.$v['text'].'</li>';
    //echo '<li>'.$v['percent'].'</li>';
    echo '</ul>';
}

?>