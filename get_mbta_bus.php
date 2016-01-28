<?php
$schedules = array();
date_default_timezone_set('America/New_York'); // To shut up the goddamn PHP warnings.
// How many trips to get from the API.
$trips = 3;
// Bus Info
// Get Bus 9 Info.
$json = file_get_contents("http://realtime.mbta.com/developer/api/v2/schedulebystop?api_key=XahaEaaGUUiW5hyVFwgKzw&format=json&stop=36538&route=9&max_trips=" . $trips);
$schedules['bus']['bus_9'] = json_decode($json);
// Get Bus SL4 Info.
$json = file_get_contents("http://realtime.mbta.com/developer/api/v2/schedulebystop?api_key=XahaEaaGUUiW5hyVFwgKzw&format=json&stop=5098&route=751&max_trips=" . $trips);
$schedules['bus']['bus_CT4'] = json_decode($json);
// Get Bus SL5 Info.
$json = file_get_contents("http://realtime.mbta.com/developer/api/v2/schedulebystop?api_key=XahaEaaGUUiW5hyVFwgKzw&format=json&stop=5098&route=749&max_trips=" . $trips);
$schedules['bus']['bus_CT5'] = json_decode($json);
$now = time();
?>
<h2>Next Bus</h2>
<?php foreach ($schedules['bus'] as $schedule): ?>
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
