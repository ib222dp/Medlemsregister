<?php

require_once("src/model/Member.php");
require_once("src/model/Boat.php");

class MemberRepository {
	private $members;
	private $file;
	
	public function __construct() {
		$this->members = simplexml_load_file("members.xml");
		$this->file = "members.xml";
	}
	
	public function instantiateMember($member, $memberNo) {
		$newMember = new Member($memberNo, (string)$member->lastname, (string)$member->firstname, (string)$member->persno);
		foreach ($member->boats->boat as $boat){
			$newBoat = new Boat((string)$boat->boattype, (string)$boat->boatlength);
			$newMember->addBoat($newBoat);
		}
		return $newMember;
	}
	
	public function getMembers(){
		$newMemberArray = array();
		for($i = 0; $i < count($this->members); $i++){
			$newMember = $this->instantiateMember($this->members->member[$i], $i + 1);
			array_push($newMemberArray, $newMember);
		}
		return $newMemberArray;
	}
	
	public function getMember($memberNo) {
		$member = $this->members->member[$memberNo - 1];
		$newMember = $this->instantiateMember($member, $memberNo);
		return $newMember;
	}

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

	public function deleteMember($memberNo) {
		unset($this->members->member[$memberNo - 1]);
		$this->members->saveXML($this->file);
		$string = "Medlemmen har tagits bort";
		return $string;
	}
}
