<?php

abstract class View {
	
	protected static $boatParam = "boat";
	protected static $memberParam = "member";
	protected static $editM = "editM";
	protected static $deleteM = "deleteM";

	public function __construct() {
	}
	
	//Visar en medlems efternamn, förnamn och personnummer
	public function showCompactMemberData($member) {
		$ret = "Efternamn: " . $member->getLastName() . " - Förnamn: " . $member->getFirstName() . " 
				- Personnr: " . $member->getPersonalNo();
		return $ret;
	}
	
	//Visar en medlems medlemsnr, efternamn, förnamn, personnr samt dennes eventuella båtar
	public function showMemberData($member, $boatLinks){
		$ret .=	"<p>Medlemsnr: " . $member->getMemberNo() . "</p>
				<p>Efternamn: " . $member->getLastName() . "
				- Förnamn: " . $member->getFirstName() . "
				- Personnr: " . $member->getPersonalNo() . "</p>";
		
		$boats = $member->getBoats();
		if(!empty($boats)){
			if($boatLinks) {
				$ret .= "<p>Klicka på en båt för att redigera eller ta bort den</p><ul>";
				for($i = 0; $i < count($member->getBoats()); $i++){
					$ret .=	"<li><a href='index.php?" . self::$memberParam . "=" . $member->getMemberNo() . "&" 
					. self::$boatParam . "=" . ($i+1) . "'>" 
					. $member->getBoats()[$i]->getBoatType()->getBoatTypeName() . " 
					(" . $member->getBoats()[$i]->getBoatLength() . " meter)</a></li>";
				}
				$ret .= "</ul>";
			}else{
				$ret .= "<h4>Båtar:</h4>";
				for($i = 0; $i < count($member->getBoats()); $i++){
					$ret .=	"<p>" . $member->getBoats()[$i]->getBoatType()->getBoatTypeName() . " (" 
					. $member->getBoats()[$i]->getBoatLength() . " meter)</p>";
				}
			}
		}else {
			$ret .= "<h4>Inga båtar</h4>";
		}
		return $ret;
	}
	
	//Visar den medlem som användaren valt
	public function showMember($member, $string) {
		$ret =	"<a href='index.php'>Tillbaka</a>
				<h2>Medlem " . $member->getMemberNo() . "</h2>
				<p>" . $string . "</p>
				<h4>". $this->showCompactMemberData($member)  . "</h4>
				<ul><li><a href='index.php?" . http_build_query($_GET) . "&" . self::$boatParam . "'>
				Visa båtar</a></li>
				<li><a href='index.php?" . http_build_query($_GET) . "&" . self::$editM . "'>Redigera medlem</a></li>
				<li><a href='index.php?" . http_build_query($_GET) . "&" . self::$deleteM . "'>Ta bort medlem</a></li></ul>"; 
		return $ret;
	}
	
	//Hämtar numret för den medlem som användaren klickat på
	public function getMemberNo() {
		if(isset($_GET[self::$memberParam])) {
			$memberNo = $_GET[self::$memberParam];
			return $memberNo;
		}
	}
}
