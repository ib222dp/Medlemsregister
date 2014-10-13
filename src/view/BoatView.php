<?php

require_once("src/view/View.php");

class BoatView extends View{
	private $boatForm;
	
	
	public function __construct() {
		$this->boatForm .=	"<form action='index.php?" . http_build_query($_GET) . "' method='post'>
							<fieldset>
							<legend>Fyll i båttyp och längd</legend>
							<label>Båttyp: </label>
							<input type='text' name='boatType'/>
							<label>Längd i meter: </label>
							<input type='number' name='boatLength'/>";
	}

	public function showBoat($member, $boatNo) {
		$boat = $member->getBoat($boatNo);
		$ret =	"<a href='index.php?member=" . $member->getMemberNo() . "&boat'>Tillbaka</a>
				<h2>Båtar</h2>
				<p>" . $this->showCompactMemberData($member) . "</p>
				<h3>". $boat->getBoatType() . " (" . $boat->getBoatLength() . " meter)</h3>
				<ul><li><a href='index.php?" . http_build_query($_GET) . "&editBoat'>Redigera båt</a></li>
				<li><a href='index.php?" . http_build_query($_GET) . "&deleteBoat'>Ta bort båt</a></li></ul>"; 
		return $ret;
	}
	
	public function showAddBoatForm($member, $string) {
		$boatLinks = true;
		$ret =	"<a href='index.php?member=" . $member->getMemberNo() . "'>Tillbaka</a>
				<h2>Båtar</h2>"
				. $this->showMemberData($member, $boatLinks) . 
				"<h3>Registrera ny båt</h3><p>" . $string . "</p>" 
				. $this->boatForm . "<input type='submit' name='addBoatSubmit' value='Registrera'/></fieldset></form>";
		return $ret;
	}
	
	public function showEditBoatForm($member, $boatNo, $string) {
		$boat = $member->getBoat($boatNo - 1); 
		$ret =	"<a href='index.php?member=" . $member->getMemberNo() . "&boat=" . $boatNo . "'>Tillbaka</a>
				<h2>Redigera båt</h2>
				<p>".  $this->showCompactMemberData($member). "</p> " . 
				"<h3>" . $boat->getBoatType() . " (" . $boat->getBoatLength() . " meter)</h3><p>" . $string . "</p>" 
				. $this->boatForm . "<input type='submit' name='editBoatSubmit' value='Skicka'/></fieldset></form>";
		return $ret;
	}

	public function userPressedDeleteBoat() {
		if(array_key_exists("deleteBoat", $_GET)) {
			return true;
		}else{
			return false;
		}
	}
	
	public function userPressedEditBoat() {
		if(array_key_exists("editBoat", $_GET)) {
			return true;
		}else{
			return false;
		}
	}
	
	public function userPressedEditBoatSubmit() {
		if(isset($_POST["editBoatSubmit"])) {
			return true;
		}else {
			return false;
		}
	}
	
	public function userPressedAddBoatSubmit() {
		if(isset($_POST["addBoatSubmit"])) {
			return true;
		}else {
			return false;
		}
	}
	
	public function getBoatType () {
		$boatType = filter_var(trim($_POST["boatType"]), FILTER_SANITIZE_STRING);
		return $boatType;
	}
	
	public function getBoatLength () {
		$boatLength = $_POST["boatLength"];
		return $boatLength;
	}
	
	public function getBoatNo() {
		if(isset($_GET["boat"])) {
			$boatNo = $_GET["boat"];
			return $boatNo;
		}
	}
}
