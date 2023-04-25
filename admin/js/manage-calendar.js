// Global variables
var cid = "";
var startDate = "";
var endDate = "";
var select_start = false;
var oneDay = 24*60*60*1000;
var threeDays = oneDay * 3;


// MODAL EVENTS
$(function() {
	// Hide event for save date modal
	$('#save-dates-modal').on('hidden.bs.modal', function () {
		startDate = "";
		endDate = "";
		select_start = false;
		removeSelection();
	});

	// Submit event for save date modal
	$( '#form-save' ).submit(function() {
		event.preventDefault();

		// Change elements attributes
		$( '#loader' ).show();
		$( '#save-title' ).html("Saving...");
		$( '#form-save-fieldset' ).prop('disabled', true);

		// Setup ajax to insert data to database
		var start_date = startDate.toLocaleDateString('en-US');
		var end_date = endDate.toLocaleDateString('en-US');
		var status = $( '#status-select' ).val();
		var data = 'start_date=' + start_date + '&end_date=' + end_date + '&status=' + status;
		
		$.ajax({
			type: 'POST',
			data: data,
			async: false,
			url: 'includes/saveDates.php',
			success: function(result) {
				if(result == 1) {
					$( '#save-title' ).html("Save successful.");
					$( '#loader' ).hide();
					loadCalendar();
				} else {
					alert("The dates you selected are no longer available.");
					$( '#loader' ).hide();
					$( '#save-title' ).html("Saving has failed.");
				}
				setTimeout(function() {
					$( '#save-title' ).html("Save date");
					$( '#form-save-fieldset' ).prop('disabled', false);
					$( '#save-dates-modal' ).modal('hide');
				}, 1500);
			},
		});
	});

	// 
	// $( '#btn-make-available' ).click(function() {
	$(document).on('click', '#btn-make-available', function() {
		// Change element attributes
		$( '#view-dates-modal #loader' ).show();
		$( '#view-title' ).html("Updating calendar...");
		$( '#form-view-fieldset' ).prop('disabled', true);

		var data = 'cid=' + cid;
		$.ajax({
			type: 'POST',
			data: data,
			url: 'includes/makeAvailable.php',
			success: function(result) {
				var content = result;
				$( '#view-dates-modal #loader' ).hide();
				if(result) {
					$( '#view-title' ).html("Update successful");
				}

                $( '#alert-div' ).html(content);
				loadCalendar();
				setTimeout(function() {
					$( '#view-title' ).html("Date Information");
					$( '#form-view-fieldset' ).prop('disabled', false);
					$( '#view-dates-modal' ).modal('hide');
				}, 1500);
			},
		});
	});
});


// CALENDAR EVENTS

// When escape key is pressed, cancel date selection
$(document).keyup(function(e) {
	if (e.keyCode == 27) {
		var open = $( '#save-dates-modal' ).is( ':visible' );
		if (select_start && !open) {
			startDate = "";
			endDate = "";
			select_start = false;
			removeSelection();
		}
	}
});

// Click event for calendar dates to start date selection
$(document).on('click', '.selectable', function() {
	var e = this;
	var date = (e.id).split("-");
	if (startDate == '' && select_start === false) {
		select_start = true;
		startDate = new Date(date[0], date[1] - 1, date[2]);
		startCell(e);
	}
});


// Click event for the selected end date
$(document).on('click', '.sel-end', function() {
	var e = this;
	var date = (e.id).split("-");
	endDate = new Date(date[0], date[1] - 1, date[2]);
	
	var start_date = new Date(startDate);
	var end_date = new Date(endDate);
	var dates_between = getDates(start_date, end_date);

		for (var i = 0; i < dates_between.length; i++) {
			if ((i != 0) && (i != dates_between.length - 1)) {
				var day = dates_between[i].getDate();
				day = (day > 9 ? day : "0" + day);
				var month = dates_between[i].getMonth() + 1;
				month = (month > 9 ? month : "0" + month);
				var year = dates_between[i].getFullYear();
				var date_id = year + '-' + month + '-' + day;
				selectCell(date_id);					
			}
		}
	endCell(e);
	$( '#start-date-static' ).html(startDate.toDateString());
	$( '#end-date-static' ).html(endDate.toDateString());
	$( '#save-dates-modal' ).modal({
		show: true
	});
});

// Hover event to select inclusive dates in start and end dates selected
$(document).on('mouseover', '.selectable', function() {
	var e = this;
	if (startDate != '' && select_start === true) {
		var date = (e.id).split("-");

		var dateHover = new Date(date[0], date[1] - 1, date[2]);
		var diff = dateHover.getTime() - startDate.getTime();

		if (diff > 0) {
			var start_date = new Date(startDate);
			var end_date = new Date(dateHover);
			var dates_between = getDates(start_date, end_date);

			$('.selected.sel-hover').removeClass('selected sel-hover');
			for (var i = 0; i < dates_between.length; i++) {
				if ((i != 0) && (i != dates_between.length - 1)) {
					var day = dates_between[i].getDate();
					day = (day > 9 ? day : "0" + day);
					var month = dates_between[i].getMonth() + 1;
					month = (month > 9 ? month : "0" + month);
					var year = dates_between[i].getFullYear();
					var date_id = year + '-' + month + '-' + day;
					selectCell(date_id);					
				}
				endCell(e);
			}
		}

	}
});

// Functions to change calendar dates css
function startCell(e) {
	$(e).removeClass('selectable');
	$(e).addClass('selected sel-start');
}

function selectCell(id) {	
	$('#' + id).addClass('selected sel-hover');
}

function endCell(e) {
	$('.selected.sel-end').attr('class', 'calendar-day selectable');
	$(e).removeClass('selectable');
	$(e).addClass('selected sel-end');
}

function removeSelection() {
	$( '.selected.sel-start' ).not('.occ-start, .res-start, .un-start').attr('class', 'calendar-day selectable');
	$( '.selected.sel-hover' ).not('.occ-start, .res-start, .un-start, .occ-selected, .res-selected, .un-selected, .occ-end, .res-end, .un-end').attr('class', 'calendar-day selectable');
	$( '.selected.sel-end' ).not('.occ-end, .res-end, .un-end').attr('class', 'calendar-day selectable');
}