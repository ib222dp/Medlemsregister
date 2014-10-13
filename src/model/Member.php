<?php

class Member {
	private $memberNo;
	private $lastName;
	private $firstName;
	private $personalNo;
	private $boats;
	
	public function __construct($memberNo, $lastName, $firstName, $personalNo) {
		$this->memberNo = $memberNo;
		$this->lastName = $lastName;
		$this->firstName = $firstName;
		$this->personalNo = $personalNo;
		$this->boats = array();
	}
	
	public function addBoat($boat){
		array_push($this->boats, $boat);
	}
	
	public function getMemberNo(){
		return $this->memberNo;
	}
	
	public function getLastName(){
		return $this->lastName;
	}
	
	public function getFirstName(){
		return $this->firstName;
	}
	
	public function getPersonalNo(){
		return $this->personalNo;
	}
	
	public function getBoats(){
		return $this->boats;
	}
	
	public function getBoat($boatNo) {
		$boat = $this->boats[$boatNo];
		return $boat;
	}
	
	public function loadFile() {
		$members = simplexml_load_file("members.xml");
		$file = "members.xml";
		return array($members, $file);
	}
	
	public function createBoat($boatType, $boatLength) {
		if(empty($boatType) || empty($boatLength)) {
			$string = "Inget av fälten får vara tomma";
		}else {
			$members = $this->loadFile();
			$mNo = ($this->memberNo - 1);
			$member = $members[0]->member[$mNo];
			$boat = $member->boats->addChild("boat");
			$boat->addChild("boattype", $boatType);
			$boat->addChild("boatlength", $boatLength);
			$members[0]->saveXML($members[1]);
			$string = "Båten har lagts till";
		}
		return $string;
	}
	
	public function editBoat($boatNo, $boatType, $boatLength) {
		if(empty($boatType) || empty($boatLength)) {
			$string = "Inget av fälten får vara tomma";
		}else {
			$members = $this->loadFile();
			$mNo = ($this->memberNo - 1);
			$member = $members[0]->member[$mNo];
			$member->boats->boat[$boatNo]->boattype = $boatType;
			$member->boats->boat[$boatNo]->boatlength = $boatLength;
			$members[0]->saveXML($members[1]);
			$string = "Båtuppgifterna har uppdaterats";
		}
		return $string;
	}
	
	public function deleteBoat($boatNo) {
		$members = $this->loadFile();
		$mNo = ($this->memberNo-1);
		unset($members[0]->member[$mNo]->boats->boat[$boatNo]);
		$members[0]->saveXML($members[1]);
		$string = "Båten har tagits bort";
		return $string;
	}
}
