<?php

require_once("src/view/View.php");

class BoatView extends View{
	private $boatForm;
	private $boatTypesArray;
	
	private static $boatType = "boatType";
	private static $boatLength = "boatLength";
	private static $addBoatSubmit = "addBoatSubmit";
	private static $editBoatSubmit = "editBoatSubmit";
	
	private static $editBoat = "editBoat";
	private static $deleteBoat = "deleteBoat";
	
	
	public function __construct($boatTypesArray) {
		$this->boatTypesArray = $boatTypesArray;
		
		$this->boatForm .=	"<form action='index.php?" . http_build_query($_GET) . "' method='post'>
							<fieldset>
							<legend>Fyll i båttyp och längd</legend>
							<label>Båttyp: </label>
							<select class='select' id='answer' name='" . self::$boatType . "'>";
		
		for($i = 0; $i < count($this->boatTypesArray); $i++){	
			$this->boatForm .= "<option value='" . $this->boatTypesArray[$i]->getBoatTypeName() . "'>" 
			. $this->boatTypesArray[$i]->getBoatTypeName() . "</option>";
			
		};
		
		$this->boatForm .= "<label>Längd i meter: </label>
								<input type='number' name='" . self::$boatLength . "'/>";
	}
	
	//Visar den båt som användaren klickat på
	public function showBoat($member, $boatNo) {
		$boat = $member->getBoat($boatNo);
		$ret =	"<a href='index.php?" . self::$memberParam . "=" . $member->getMemberNo() . 
				"&" . self::$boatParam . "'>Tillbaka</a>
				<h2>Båtar</h2>
				<p>" . $this->showCompactMemberData($member) . "</p>
				<h3>". $boat->getBoatType()->getBoatTypeName() . " (" . $boat->getBoatLength() . " meter)</h3>
				<ul><li><a href='index.php?" . http_build_query($_GET) . "&" . self::$editBoat . "'>Redigera båt</a></li>
				<li><a href='index.php?" . http_build_query($_GET) . "&" . self::$deleteBoat . "'>Ta bort båt</a></li></ul>"; 
		return $ret;
	}
	
	//Visar formulär för att registrera en ny båt
	public function showAddBoatForm($member, $string) {
		$boatLinks = true;
		$ret =	"<a href='index.php?" . self::$memberParam . "=" . $member->getMemberNo() . "'>Tillbaka</a>
				<h2>Båtar</h2>"
				. $this->showMemberData($member, $boatLinks) . 
				"<h3>Registrera ny båt</h3><p>" . $string . "</p>" 
				. $this->boatForm . "<input type='submit' name='" . self::$addBoatSubmit . "' 
				value='Registrera'/></fieldset></form>";
		return $ret;
	}
	
	//Visar formulär för att redigera en båt
	public function showEditBoatForm($member, $boatNo, $string) {
		$boat = $member->getBoat($boatNo - 1); 
		$ret =	"<a href='index.php?" . self::$memberParam . "=" . $member->getMemberNo() 
				. "&" . self::$boatParam . "=" . $boatNo . "'>Tillbaka</a>
				<h2>Redigera båt</h2>
				<p>".  $this->showCompactMemberData($member). "</p> " . 
				"<h3>" . $boat->getBoatType()->getBoatTypeName() . " (" . $boat->getBoatLength() . " meter)</h3>
				<p>" . $string . "</p>" 
				. $this->boatForm . "<input type='submit' name='" . self::$editBoatSubmit . "' 
				value='Skicka'/></fieldset></form>";
		return $ret;
	}
	
	//Visar meddelande att båten har raderats
	public function showBoatDeletedPage($member, $string){
		$ret =	"<a href='index.php?" . self::$memberParam . "=" . $member->getMemberNo() . "'>Tillbaka</a>
				<h2>" . $string . "</h2>";
		return $ret;
	}
	
	//Kontrollerar om användaren klickat på Ta bort båt
	public function userPressedDeleteBoat() {
		if(array_key_exists(self::$deleteBoat, $_GET)) {
			return true;
		}else{
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på Redigera båt
	public function userPressedEditBoat() {
		if(array_key_exists(self::$editBoat, $_GET)) {
			return true;
		}else{
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på Skicka-knappen i Redigera båt-formuläret
	public function userPressedEditBoatSubmit() {
		if(isset($_POST[self::$editBoatSubmit])) {
			return true;
		}else {
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på Skicka-knappen i Lägg till båt-formuläret
	public function userPressedAddBoatSubmit() {
		if(isset($_POST[self::$addBoatSubmit])) {
			return true;
		}else {
			return false;
		}
	}
	
	//Hämtar båttyp
	public function getBoatType () {
		$boatType = $_POST[self::$boatType];
		return $boatType;
	}
	
	//Hämtar båtlängd
	public function getBoatLength () {
		$boatLength = $_POST[self::$boatLength];
		return $boatLength;
	}
	
	//Hämtar numret för den båt som användaren klickat på
	public function getBoatNo() {
		if(isset($_GET[self::$boatParam])) {
			$boatNo = $_GET[self::$boatParam];
			return $boatNo;
		}
	}
}
