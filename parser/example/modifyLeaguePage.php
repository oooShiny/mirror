<?php
// example of how to modify HTML contents
include('../simple_html_dom.php');

// get DOM from URL or file
$html = file_get_html('http://www9.myfantasyleague.com/2013/home/76612');

// remove all image
 foreach($html->find('img') as $e)
     $e->src = 'http://3.bp.blogspot.com/-3H7D9KlRryU/Tr5_fJlmpLI/AAAAAAAAAuo/1CAfUH_45gQ/s640/cute-little-kitten-cat-fur-ball.jpg';

// replace all input
// foreach($html->find('input') as $e)
//    $e->outertext = '[INPUT]';

// dump contents
echo $html;
?>