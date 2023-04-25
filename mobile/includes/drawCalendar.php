<?php 
    date_default_timezone_set('Asia/Manila');

    $start_month = $_GET['start_month'];
    $start_year = $_GET['start_year'];
    $start_date = $start_year . "-" . $start_month . "-01";


    $end_month = $_GET['end_month'];
    $end_year = $_GET['end_year'];
    $end_date = $end_year . "-" . $end_month . "-01";

    $dates_valid = false;

    $dates_valid = checkdate($start_month, 01, $start_year);
    $dates_valid = $dates_valid && checkdate($end_month, 01, $end_year);
    
    $diff = strtotime($end_date) - strtotime($start_date);

    if ($diff < 0) {
        $dates_valid = $dates_valid && false;
    }


    if ($dates_valid) {

        $time_start = strtotime($start_date);
        $time_end = strtotime($end_date);

        $year_start = date('Y', $time_start);
        $year_end = date('Y', $time_end);

        $month_start = date('m', $time_start);
        $month_end = date('m', $time_end);

        $diff = (($year_end - $year_start) * 12) + ($month_end - $month_start);

        load_calendar($start_month, $start_year, $diff);
    } else {
        load_min_calendar();
    }


    function load_min_calendar() {
        $month = date("m");
        $year = date("Y");

        for($x = 0; $x < 6; $x++):
            if ($x%2 == 0) {
                echo "<div class='row calendar-set'>";
                echo "<div class='col-sm-6'>" . draw_calendar($month, $year) . "</div>";
            } else if ($x%2 == 1) {
                echo "<div class='col-sm-6'>" . draw_calendar($month, $year) . "</div>";
                echo "</div>";
            }

            if ($month < 12) {
                $month++;
            } else {
                $month = 1;
                $year++;
            }
        endfor;        
    }

    function load_calendar($start_month, $start_year, $count_month) {
        $month = $start_month;
        $year = $start_year;

        for($x = 0; $x <= $count_month; $x++):
            if ($x%3 == 0) {
                echo "<div class='row calendar-set clearfix'>";
                echo "<div class='col-lg-6'>" . draw_calendar($month, $year) . "</div>";
            } else if ($x%3 == 2) {
                echo "<div class='col-lg-6'>" . draw_calendar($month, $year) . "</div>";
                echo "</div>";
            } else {
                echo "<div class='col-lg-6'>" . draw_calendar($month, $year) . "</div>";
            }

            if ($month < 12) {
                $month++;
            } else {
                $month = 1;
                $year++;
            }
        endfor;        
    }

    function draw_calendar($month, $year) {
        date_default_timezone_set('UTC');
        
        // Draw table for Calendar 
        $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

        // Draw Calendar table headings 
        $monthYear = '<tr class=calendar-row><td class="calendar-day-header" colspan="7">' . date('F Y', mktime(0, 0, 0, $month, 1, $year)) . '</td></tr>';
        $calendar .= $monthYear;
        $headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
        $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

        //days and weeks variable for now ... 
        $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
        $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
        $days_in_this_week = 1;
        $day_counter = 0;
        $dates_array = array();

        // row for week one 
        $calendar .= '<tr class="calendar-row">';

        // Display "blank" days until the first day of the current month 
        for($x = 0; $x < $running_day; $x++):
            $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
            $days_in_this_week++;
        endfor;

        $month = ($month < 9 && strlen($month) < 2 ? "0" . $month : $month);
        // Show days.... 
        for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
            if($list_day == date('d') && $month == date('n')) {
                $currentday =' currentday';
            } else {
                $currentday = '';
            }

            $day = ($list_day > 9 ? $list_day : "0" . $list_day);
            $currentdate = $year . '-' . $month . '-' . $day;
            $calendar .= '<td id="' . $currentdate . '" class="calendar-day selectable' . $currentday . '" id="' . $currentdate . '">' . $list_day . '</td>';
          
            if ($running_day == 6):
                $calendar .= '</tr>';
                if (($day_counter + 1) != $days_in_month):
                    $calendar .= '<tr class="calendar-row">';
                endif;

                $running_day = -1;
                $days_in_this_week = 0;
            endif;

            $days_in_this_week++;
            $running_day++;
            $day_counter++;
        endfor;

        // Finish the rest of the days in the week
        if ($days_in_this_week < 8):
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
            endfor;
        endif;

        // Draw table final row
        $calendar .= '</tr>';

        // Draw table end the table 
        $calendar .= '</table>';
        
        // Finally all done, return result 
        return $calendar;
    }
?>