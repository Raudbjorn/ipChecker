<?php

function get_client_ip() {
	$checkOrder = Array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
	foreach($checkOrder as $option){
		if($_SERVER[$option]){
				return $_SERVER[$option];
		}
	}
	return 'UNKNOWN';
}

function isInIceland(){
	$ipAddress  = get_client_ip();
	if($ipAddress == 'UNKNOWN') return false;
	$ipPieces = explode(".", $ipAddress);
	$dns = "";

	foreach(array_reverse($ipPieces) as $piece){
		if($dns == ""){
			$dns = $piece;
		} else {
			$dns = $dns . "." . $piece;
		}
	}

	$dns = $dns . '.' . "iceland.rix.is";
	$result = dns_get_record($dns);
	return $result[0]['ip'] == '127.1.0.1';
}