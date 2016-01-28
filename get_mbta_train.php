<style>
  .route div { padding-left: .7em; }
  .place-brdwy span.title { border-left: 5px solid red; }
  .place-tumnl span.title { border-left: 5px solid orange; }
  .place-coecl span.title { border-left: 5px solid green; }
  .place-armnl span.title { border-left: 5px solid green; }
  span.trip_1 { font-size: 400%; }
  div.trips { font-size: 50%; }
</style>
<?php
$schedules = array();
date_default_timezone_set('America/New_York'); // To shut up the goddamn PHP warnings.
// How many trips to get from the API.
$trips = 3;
// Subway Info
// Get Red Line Broadway Info.
$json = file_get_contents("http://realtime.mbta.com/developer/api/v2/schedulebystop?api_key=XahaEaaGUUiW5hyVFwgKzw&format=json&stop=place-brdwy&route=Red&max_trips=" . $trips);
$schedules['train']['red_broadway'] = json_decode($json);
// Get Orange Line Tufts Info.
$json = file_get_contents("http://realtime.mbta.com/developer/api/v2/schedulebystop?api_key=XahaEaaGUUiW5hyVFwgKzw&format=json&stop=place-tumnl&route=Orange&max_trips=" . $trips);
$schedules['train']['orange_tufts'] = json_decode($json);
// Get Green Line Copley Info.
$json = file_get_contents("http://realtime.mbta.com/developer/api/v2/schedulebystop?api_key=XahaEaaGUUiW5hyVFwgKzw&format=json&stop=place-coecl&route=Green-B&max_trips=" . $trips);
$schedules['train']['green_copley'] = json_decode($json);
// Get Green Line Arlington Info.
$json = file_get_contents("http://realtime.mbta.com/developer/api/v2/schedulebystop?api_key=XahaEaaGUUiW5hyVFwgKzw&format=json&stop=place-armnl&route=Green-B&max_trips=" . $trips);
$schedules['train']['green_arlington'] = json_decode($json);

$now = time();
?>
<h2>Next Train</h2>
<?php foreach ($schedules['train'] as $schedule): ?>
    <div class="route <?php print $schedule->mode[0]->mode_name . ' ' . $schedule->stop_id; ?>">
      <span class="title"><strong><?php print $schedule->stop_name; ?></strong></span>
      <div>
        <?php foreach ($schedule->mode[0]->route[0]->direction as $direction):
          $trip_array = explode(' to ', $direction->trip[0]->trip_name);
          ?>
          <span><?php print 'To ' . $trip_array[1]; ?>
            <div class="trips">
            <?php
            $i = 1;
            foreach($direction->trip as $trip):
              ?>
              <?php if ($trip->sch_arr_dt > $now && intval(date('i', $trip->sch_arr_dt - $now)) >= 1): ?>
                <span class="trip_<?php print $i; ?>"><?php print intval(date('i', $trip->sch_arr_dt - $now)); ?></span>
              <?php if ($i == 1) {print '<br>MINUTES<br>';} $i++; ?>
              <?php endif; ?>
            <?php endforeach; ?>
            </div>
          </span>
        <?php endforeach; ?>
      </div>
    </div>
<?php endforeach; ?>

