$(function() {
    // Initial variables
    var available = false;
    var errMsg = "";
    var start = "";
    var end = "";
    var oneDay = 24*60*60*1000;
    var twoDays = oneDay * 2;
    var now = function() {
        var tmp = null;
        $.ajax({
            type: 'POST',
            async: false,
            url: '../includes/getDateNow.php',
            success: function(result) {
                tmp = result;
            },
        });
        return tmp;
    }();
    // variable for unavailable dates
    var unavailable;
	
	
    if(available === false)
        $( '#btnBook' ).prop('disabled', true);
    else
        $( '#btnBook' ).prop('disabled', false);

    // Clear datepickers
    $( '#startDate' ).val("");
    $( '#endDate' ).val("");

    // Set datepickers
    $( "#startDate" ).datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: '0',
        maxDate: '2y',
        changeMonth: true,
        changeYear: true,
        prevText: '<',
        nextText: '>',
        beforeShowDay: checkAvailability,
		beforeShow: getUnavailable,
        onSelect: rangeAvailability
    });

    $( "#endDate" ).datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: '0',
        maxDate: '2y',
        changeMonth: true,
        changeYear: true,
        prevText: '<',
        nextText: '>',
        beforeShowDay: checkAvailability,
		beforeShow: getUnavailable,
        onSelect: rangeAvailability
    });
	
	/**
	 * Get dates from calendar table
	 */
	function getUnavailable() {
		unavailable = function() {
        var tmp = null;
        $.ajax({
            type: 'POST',
            async: false,
            url: '../includes/getDates.php',
            success: function(result) {
                tmp = $.parseJSON(result);
            },
        });
        return tmp;
    }();
	}


    // Datepicker functions
    // disable unavailable dates
    function checkAvailability(date) {
        var day, month, year, check;
        day = (date.getDate() < 10) ? "0" + date.getDate() : date.getDate();
        month = ((date.getMonth() + 1) < 10) ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
        year = date.getFullYear();
        check = year + "-" + month + "-" + day;

        if(unavailable) {
            // Loop to all unavailable dates array
            for (var i = 0; i < unavailable.length; i++) {
                var dates = unavailable[i];
                var unavail = dateCheck(dates.StartDate, dates.EndDate, check);
                if (unavail == true) {
                    return [false, 'disabled'];
                }
            }
        } else if(!unavailable) {
            var date_now = Date.parse(now);

            check = Date.parse(check);

            if (check <= date_now) {
                return [false, 'disabled'];
            }
        }

        return [true, 'enabled'];
    }

    // check if selected dates were available
    function rangeAvailability() {
        start = $( '#startDate' ).val();
        end = $( '#endDate' ).val();

        // Check if there are dates selected
        if(start != "" && end != "") {
            // Parse dates
            var start = new Date($( '#startDate' ).val());
            var end = new Date($( '#endDate' ).val());

            var diff = end.getTime() - start.getTime();
            // if (diff >= 0) {
				// diff = diff + oneDay;     // Get date difference
            // }

            if (diff < 0) {
                available = false;
                errMsg = "Arrive date must be before the depart date for at least 2 days of stay. Please select correct date inputs.";
            } else if ( (diff >= 0) && (diff < twoDays) ) {
                available = false;
                errMsg = "Your stay must be at least 2 days.";
            } else {
                available = true;
                if(unavailable) {
                    var dateRange = getDates(start, end);   // Get dates within the start date and end date selected

                    for(var i = 0; i < dateRange.length; i++) {     // Loop all dates within the selected dates
                        for (var j = 0; j < unavailable.length; j++) {      // Loop to all unavailable dates array
                            var dates = unavailable[j];
                            var unavail = dateBetween(dates.StartDate, dates.EndDate, dateRange[i]);

                            if (unavail == true) {
                                available = false;          // Set flag to false
                                errMsg = "The dates you selected are not available";
                                i = dateRange.length;       // End i loop
                                j = unavailable.length;     // End j loop
                            }
                        }
                    }
                }
            }

            // add or remove class
            if(available == true) {
                $( '#startDiv' ).removeClass("has-error");
                $( '#endDiv' ).removeClass("has-error");
                $( '#btnBook' ).prop('disabled', false);
                $( '#errMsg' ).hide("slide");
            } else {
                $( '#startDiv' ).addClass("has-error");
                $( '#endDiv' ).addClass("has-error");
                $( '#btnBook' ).prop('disabled', true);
                $( '#errMsg' ).html(errMsg).show("fade");
            }
        }
    }

    // get dates within a date range
    function getDates(startDate, endDate) {
        var dateArray = new Array();
        var currentDate = startDate;
        while (currentDate <= endDate) {
            dateArray.push(currentDate)
            currentDate = currentDate.addDays(1);
        }
        return dateArray;
    }

    // Date.addDays()
    Date.prototype.addDays = function(days) {
        var dat = new Date(this.valueOf())
        dat.setDate(dat.getDate() + days);
        return dat;
    }

    // check if date is between two dates
    function dateBetween(from, to, check) {

        // Parsing dates
        var fDate, lDate, cDate;
        fDate = Date.parse(from);
        lDate = Date.parse(to);
        cDate = Date.parse(check);

        // Comparison of dates
        if((cDate <= lDate) && (cDate >= fDate)) {
            return true;
        }
        return false;
    }

    // check if dates in datepickers are within the start and end dates in the array
    function dateCheck(from, to, check) {
        var day, month, year, nDate;
        nDate = new Date();
        day = (nDate.getDate() < 10) ? "0" + nDate.getDate() : nDate.getDate();
        month = ((nDate.getMonth() + 1) < 10) ? "0" + (nDate.getMonth() + 1) : (nDate.getMonth() + 1);
        year = nDate.getFullYear();
        nDate = year + "-" + month + "-" + day;
        nDate = Date.parse(nDate);

        var fDate, lDate, cDate;
        fDate = Date.parse(from);
        lDate = Date.parse(to);
        cDate = Date.parse(check);

        if((cDate <= lDate) && (cDate >= fDate) || (cDate <= nDate)) {
            return true;
        }
        return false;
    }

});