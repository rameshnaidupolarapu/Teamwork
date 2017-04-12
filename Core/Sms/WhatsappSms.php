<?php
include_once './lib/whatsapp/whatsprot.class.php';
namespace Core\Sms;
class WhatsappSms 
{
    function __construct() {
        $usename='919703298025';
	$identity='%b9%99%dd%1b%b3aa%83%8a%3d%1f%11%f3ns%af%82%5c%5c%94';
	$nickname="F-k5gwz_91o";
	$password='N9zDoAJjmAMotbV26VFgAznI6MI=';
	$debug=false;
	$w=new WhatsProt($usename,$identity,$nickname,$password,$debug);
	$w->connect();
	$w->loginWithPassword($password);
	
	$w->sendMessage('919703298025','Hi Ramesh');
	
    ;
}
}
