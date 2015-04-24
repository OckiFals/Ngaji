<?php

/**
 * Format the date!
 * @param $date : date string
 * @return string: date format id encode
 */
function date_format_id($date) {
    setlocale(LC_TIME, 'id-ID');
    $phpdate = strtotime($date);
    $arrayMonth = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei'
        , 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $format_date = date('d', $phpdate) . '-' . $arrayMonth[(int)date('m', $phpdate)]
        . '-' . date('Y', $phpdate) . ', ' . date('H:i', $phpdate);

    return $format_date;
}

/**
 * Draws a calendar
 * @param $month : specifict month
 * @param $year : specifict year
 * @param array $list_schedule : (optional) Ustadz' reserved Schedule PDO object
 * @param array $available_sc : (optional) Ustadz' available Schedule PDO object
 * @return string : An ecsaping HTML calendar table
 */
function draw_calendar($month, $year, $list_schedule = Array(), $available_sc = Array()) {

    /* parse schedule data in arrays */
    $array_sc = [];
    foreach ($list_schedule as $key => $value) {
        $pointer = (int) date('j', strtotime($value['jadwal']));
        $array_sc[$pointer] = array($value);
        print($pointer . " \n");
    }

    foreach ($available_sc as $key => $value) {
        $pointer = (int) date('j', strtotime($value['jadwal']));
        //$array_sc[$pointer] = $value;
        print($pointer . " \n");
    }

//    for ($i=0; $i<30; $i++) {
//        if (array_key_exists($i, $array_sc)) {
//            echo $i . " \n ";
//            echo $array_sc[$i]['jadwal'];
//        }
//    }

    /* draw table */
    $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

    /* table headings */
    $headings = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' .
        implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

    /* days and weeks vars now ... */
    $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
    $days_in_this_week = 1;
    $day_counter = 0;

    /* row for week one */
    $calendar .= '<tr class="calendar-row">';

    /* print "blank" days until the first of the current week */
    for ($i = 0; $i < $running_day; $i++) {
        $calendar .= '<td class="calendar-day-np"> </td>';
        $days_in_this_week++;
    }

    /* keep going with days.... */
    for ($list_day = 1, $pointer1 = 0; $list_day <= $days_in_month; $list_day++) {
        $calendar .= '<td class="calendar-day">';
        /* add in the day number */
        $calendar .= '<div class="day-number">' . $list_day . '</div>';

        /*
        * TODO cari cara yang lebih efisien
        * FIXME Undefined offset: @strtotime
        */
        if (array_key_exists($list_day, $array_sc)) {
            $calendar .= '<div class="schedule-border reserved">'
                . $array_sc[$list_day]['panggilan'] . " " .
                date('H:i', @strtotime($array_sc[$list_day]['jadwal'])) .
                '</div>';
        }

        if ($list_day == date('j', @strtotime($available_sc[$pointer1]['jadwal']))) {
            $calendar .= '<div class="schedule-border available">' .
                date('H:i', @strtotime($available_sc[$pointer1]['jadwal'])) .
                '</div>';
            $pointer1++;
        }


        $calendar .= '</td>';
        if ($running_day == 6) {
            $calendar .= '</tr>';
            if (($day_counter + 1) != $days_in_month) {
                $calendar .= '<tr class="calendar-row">';
            }
            $running_day = -1;
            $days_in_this_week = 0;
        }
        $days_in_this_week++;
        $running_day++;
        $day_counter++;
    }
    /* finish the rest of the days in the week */

    if ($days_in_this_week < 8) {
        for ($x = 1; $x <= (8 - $days_in_this_week); $x++) {
            $calendar .= '<td class="calendar-day-np"> </td>';
        }
    }

    /* final row */
    $calendar .= '</tr>';

    /* end the table */
    $calendar .= '</table>';

    /* all done, return result */
    return $calendar;
}