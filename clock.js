function clock(){
    var time = new Date()
    var hr = time.getHours()
    var min = time.getMinutes()
    var sec = time.getSeconds()
    var ampm = " pm "
    if (hr < 12){
        ampm = " pm "
    }
    if (hr > 12){
        hr -= 12
    }
    if (hr < 10){
        hr = " " + hr
    }
    if (min < 10){
        min = "0" + min
    }
    if (sec < 10){
        sec = "0" + sec
    }
    document.getElementById('clock').innerHTML = hr + ":" + min + ampm
    setTimeout("clock()", 1000)
}
