<?php
    date_default_timezone_set('America/New_York'); // To shut up the goddamn PHP warnings.
// Get current weather.
$json = file_get_contents("http://api.openweathermap.org/data/2.5/weather?id=4930956&mode=json&units=imperial&appid=efbd3fc7b35aeb6536a328940e2a4692");
$obj = json_decode($json);
$weather = array();
$weather_now['temp'] = round($obj->main->temp);
$weather_now['info'] = $obj->weather[0]->main;
$weather_now['icon'] = $obj->weather[0]->icon;
// Get weekly weather.
    $json = file_get_contents("http://api.openweathermap.org/data/2.5/forecast/daily?id=4930956&mode=json&units=imperial&appid=efbd3fc7b35aeb6536a328940e2a4692");
    $obj = json_decode($json);
    foreach($obj->list as $day) {
      $date = date('l', $day->dt);
      $weather[$date]['temp'] = round($day->temp->day);
      $weather[$date]['weather'] = $day->weather[0]->main;
      $weather[$date]['icon'] = $day->weather[0]->icon;
      $code = $day->weather[0]->id;
      if ((600 <= $code) && ($code <= 699)) {
        $weather[$date]['weather'] = ucwords($day->weather[0]->description);
        $weather[$date]['snow'] = round($day->snow) . '"';
      }
    }

?>
<div class="weather-now" style="background: url('weather_icons/<?php print $weather_now['icon']; ?>_slim.png') no-repeat;">
  <span id="temp"><?php print $weather_now['temp']; ?>&deg;</span><br>
  <span id="info"><?php print $weather_now['info']; ?></span>
</div>
<dl class="weather">
<?php foreach($weather as $day=>$info): ?>
  <dt>
    <img class="weather" src="weather_icons/<?php print $info['icon']; ?>_slim.png" />
    <strong><?php print $day; ?></strong>
  </dt>
  <dd>
    <?php print $info['temp']; ?>&deg;
    <?php print $info['weather']; ?>
    <?php print (isset($info['snow']) ? '(' . $info['snow'] . ')' : '')?>
  </dd>
<?php endforeach; ?>
</dl>
