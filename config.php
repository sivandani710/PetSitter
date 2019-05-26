<?php
	session_start();
	    //googleAPI = "AIzaSyCVS87uzcZLs89VirNbniCHVUn9K2blU6A"
    // client ID = 1059008678276-5j9c69eerp1g96dri449ta4leq0p6gbe.apps.googleusercontent.com
    //client secret = 0-eP4gvGO3viMCKgl4p8oz60
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("1059008678276-tjij74oa3k8cr7r8odbubp9scl2og62p.apps.googleusercontent.com");
	$gClient->setClientSecret("VJTzJix4Kpz4Ox5nprqXUx3n");
	$gClient->setApplicationName("petsitter");
	$gClient->setRedirectUri("http://sivandn.mtacloud.co.il/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
	$gClient->addScope("https://www.googleapis.com/auth/calendar");
?>