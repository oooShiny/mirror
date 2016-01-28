<!DOCTYPE html>
<html>
<head>
	<title>Mirror Dashboard</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="http://code.jquery.com/jquery-latest.min.js"; type="text/javascript"></script>
    <script src="refresh.js"></script>
    <script src="clock.js"></script>
  <?php
    // To shut up the goddamn PHP warnings.
    date_default_timezone_set('America/New_York');
  ?>

</head>
<body onload="clock()">

  <div class="header">
    <!-- Clock -->
    <div id="clock"></div>
  </div>
  <!-- Left Column -->
  <div class="column column-left">
    <!-- MBTA -->
    <div class="mbta-train-info">
      <?php include_once('get_mbta_train.php'); ?>
    </div>

  </div>



  <!-- Right Column -->
  <div class="column column-right">
    <!-- MBTA -->
    <div class="mbta-bus-info">
      <?php include_once('get_mbta_bus.php'); ?>
    </div>
  </div>
<div style="clear: both"></div>
  <div class="footer">
    <div class="lunch-info">
      <?php include_once('scrape_lunch.php'); ?>
    </div>
  </div>

</body>
</html>