$(function() {
    // Set initial variables
    var start_date = $( '#start-date' ).val();
    var end_date = $( '#end-date' ).val();
	
	var now = function() {
        var tmp = null;
        $.ajax({
            type: 'POST',
            async: false,
			datatype: 'json',
            url: '../includes/getDateNow.php',
            success: function(result) {
                tmp = result;
            }
        });
        return tmp;
    }();
    var one_day = 24*60*60*1000;
	
	var	min_date, max_date;
	
	
	if ($( '#extension-date' ).length > 0) {
		// Setup ajax to get all dates in the database
		var unavailable = function() {
			var tmp = null;
			$.ajax({
				type: 'POST',
				async: false,
				url: '../includes/getDates.php',
				success: function(result) {
					tmp = $.parseJSON(result);
				}
			});
			return tmp;
		}();
				
		min_date = (Date.parse(end_date) - Date.parse(now)) + one_day;
		max_date = (365 * one_day) + min_date;

		if(unavailable) {
            // Loop to all unavailable dates array
            for (var i = 0; i < unavailable.length; i++) {
				var date = Date.parse(unavailable[i].StartDate) - one_day - Date.parse(now);
				if (date >= (Date.parse(end_date) - Date.parse(now)) ) {
					if (date < max_date) {
						max_date = date;
					}
				}
			}
        }
		max_date = max_date/one_day;
		min_date = min_date/one_day;
					
		// Clear datepickers
		$( '#extension-date' ).val("");

		if (max_date >= min_date) {
			// Set datepickers
			$( '#extension-date' ).datepicker({
				dateFormat: 'yy-mm-dd',
				minDate: min_date + 'd',
				maxDate: (max_date == 365 ? '2y' : max_date),
				changeMonth: true,
				changeYear: true,
				prevText: '<',
				nextText: '>',
			});
		} else {
			$( '#extension-alert-div' ).show('fade', 250);
		}
	}
	
	
	if ($( '#housekeeping-date' ).length > 0) {
		min_date = (Date.parse(start_date) - Date.parse(now))/one_day;
		max_date = (Date.parse(end_date) - Date.parse(now))/one_day;
		
		// Clear datepickers
		$( '#housekeeping-date' ).val("");

		// Set datepickers
		$( '#housekeeping-date' ).datepicker({
			dateFormat: 'yy-mm-dd',
			minDate: min_date + 'd',
			maxDate: max_date,
			changeMonth: true,
			changeYear: true,
			prevText: '<',
			nextText: '>',
			beforeShowDay: checkAvailability,
		});
	}
	
    // Datepicker functions
    // enable unavailable dates only
    function checkAvailability(date) {
		min_date = (Date.parse(start_date) - Date.parse(now))/one_day;
		max_date = (Date.parse(end_date) - Date.parse(now))/one_day;	

        var day, month, year, check;
        day = (date.getDate() < 10) ? "0" + date.getDate() : date.getDate();
        month = ((date.getMonth() + 1) < 10) ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
        year = date.getFullYear();
        check = year + "-" + month + "-" + day;

        var available = dateCheck(start_date, end_date, check);
        if (available == true) {
            return [true, 'enabled'];
        }

        return [false, 'disabled'];
    }

    

    // check if dates in datepickers are within the start and end dates in the array
    function dateCheck(from, to, check) {
        var fDate, lDate, cDate;
        fDate = Date.parse(from);
        lDate = Date.parse(to);
        cDate = Date.parse(check);

        if((cDate <= lDate) && (cDate >= fDate)) {
            return true;
        }
        return false;
    }
});