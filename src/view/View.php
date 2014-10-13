<?php

abstract class View {

	public function __construct() {
	}
	
	public function showCompactMemberData($member) {
		$ret = "Efternamn: " . $member->getLastName() . " - Förnamn: " . $member->getFirstName() . " 
				- Personnr: " . $member->getPersonalNo();
		return $ret;
	}

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
					$ret .=	"<li><a href='index.php?member=" . $member->getMemberNo() . "&boat=" . ($i+1) . "'>" 
						. $member->getBoats()[$i]->getBoatType() . " (" 
						. $member->getBoats()[$i]->getBoatLength() . " meter)</a></li>";
				}
				$ret .= "</ul>";
			}else{
				$ret .= "<h4>Båtar:</h4>";
				for($i = 0; $i < count($member->getBoats()); $i++){
					$ret .=	"<p>" . $member->getBoats()[$i]->getBoatType() . " (" 
						. $member->getBoats()[$i]->getBoatLength() . " meter)</p>";
				}
			}
		}else {
			$ret .= "<h4>Inga båtar</h4>";
		}
		return $ret;
	}
	
	public function showMember($member, $string) {
		$ret =	"<a href='index.php'>Tillbaka</a>
				<h2>Medlem " . $member->getMemberNo() . "</h2>
				<p>" . $string . "</p>
				<h4>". $this->showCompactMemberData($member)  . "</h4>
				<ul><li><a href='index.php?" . http_build_query($_GET) . "&boat'>Visa båtar</a></li>
				<li><a href='index.php?" . http_build_query($_GET) . "&editM'>Redigera medlem</a></li>
				<li><a href='index.php?" . http_build_query($_GET) . "&deleteM'>Ta bort medlem</a></li></ul>"; 
		return $ret;
	}
	
	public function getMemberNo() {
		if(isset($_GET["member"])) {
			$memberNo = $_GET["member"];
			return $memberNo;
		}
	}
}
