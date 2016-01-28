<?php
/*
** Scrape ESPN Trades
** Using leagueId from URL
** 
*/
if($_POST['submit'] != true)
{
?>

<!-- Get ESPN leagueId from user by way of form -->
<form name="getID" method="post" action="<?php $_SERVER['PHP_SELF'];?>">
    <div>Enter ESPN League ID: </div><input type="text" name="ESPNid">
    <input type="hidden" name="submit" value="true" />
    <input type="submit" value="Get League Info" />
</form>

<?php
}
else
{
    require_once('../simple_html_dom.php');
/*
** Get the list of trades that have happened this season by scraping 
** the 'Recent Activity' list. 
** Data Aquired for each trade: 
**      - Owners involved
**      - Players involved (name, position, team)
**      - Week of season (calculated from date of transaction)
*/
    function scraping_trades() 
    {
        // create HTML DOM
        $seasonStart = '20120716'; //TODO: make this dynamic
        $today = date('Ymd');
        $ESPNlink = 'http://games.espn.go.com/ffl/recentactivity?leagueId='.$_REQUEST['ESPNid'].'&activityType=2&startDate='.$seasonStart.'&endDate='.$today.'&teamId=-1&tranType=4';
        
        $html = file_get_html($ESPNlink);

        // get transactions from table
            foreach($html->find('table.tableBody') as $table) 
            {
                foreach($table->find('tr') as $row)
                {
                    // get date of transaction
                    $item['date'] = trim($row->find('td[valign="top"]', 0)->plaintext);
                    // get players
                    $item['players'] = trim($row->find('td[valign="top"]', 2)->innertext);
                    // get team1 ID from link
                    $item['team1'] = trim($row->find('td[valign="top"] a', 0)->href);
                    // get team2 ID from link
                    $item['team2'] = trim($row->find('td[valign="top"] a', 1)->href);

                    $ret[] = $item;
                }
            }
        // clean up memory
        $html->clear();
        unset($html);

        return $ret;
    }


    // -----------------------------------------------------------------------------
    // let's do this...

    // will check user_agent header...
    ini_set('user_agent', 'My-Application/2.5');

    $ret = scraping_trades();

    echo '<table border="1">';
	echo '<tr><th>Date</th><th>Players Involved</th><th colspan="2">Owners Involved</th></tr>';

    foreach($ret as $v) 
    {
        if(strlen($v['date']) > 0)
        {
            $team1 = explode('&', $v['team1']);
            $team2 = explode('&', $v['team2']);
            echo '<tr><td>'.$v['date'].'</td>';
        	echo '<td>'.$v['players'].'</td>';
            echo '<td>'.trim($team1[1], 'amp;teamId=').'</td>';
            echo '<td>'.trim($team2[1], 'amp;teamId=').'</td>';
            echo '</tr>';
            //var_dump(explode('&', $v['link']));
        }
    }
    echo '</table>';
       // print '<p><strong>VarDump: </strong><br>';
       // var_dump($ret);
       // print '<p>';
}
?>