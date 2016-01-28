function loadlink(){
    $('.mbta-bus-info').load('get_mbta_bus.php',function () {
    });
    $('.mbta-train-info').load('get_mbta_train.php',function () {
    });
}

loadlink(); // This will run on page load
setInterval(function(){
    loadlink() // this will run every 30 seconds
}, 30000);