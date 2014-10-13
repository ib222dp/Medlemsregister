<?php

require_once("HTMLView.php");
require_once("src/controller/MemberController.php");
require_once("src/controller/BoatController.php");

$HTMLview = new HTMLView();

$memberController = new MemberController();

if($memberController->userClickedBoat()){
	$boatController = new BoatController();
	$htmlBody = $boatController->start();
}else{
	$htmlBody = $memberController->start();
}

$HTMLview->echoHTML($htmlBody);
