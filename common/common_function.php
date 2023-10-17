<?php

function getShift()
 {
    date_default_timezone_set( 'Asia/Colombo' );
    // Set the timezone to Sri Lanka

    $currentHour = date( 'G' );
    // Get the current hour ( 24-hour format )

    if ( $currentHour >= 6 && $currentHour < 14 ) {
        return 'A';
    } elseif ( $currentHour >= 14 && $currentHour < 22 ) {
        return 'B';
    } else {
        return 'C';
    }
}

function today() {
    return date( 'Y-m-d' );

}

function markTime() {

    date_default_timezone_set( 'Asia/Colombo' );

    return date ( 'H:i:s' );
}

function currentTime() {
    date_default_timezone_set( 'Asia/Colombo' );
    return date( 'Y-m-d H:i:s' );
}

function convertTo24HourFormat( $time12Hour ) {

    return date( 'H:i', strtotime( $time12Hour ) );

}