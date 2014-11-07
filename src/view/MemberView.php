<?php

require_once("src/view/View.php");

class MemberView extends View{
	private $memberForm;
	
	private static $lastName = "lastName";
	private static $firstName = "firstName";
	private static $persNo = "persNo";
	private static $fullButton = "fullButton";
	private static $createMSubmit = "createMSubmit";
	private static $editMSubmit = "editMSubmit";
	
	private static $addMember = "addMember";
	
	public function __construct() {
		$this->memberForm .=	"<form action='index.php?" . http_build_query($_GET) . "' method='post'>
								<fieldset>
								<legend>Fyll i efternamn, förnamn och personnummer</legend>
								<label>Efternamn: </label>
								<input type='text' name='" . self::$lastName . "'/>
								<label>Förnamn: </label>
								<input type='text' name='" . self::$firstName . "'/>
								<label>Personnummer: </label>
								<input type='text' name='" . self::$persNo . "'/>";
	}
	
	//Kontrollerar om användaren klickat på "Visa båtar"
	public function userClickedBoat() {
		if(array_key_exists(self::$boatParam, $_GET)){
			return true;
		}else {
			return false;
		}
	}
	
	//Visar kompakt medlemslista
	public function showCompactList($members, $string){
		$listLink = "<form action='index.php' method='post'>
					<fieldset>
					<input type='submit' name='" . self::$fullButton . "' value='Visa fullständig lista'/>
					</fieldset>
					</form>";
		$regLink = "<ul><li><a href='index.php?" . http_build_query($_GET) . self::$addMember . "'>
					Registrera ny medlem</a></li></ul>";
		if(empty($members)) {
			$directory = "<p>Medlemsregistret är tomt</p>";
		}else {
			foreach($members as $member){
				$list .=	"<li><a href='?" . self::$memberParam . "=" . $member->getMemberNo() . "'>" 
							. $this->showCompactMemberData($member) ."</a>
							<p>Antal båtar: " . count($member->getBoats()) . "</p></li>"; 
			}
			$directory = "<p>Klicka på en medlem för att redigera eller ta bort medlemmen</p><ul>" . $list . "</ul>";
		}
		$ret = $listLink . $regLink . "<h3>Kompakt lista</h3><p>" . $string . "</p>" . $directory;
		return $ret;
	}
	
	//Kontrollerar om användaren har klickat på Visa fullständig lista
	public function userPressedShowFullList(){
		if(isset($_POST[self::$fullButton])){
			return true;
		}else{
			return false;
		}
	}
	
	//Visar fullständig medlemslista
	public function showFullList($members){
		if(empty($members)) {
			$ret = "<a href='index.php'>Tillbaka</a>
					<p>Medlemsregistret är tomt</p>";
		}else {
			$boatLinks = false;
			foreach($members as $member) {
				$memberList .= "<li>" . $this->showMemberData($member, $boatLinks) . "</li>";
			}
			$ret = "<a href='index.php'>Tillbaka</a>
					<ul>" . $memberList . "</ul>"; 
		}
		return $ret;
	}
	
	//Visar formulär för att registrera ny medlem
	public function showCreateMemberForm($string){
		$ret =		"<a href='index.php'>Tillbaka</a>
					<h2>Skapa ny medlem</h2>
					<p>" . $string . "</p>" 
					. $this->memberForm . "<input type='submit' name='" . self::$createMSubmit . "' 
					value='Registrera'/></fieldset></form>"; 
		return $ret;
	}
	
	//Visar formulär för att redigera en medlems uppgifter
	public function showEditMemberForm($member, $string){
		$ret =		"<a href='index.php?" . self::$memberParam . "=" . $member->getMemberNo() . "'>Tillbaka</a>
					<h2>Redigera medlem</h2>
					<h4>" .  $this->showCompactMemberData($member) . "</h4>
					<p>" . $string . "</p>" 
					. $this->memberForm . "<input type='submit' name='" . self::$editMSubmit . "'
					value='Skicka'/></fieldset></form>";
		return $ret;
	}
	
	//Visar meddelande att en medlem har raderats
	public function showMemberDeletedPage($string){
		$ret =		"<a href='index.php?'>Tillbaka</a>
					<h2>" . $string . "</h2>";
		return $ret;
	}
	
	//Kontrollerar om användaren klickat på Ta bort medlem
	public function userPressedDeleteMember() {
		if(array_key_exists(self::$deleteM, $_GET)) {
			return true;
		}else{
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på Registrera ny medlem
	public function userPressedCreateMember() {
		if(array_key_exists(self::$addMember, $_GET)){
			return true;
		}else{
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på "Skicka"-knappen i Registrera ny medlem-formuläret
	public function userPressedCreateMSubmit(){
		if(isset($_POST[self::$createMSubmit])){
			return true;
		}else{
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på Redigera medlem
	public function userPressedEditMember() {
		if(array_key_exists(self::$editM, $_GET)){
			return true;
		}else{
			return false;
		}
	}
	
	//Kontrollerar om användaren klickat på "Skicka"-knappen i Redigera medlem-formuläret
	public function userPressedEditMSubmit() {
		if(isset($_POST[self::$editMSubmit])) {
			return true;
		}else {
			return false;
		}
	}
	
	//Hämtar efternamn
	public function getLastName() {
		if(isset($_POST[self::$lastName])){
			$lastName = filter_var(trim($_POST[self::$lastName]), FILTER_SANITIZE_STRING);
			return $lastName;
		}else{
			exit();
		}
	}
	
	//Hämtar förnamn
	public function getFirstName (){
		if(isset($_POST[self::$firstName])){
			$lastName = filter_var(trim($_POST[self::$firstName]), FILTER_SANITIZE_STRING);
			return $lastName;
		}else{
			exit();
		}
	}
	
	//Hämtar personnummer
	public function getPersNo (){
		if(isset($_POST[self::$persNo])){
			$memberNo = filter_var(trim($_POST[self::$persNo]), FILTER_SANITIZE_STRING);
			return $memberNo;
		}else{
			exit();
		}
	}
}
