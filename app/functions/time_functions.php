<?php

function getYear($timestamp){
	$timezone = 'Europe/Istanbul';
	$t = new DateTime();
	$t->setTimestamp($timestamp);
	$t->setTimeZone(new DateTimeZone($timezone));
	return $t->format('Y');
}
function getMonth($timestamp){
	$timezone = 'Europe/Istanbul';
	$t = new DateTime();
	$t->setTimestamp($timestamp);
	$t->setTimeZone(new DateTimeZone($timezone));
	return $t->format('m');
}
function getDay($timestamp){
	$timezone = 'Europe/Istanbul';
	$t = new DateTime();
	$t->setTimestamp($timestamp);
	$t->setTimeZone(new DateTimeZone($timezone));
	return $t->format('d');
}
function getHour($timestamp){
	$timezone = 'Europe/Istanbul';
	$t = new DateTime();
	$t->setTimestamp($timestamp);
	$t->setTimeZone(new DateTimeZone($timezone));
	return $t->format('H');
}
function getMinute($timestamp){
	$timezone = 'Europe/Istanbul';
	$t = new DateTime();
	$t->setTimestamp($timestamp);
	$t->setTimeZone(new DateTimeZone($timezone));
	return $t->format('i');
}
function getSecond($timestamp){
	$timezone = 'Europe/Istanbul';
	$t = new DateTime();
	$t->setTimestamp($timestamp);
	$t->setTimeZone(new DateTimeZone($timezone));
	return format('s');
}
function simpleHour($timestamp){
	return getHour($timestamp).":".getMinute($timestamp);
}
function simpleDay($timestamp){
	return getDay($timestamp)."/".getMonth($timestamp)."/".getYear($timestamp);;
}
function simpleDate($timestamp){
	return simpleHour($timestamp)." ".simpleDay($timestamp);
}

function secsToTime($secs, $firstnunit=false) {
	$units = array(
		"hafta"   => 7*24*3600,
		"gün"    =>   24*3600,
		"saat"   =>      3600,
		"dakika" =>        60,
		"saniye" =>         1,
		);
	// specifically handle zero
	if ( $secs == 0 ) { return "0 saniye"; }
	$s = "";
	if (!$firstnunit){ $firstnunit=999; }
	foreach ( $units as $name => $divisor ) {
		if ($firstnunit==0){ break; }
		if ( $quot = intval($secs / $divisor) ) {
			$s .= "$quot $name"." ";
			$secs -= $quot * $divisor;
			$firstnunit--;
		}
	}
	return substr($s, 0, -1);
}

?>