$(function() {
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
        onSelect: rangeAvailability
    });

    // Function to check if the selected dates were available
    function rangeAvailability() {
        var available = false;
        var errMsg = "";
        var start = $( '#startDate' ).val();
        var end = $( '#endDate' ).val();
        var oneDay = 24*60*60*1000;
        var threeDays = oneDay * 3;

        // Check if there are dates selected
        if(start != "" && end != "") {
            // Parse dates
            var start = new Date($( '#startDate' ).val());
            var end = new Date($( '#endDate' ).val());

            var diff = end.getTime() - start.getTime();     // Get date difference

            if (diff < 0) {
                available = false;
                errMsg = "Arrive date must be before the depart date for at least 3 days of stay. Please select correct date inputs.";
            } else if ((diff >= 0) && (diff < threeDays)) {
                available = false;
                errMsg = "Your stay must be at least 3 days.";
            } else {
                var dateRange = getDates(start, end);   // Get dates within the start date and end date selected

                for(var i = 0; i < dateRange.length; i++) {     // Loop all dates within the selected dates
                    for (var j = 0; j < unavailable.length; j++) {      // Loop to all unavailable dates array
                        var dates = unavailable[j];
                        var unavail = dateBetween(dates.StartDate, dates.EndDate, dateRange[i]);

                        if (unavail == true) {
                            available = false;          // Set flag to false
                            i = dateRange.length;       // End i loop
                            j = unavailable.length;     // End j loop
                        } else {
                            available = true;
                        }
                    }
                }
            }

            // Add or remove class
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

    // Function to get dates within a date range
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

    // Check if dates in the range selected are available
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

    // Check availability of the dates in datepickers
    function checkAvailability(date) {
        var day, month, year, check;
        day = (date.getDate() < 10) ? "0" + date.getDate() : date.getDate();
        month = ((date.getMonth() + 1) < 10) ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
        year = date.getFullYear();
        check = year + "-" + month + "-" + day;

        // Loop to all unavailable dates array
        for (var i = 0; i < unavailable.length; i++) {
            var dates = unavailable[i];
            var unavail = dateCheck(dates.StartDate, dates.EndDate, check);
            if (unavail == true) {
                return [false, 'disabled'];
            }
        }
        return [true, 'enabled'];
    }

    // Check if dates in datepickers are within the start and end dates in the array
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

    // Show booking dialog
    $( '#bookDialog' ).dialog({
        dialogClass: 'no-close',
        autoOpen: false,
        modal: true,
        width: 400,
        show: {
            effect: 'fade',
            duration: 400
        },
        hide: {
            effect: 'fade',
            duration: 400
        }
    });

    $( '#btnBook' ).click(function() {
        event.preventDefault();
        $( '#bookDialog' ).dialog( 'open' );
    });
});