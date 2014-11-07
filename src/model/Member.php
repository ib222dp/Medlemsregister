<?php

require_once("src/model/Repository.php");

class Member extends Repository {
	private $memberNo;
	private $lastName;
	private $firstName;
	private $personalNo;
	private $boats;
	
	public function __construct($memberNo, $lastName, $firstName, $personalNo) {
		parent::__construct();
		
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
	
	//Lägger till en ny båt i medlemmens båtlista i xml-filen "members"
	public function createBoat($boatType, $boatLength) {
		if(empty($boatLength)) {
			$string = "Fyll i båtens längd";
		}else {
			$mNo = ($this->memberNo - 1);
			$member = $this->members->member[$mNo];
			$boat = $member->boats->addChild("boat");
			$boat->addChild("boattype", $boatType);
			$boat->addChild("boatlength", $boatLength);
			$this->members->saveXML($this->file);
			$string = "Båten har lagts till";
		}
		return $string;
	}
	
	//Lägger till båtens nya uppgifter i medlemmens båtlista i xml-filen "members"
	public function editBoat($boatNo, $boatType, $boatLength) {
		if(empty($boatLength)) {
			$string = "Fyll i båtens längd";
		}else {
			$mNo = ($this->memberNo - 1);
			$member = $this->members->member[$mNo];
			$member->boats->boat[$boatNo]->boattype = $boatType;
			$member->boats->boat[$boatNo]->boatlength = $boatLength;
			$this->members->saveXML($this->file);
			$string = "Båtuppgifterna har uppdaterats";
		}
		return $string;
	}
	
	//Raderar båten från medlemmens båtlista i xml-filen "members"
	public function deleteBoat($boatNo) {
		$mNo = ($this->memberNo-1);
		unset($this->members->member[$mNo]->boats->boat[$boatNo]);
		$this->members->saveXML($this->file);
		$string = "Båten har tagits bort";
		return $string;
	}
}
