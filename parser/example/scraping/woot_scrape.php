<?php
include_once('../../simple_html_dom.php');

function scraping_digg() {
    // create HTML DOM
    $html = file_get_html('http://www.woot.com/');

    // get news block
    foreach($html->find('div#summary') as $article) {
        // get title
        $item['title'] = trim($article->find('h1', 0)->plaintext);
        // get details
        $item['details'] = trim($article->find('h2', 0)->plaintext);
        // get sale price
        $item['sale'] = trim($article->find('span', 0)->plaintext);
		// get original price
		$item['price'] = trim($article->find('span', 1)->plaintext);
		// get discount percent
		$item['percent'] = trim($article->find('span', 2)->plaintext);
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

$ret = scraping_digg();

foreach($ret as $v) {
    echo '<h3>'.$v['title'].'</h3>';
    echo '<ul>';
    echo '<li>'.$v['details'].'</li>';
    echo '<li>'.$v['sale'].'</li>';
	echo '<li style="text-decoration: line-through;">'.$v['price'].'</li>';
    echo '<li>'.$v['percent'].'</li>';
    echo '</ul>';
}

?>