
if (localStorage.getItem("show_lock_screen") == "true") {
        $("#modal").modal("show");
}

setIdleTimeout(600000000, function() {
    if (localStorage.getItem("show_lock_screen") != "true"){// && localStorage.getItem("monitor_login") != "1") {
        localStorage.setItem("show_lock_screen", "true");
        /*$.get("ajax/last_screen.php", function(data, status){
        localStorage.setItem("show_lock_screen", "true");
        localStorage.setItem("last_screen", data);
    });*/
        
    }
    
    $("#modal").modal("show");
		//window.location.href ="lock.php";
   // $("#msg").text("Why you leave me?");
}, function() {
	//alert ('unidle function was called');
	
	//window.location.href ="dashboard.php";;
   // $("#msg").text("Welcome back!");
});



function setIdleTimeout(millis, onIdle, onUnidle) {
    var timeout = 0;
    $(startTimer);

    function startTimer() {
        timeout = setTimeout(onExpires, millis);
        $(document).on("mousemove keypress", onActivity);
    }
    
    function onExpires() {
        timeout = 0;
        onIdle();
    }

    function onActivity() {
        if (timeout) clearTimeout(timeout);
        else onUnidle();
        //since the mouse is moving, we turn off our event hooks for 1 second
        $(document).off("mousemove keypress", onActivity);
        setTimeout(startTimer, 1000);
    }
}
