<?php
include_once('../simple_html_dom.php');

echo file_get_html('http://games.espn.go.com/ffl/standings?leagueId=313479&seasonId=2012')->plaintext;
?>