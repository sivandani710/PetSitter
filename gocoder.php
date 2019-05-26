<?php

function getDistance($from_latitude, $from_longitude, $to_latitude, $to_longitude){
    $geo_coder_url = 'https://route.api.here.com/routing/7.2/calculateroute.xml?app_id=bzonpeNIWqYBXzfcQhLK&app_code=i4NaaZIjpiCRyvDWg4BNPQ&waypoint0=geo!{0},{1}&waypoint1=geo!{2},{3}&mode=fastest;car';	
    $geo_coder_url = str_replace("{0}", $from_latitude, $geo_coder_url);
    $geo_coder_url = str_replace("{1}", $from_longitude, $geo_coder_url);
    $geo_coder_url = str_replace("{2}", $to_latitude, $geo_coder_url);
    $geo_coder_url = str_replace("{3}", $to_longitude, $geo_coder_url);
    try {
        if($myXMLData = file_get_contents($geo_coder_url)){
            $xml=simplexml_load_string($myXMLData) or die("Error: Cannot create object");
            $km = $xml->Response[0]->Route[0]->Summary->Distance/1000;
            return intval($km);
        } else {
            return null;
        }
    } catch (Exception $e) {
        return null;
    }
}
?>