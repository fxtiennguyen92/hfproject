function countdown(fromTime, endTime) {
	var endTime = new Date(endTime).getTime();
	var fromTime = new Date(fromTime).getTime();
	var distance = fromTime - endTime;

	var x = setInterval(function() {
		var hours = Math.floor(distance / (1000 * 60 * 60 ));
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);
		
		$('#clockdiv .hours > span').html(hours);
		$('#clockdiv .minutes > span').html(minutes);
		$('#clockdiv .seconds > span').html(seconds);
		
		if (distance < 0) {
			clearInterval(x);
		}
		
		distance = distance - 1000;
	}, 1000);
}