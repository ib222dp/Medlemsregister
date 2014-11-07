<?php

require_once("src/model/BoatType.php");

class BoatTypeRepository {
	private $boattypes;
	private $file;
	
	public function __construct() {
		$this->boattypes = simplexml_load_file("boattypes.xml");
		$this->file = "boattypes.xml";
	}
	
	//Returnerar en array med båttypsobjekt (de båttyper som finns i xml-filen "boattypes")
	public function getBoatTypes(){
		$newBoatTypesArray = array();
		for($i = 0; $i < count($this->boattypes); $i++){
			$newBoatType = new BoatType($this->boattypes->boattype[$i]);
			array_push($newBoatTypesArray, $newBoatType);
		}
		return $newBoatTypesArray;
	}
}
