<?php
require_once('../../simple_html_dom.php');

function scraping_teams() {
    // create HTML DOM

    // TODO: Get league ID from...somewhere?
    $html = file_get_html('http://games.espn.go.com/ffl/standings?leagueId=198429');

    $c = 0;
    // get standings tables
    while($c < 4){
        $search = 'table#xstandTbl_div'.$c.' tr';
        foreach($html->find($search) as $table) {
            // get team name
            $item['team'] = trim($table->find('a', 0)->plaintext);
            // get owner
            $item['owner'] = trim($table->find('a', 1)->plaintext);
            // get team ID from link
            $item['link'] = trim($table->find('a', 0)->href);
            
            // get points for
            $item['PF'] = trim($table->find('td.sortablePF', 0)->plaintext);
            // get points against
            $item['PA'] = trim($table->find('td.sortablePA', 0)->plaintext);

            if(($item['team'] == 'PF')||($item['owner'] == 'PA')){
                
            }else{
                $ret[] = $item;
            }
        }
        $c++;
    }
    // clean up memory
    $html->clear();
    unset($html);

    return $ret;
}


// -----------------------------------------------------------------------------
// run it!

// TODO: change league ID to variable gotten from...somewhere.

$getTeams = "SELECT node.nid, node.vid, 
            team.field_espn_team_id_value AS teamID,
            node.title,
            league.field_espn_league_id_value AS leagueID
            FROM node node
            LEFT JOIN field_data_field_espn_league_id league ON node.nid = league.entity_id
            LEFT JOIN field_data_field_espn_team_id team ON node.nid = team.entity_id
            WHERE node.type = 'team'
            AND league.field_espn_league_id_value = 198429
            ORDER BY team.field_espn_team_id_value ASC";
$gotTeams = db_query($getTeams);
//print $getTeams;

if(is_array($gotTeams))
{
    print '<ul>';
    foreach($gotTeams AS $eachTeam)
    {
        print '<li>('.$eachTeam['teamID'].') '.$eachTeam['title'].' from league #'.$eachTeam['leagueID'].'</li>';
    }
    print '</ul>';
}
else
{
    print "Nope: " var_dump($gotTeams);
}

// will check user_agent header...
ini_set('user_agent', 'My-Application/2.5');
$ret = scraping_teams();
$i = 1;
    echo '<table border="1">';
    echo '<tr><th>Team Name</th><th>Owner</th><th>Team ID</th><th>Points For</th><th>Points Against</th>';
foreach($ret as $v) {
    if(strlen($v['team']) > 0){
        $teamID = explode('&', $v['link']);
        echo '<tr><td>'.$v['team']
        ;
        echo ' </td><td>'.$v['owner'].'</td>';
        echo '<td>'.trim($teamID[1], 'amp;teamId=').'</td>';
        echo '<td>'.$v['PF'].'</td><td>'.$v['PA'].'</td>';
        echo '</tr>';
        //var_dump(explode('&', $v['link']));
    }
    $i++;
}
    echo '</table>';
    // var_dump($ret);
?>