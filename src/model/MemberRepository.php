<?php

require_once("src/model/Repository.php");
require_once("src/model/Member.php");
require_once("src/model/Boat.php");
require_once("src/model/BoatType.php");

class MemberRepository extends Repository {
	
	public function __construct() {
		parent::__construct();
	}
	
	//Instantierar nya Member-objekt (samt Boat-objekt och BoatType-objekt)
	private function instantiateMember($member, $memberNo) {
		$newMember = new Member($memberNo, (string)$member->lastname, (string)$member->firstname, (string)$member->persno);
		foreach ($member->boats->boat as $boat){
			$newBoatType = new BoatType((string)$boat->boattype);
			$newBoat = new Boat($newBoatType, (string)$boat->boatlength);
			$newMember->addBoat($newBoat);
		}
		return $newMember;
	}
	
	//Returnerar en array med Member-objekt (de medlemmar som finns i xml-filen "members")
	public function getMembers(){
		$newMemberArray = array();
		for($i = 0; $i < count($this->members); $i++){
			$newMember = $this->instantiateMember($this->members->member[$i], $i + 1);
			array_push($newMemberArray, $newMember);
		}
		return $newMemberArray;
	}
	
	//Returnerar det efterfrågade Member-objektet från xml-filen "members"
	public function getMember($memberNo) {
		$member = $this->members->member[$memberNo - 1];
		$newMember = $this->instantiateMember($member, $memberNo);
		return $newMember;
	}
	
	//Lägger till en ny medlem i xml-filen "members"
	public function createMember($lastName, $firstName, $persNo){
		if(empty($lastName) || empty($firstName) || empty($persNo)) {
			$string = "Inget av fälten får vara tomma";
		}else {
			$newMember = $this->members->addChild("member");
			$newMember->addChild("lastname", $lastName);
			$newMember->addChild("firstname", $firstName);
			$newMember->addChild("persno", $persNo);
			$newMember->addChild("boats");
			$this->members->saveXML($this->file);
			$string = "Medlemmen har registrerats";
		}
		return $string;
	}
	
	//Lägger till medlemmens nya uppgifter i xml-filen "members"
	public function editMember($memberNo, $lastName, $firstName, $persNo) {
		if(empty($lastName) || empty($firstName) || empty($persNo)) {
			$string = "Inget av fälten får vara tomma";
		}else {		
			$member = $this->members->member[$memberNo - 1];
			$member->lastname = $lastName;
			$member->firstname = $firstName;
			$member->persno = $persNo;
			$this->members->saveXML($this->file);
			$string = "Medlemmens uppgifter har uppdaterats";
		}
		return $string;
	}
	
	//Raderar medlemmen från xml-filen "members"
	public function deleteMember($memberNo) {
		unset($this->members->member[$memberNo - 1]);
		$this->members->saveXML($this->file);
		$string = "Medlemmen har tagits bort";
		return $string;
	}
}
