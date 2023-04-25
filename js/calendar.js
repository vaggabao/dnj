// Document .ready event
$(function() {
	loadCalendar();

	$( '#form-filter' ).submit(function() {
		event.preventDefault();
		loadCalendar();
	});
});

// Functions

// Display calendars
function loadCalendar() {
	var start_month = $( '#start-month-select' ).val();
	var start_year = $( '#start-year-text' ).val();
	var end_month = $( '#end-month-select' ).val();
	var end_year = $( '#end-year-text' ).val();
	var data = 'start_month=' + start_month + '&start_year=' + start_year + '&end_month=' + end_month + '&end_year=' + end_year;
	$.ajax({
		type: 'GET',
		data: data,
		url: 'includes/drawCalendar.php',
		success: function(result) {
			$( '#calendar-div' ).html(result).hide();
			$( '#calendar-div' ).html(result).show("fade");
			markCalendar();
		},
	});
}

// Mark calendar dates reflecting data in the database
function markCalendar() {

	// Setup ajax to get all dates in the database
	var dates = function() {
		var tmp = null;
		$.ajax({
			async: false,
			url: 'includes/getDates.php',
			success: function(result) {
				tmp = $.parseJSON(result);
			},
		});
		return tmp;
	}();
	var one_day = 24*60*60*1000;
	var three_days = one_day * 3;

	// Loop to all dates
	for (var i = 0; i < dates.length; i++) {
		var date_set = dates[i];
		var date1 = (date_set.StartDate).split("-");
		var date2 = (date_set.EndDate).split("-");
		
		var start_date = new Date(date1[0], date1[1] - 1, date1[2]);
		var end_date = new Date(date2[0], date2[1] - 1, date2[2]);
		var cid = date_set.ID;
		var tid = date_set.TID;

		var date_set_status = date_set.Status;
		var dates_between = getDates(start_date, end_date);
		var date_class = "";

		for (var j = 0; j < dates_between.length; j++) {
			if (j == 0) {
				if (date_set_status == "unavailable") {
					date_class = "un-start";
				} else if (date_set_status == "occupied") {
					date_class = "occ-start";
				} else if (date_set_status == "reserved") {
					date_class = "res-start";
				}
			} else if (j == dates_between.length - 1) {
				if (date_set_status == "unavailable") {
					date_class = "un-end";
				} else if (date_set_status == "occupied") {
					date_class = "occ-end";
				} else if (date_set_status == "reserved") {
					date_class = "res-end";
				}
			} else {
				if (date_set_status == "unavailable") {
					date_class = "un-selected";
				} else if (date_set_status == "occupied") {
					date_class = "occ-selected";
				} else if (date_set_status == "reserved") {
					date_class = "res-selected";
				}
			}

			var day = dates_between[j].getDate();
			var month = dates_between[j].getMonth() + 1;
			var year = dates_between[j].getFullYear();
			
			day = (day > 9 ? day : "0" + day);
			month = (month > 9 ? month : "0" + month);
			var date_id = "#" + year + "-" + month + "-" + day;

			if ($(date_id).length == 1) {
				$(date_id).addClass(date_class);
				$(date_id).addClass("display-info");
				$(date_id).attr("data-cid", cid);
				$(date_id).attr("data-start-date", start_date.toDateString());
				$(date_id).attr("data-end-date", end_date.toDateString());
				$(date_id).attr("data-status", date_set_status);
				$(date_id).attr("data-tid", tid);
				$(date_id).removeClass("selectable");
			}
		}
	}
}

// Click event for calendar dates to view date info
$(document).on('click', '.display-info', function() {
	var e = this;
	var start_date = $(e).data("start-date");
	var end_date = $(e).data("end-date");
	var status = $(e).data("status");
	cid = $(e).data("cid");

	var data = "id=" + cid;
	$.ajax({
		type: 'POST',
		async: false,
		data: data,
		url: 'includes/viewDateDetails.php',
		success: function(result) {
			var content = result;
			$( '#display-info-modal' ).html(content);
		}
	});
	
	$( '#view-dates-modal' ).modal({
		show: true
	});
});

// Function to get inclusive dates in two dates
function getDates(startDate, endDate) {
    var dateArray = new Array();
    var currentDate = startDate;
    while (currentDate <= endDate) {
        dateArray.push(currentDate)
        currentDate = currentDate.addDays(1);
    }
    return dateArray;
}

// Function for Date.addDays()
Date.prototype.addDays = function(days) {
    var dat = new Date(this.valueOf())
    dat.setDate(dat.getDate() + days);
    return dat;
}