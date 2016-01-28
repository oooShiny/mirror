<?php

/* Base code provided by Sarah Bailey.
Case Western Reserve University, Cleveland OH.
Please do not email me for support. Post a comment instead.
Current v 1.1
Props to commenter Matt for pointing out the maxResults parameter.
*/

//TO DEBUG UNCOMMENT THESE LINES
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

//INCLUDE THE GOOGLE API PHP CLIENT LIBRARY FOUND HERE
//https://github.com/google/google-api-php-client
//DOWNLOAD IT AND PUT IT ON YOUR WEBSERVER IN THE ROOT FOLDER.
include('google-api-php-client/src/Google/autoload.php');


// To shut up the goddamn PHP warnings.
date_default_timezone_set('America/New_York');

// Create an array of all the calendars we want to include.
$calendars = array(
  'Personal' => '8oh0f694p86l6fstdr2oo7a09k@group.calendar.google.com',
  'Indoor Soccer' => '34cbq02cn1u783gd1bgtcb68alh3oggu@import.calendar.google.com',
  'Web' => 'lbh5o0vajbj6b4hp9c98137urk@group.calendar.google.com',
//  'Erin' => '8g6e1og5j84hj2i65qih5e5kovatagg0@import.calendar.google.com',
  );

// Set up the Google info they want for this to work.
$client = new Google_Client();
$client->setApplicationName("My Calendar"); //DON'T THINK THIS MATTERS
$client->setDeveloperKey('AIzaSyCX8717vc4Ro4wuBxb0vNW0oSh4_jKjO-E'); //GET AT AT DEVELOPERS.GOOGLE.COM
$cal = new Google_Service_Calendar($client);
$eventArray = array();

// Get each calendar from Google.
foreach ($calendars as $name => $id) {
  $calendarId = $id;
  //TELL GOOGLE HOW WE WANT THE EVENTS
  $now = date(DateTime::ATOM);
  $nextweek = date('c', strtotime('+1 week'));
  $params = array(
  //CAN'T USE TIME MIN WITHOUT SINGLEEVENTS TURNED ON,
  //IT SAYS TO TREAT RECURRING EVENTS AS SINGLE EVENTS
    'singleEvents' => true,
    'orderBy' => 'startTime',
    'timeMin' => $now,
    'timeMax' => $nextweek,
  );
  $events = $cal->events->listEvents($calendarId, $params);
  foreach ($events->getItems() as $event) {

    //Convert date to month and day
    $eventDateStr = $event->start->dateTime;
    if(empty($eventDateStr))
    {
      // it's an all day event
      $eventDateStr = $event->start->date;
    }

    $temp_timezone = $event->start->timeZone;
    //THIS OVERRIDES THE CALENDAR TIMEZONE IF THE EVENT HAS A SPECIAL TZ
    $eventdate = new DateTime($eventDateStr);
    $eventdate->setTimezone(new DateTimeZone('America/New_York'));
    $month = $eventdate->format("M");//CONVERT REGULAR EVENT DATE TO LEGIBLE MONTH
    $monthnum = $eventdate->format("m");
    $day = $eventdate->format("j");//CONVERT REGULAR EVENT DATE TO LEGIBLE DAY
    $weekday = $eventdate->format("D");//CONVERT REGULAR EVENT DATE TO LEGIBLE DAY
    $hour24 = $eventdate->format("H");
    $hour = $eventdate->format("g");
    $minute = $eventdate->format("i");
    $ampm = $eventdate->format("a");
    if ($hour24 == '00') {
      $newtime = '';
    } else {
      $newtime = $hour . ':' . $minute . ' ' . $ampm . '<br>';
    }
    if ($name == 'Indoor Soccer') {
      $info =  $hour . ':' . $minute . ' ' . $ampm . '<br><img src="soccer_icon.png" /> ' . $event->summary;
    } else {
      $info = $newtime . $event->summary;
    }
    $eventArray[$monthnum][$day][$hour24][$minute]['info'] = $info;
    $eventArray[$monthnum][$day][$hour24][$minute]['time'] = $eventdate;
    ksort($eventArray[$monthnum]);
    ksort($eventArray[$monthnum][$day]);
    ksort($eventArray[$monthnum][$day][$hour24]);
  }
}
//THIS IS WHERE WE ACTUALLY PUT THE RESULTS INTO A VAR
$calTimeZone = $events->timeZone; //GET THE TZ OF THE CALENDAR
print '<div class="event-container">';
//START THE LOOP TO LIST EVENTS
foreach ($eventArray as $month => $date) {
  foreach ($date as $day => $h) {
    foreach ($h as $hour => $m) {
      foreach ($m as $minute => $event) {
      ?>
        <div class="event">
          <div class="date">
            <span class="day"><?php print $event['time']->format('j'); ?></span><br>
            <span class="weekday"><?php print $event['time']->format('l'); ?></span>
          </div>
          <div class="cal_info">
            <?php print $event['info']; ?>
          </div>
        </div>
        <div style="clear: both;"></div>
      <?php
      }
    }
  }
} ?>
</div>

