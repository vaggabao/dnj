var startDate = "";
var endDate = "";
var flag = 0;
var oneDay = 24*60*60*1000;
var threeDays = oneDay * 3;

$(document).on("click", ".calendar-day", function() {
	var e = event.target;
	if (startDate == "" && flag == 0) {
		var dateNow = new Date();
		var month = dateNow.getMonth() + 1;
		var day = dateNow.getDate();
		var year = dateNow.getFullYear();

		dateNow = month + "-" + day + "-" + year;
		dateNow = new Date(dateNow);
		var dateClicked = new Date($(e).data("date"));

		var diff = dateClicked.getTime() - dateNow.getTime();

		if (diff < 0) {
			alert("Can't reserve any date before today.");
		} else {
			startDate = dateClicked;
			startCell(e);
		}
	}
});

$(document).on("click", ".endCell", function() {
	var e = event.target;
	var dateClicked = new Date($(e).data("date"));
	var diff = dateClicked.getTime() - startDate.getTime();

	if (diff < threeDays) {
		alert("Your stay must be at least 3 days.");
	} else {
		endDate = new Date(dateClicked);
		endCell(e);
		flag = 1;
		alert("You'll stay on " + startDate.toDateString() + " until " + endDate.toDateString() + " for " + diff/oneDay + " days.");
	}
});

$(document).on("mouseover", ".calendar-day", function() {
	var e = event.target;

	if (startDate != "" && flag == 0) {
		var dateHover = new Date($(e).data("date"));
		var diff = dateHover.getTime() - startDate.getTime();

		if (diff > 0) {
			var daysSelected = diff/oneDay;

			$(".selectedCell").removeClass("selectedCell");

			for (x = 1; x < daysSelected; x++) {
				var timeX = x * oneDay;
				var dayX = startDate.getTime() + timeX;
				var dateX = new Date(dayX);

				var month = dateX.getMonth() + 1;
				var day = dateX.getDate();
				var year = dateX.getFullYear();

				dateX = month + "-" + day + "-" + year;

				selectCell(dateX);
			}
			endCell(e);
		}
	}
});
	`	

function startCell(e) {
	$(e).removeClass("calendar-day currentday");
	$(e).addClass("startCell");
	// alert(e.className);
}

function selectCell(id) {
	// $("#" + id).removeClass("calendar-day currentday");	
	$("#" + id).addClass("selectedCell");
}

function endCell(e) {
	$(".endCell").addClass("calendar-day");
	$(".endCell").removeClass("endCell");
	$(e).removeClass("calendar-day currentday");
	$(e).addClass("endCell");
	// alert(e.className);
}