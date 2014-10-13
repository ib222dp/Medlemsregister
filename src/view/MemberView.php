<?php

require_once("src/view/View.php");

class MemberView extends View{
	private $memberForm;
	
	public function __construct() {
		$this->memberForm .=	"<form action='index.php?" . http_build_query($_GET) . "' method='post'>
								<fieldset>
								<legend>Fyll i efternamn, förnamn och personnummer</legend>
								<label>Efternamn: </label>
								<input type='text' name='lastName'/>
								<label>Förnamn: </label>
								<input type='text' name='firstName'/>
								<label>Personnummer: </label>
								<input type='text' name='persNo'/>";
	}
	
	public function userClickedBoat() {
		if(array_key_exists("boat", $_GET)){
			return true;
		}else {
			return false;
		}
	}

	public function showCompactList($members, $string){
		$listLink = "<form action='index.php' method='post'>
					<fieldset>
					<input type='submit' name='fullButton' value='Visa fullständig lista'/>
					</fieldset>
					</form>";
		$regLink = "<ul><li><a href='index.php?" . http_build_query($_GET) . "addMember'>Registrera ny medlem</a></li></ul>";
		if(empty($members)) {
			$directory = "<p>Medlemsregistret är tomt</p>";
		}else {
			foreach($members as $member){
				$list .=	"<li><a href='?member=" . $member->getMemberNo() . "'>" . $this->showCompactMemberData($member) ."</a>
							<p>Antal båtar: " . count($member->getBoats()) . "</p></li>"; 
			}
			$directory = "<p>Klicka på en medlem för att redigera eller ta bort medlemmen</p><ul>" . $list . "</ul>";
		}
		$ret = $listLink . $regLink . "<h3>Kompakt lista</h3><p>" . $string . "</p>" . $directory;
		return $ret;
	}

	public function userPressedShowFullList(){
		if(isset($_POST["fullButton"])){
			return true;
		}else{
			return false;
		}
	}
	
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
	
	public function showCreateMemberForm($string){
		$ret =		"<a href='index.php'>Tillbaka</a>
					<h2>Skapa ny medlem</h2>
					<p>" . $string . "</p>" 
					. $this->memberForm . "<input type='submit' name='createMSubmit' value='Registrera'/></fieldset></form>"; 
		return $ret;
	}
	
	public function showEditMemberForm($member, $string){
		$ret =		"<a href='index.php?member=" . $member->getMemberNo() . "'>Tillbaka</a>
					<h2>Redigera medlem</h2>
					<h4>" .  $this->showCompactMemberData($member) . "</h4>
					<p>" . $string . "</p>" 
					. $this->memberForm . "<input type='submit' name='editMSubmit' value='Skicka'/></fieldset></form>";
		return $ret;
	}
	
	public function userPressedDeleteMember() {
		if(array_key_exists("deleteM", $_GET)) {
			return true;
		}else{
			return false;
		}
	}
	
	public function userPressedCreateMember() {
		if(array_key_exists("addMember", $_GET)){
			return true;
		}else{
			return false;
		}
	}
	
	public function userPressedCreateMSubmit(){
		if(isset($_POST["createMSubmit"])){
			return true;
		}else{
			return false;
		}
	}
	
	public function userPressedEditMember() {
		if(array_key_exists("editM", $_GET)){
			return true;
		}else{
			return false;
		}
	}
	
	public function userPressedEditMSubmit() {
		if(isset($_POST["editMSubmit"])) {
			return true;
		}else {
			return false;
		}
	}
	
	public function getLastName() {
		if(isset($_POST["lastName"])){
			$lastName = filter_var(trim($_POST["lastName"]), FILTER_SANITIZE_STRING);
			return $lastName;
		}else{
			exit();
		}
	}
	
	public function getFirstName (){
		if(isset($_POST["firstName"])){
			$lastName = filter_var(trim($_POST["firstName"]), FILTER_SANITIZE_STRING);
			return $lastName;
		}else{
			exit();
		}
	}
	
	public function getPersNo (){
		if(isset($_POST["persNo"])){
			$memberNo = filter_var(trim($_POST["persNo"]), FILTER_SANITIZE_STRING);
			return $memberNo;
		}else{
			exit();
		}
	}
}
