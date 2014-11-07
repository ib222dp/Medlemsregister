<?php

class BoatType {
	private $boatTypeName;

	public function __construct($boatTypeName) {
		$this->boatTypeName = $boatTypeName;
	}
	
	public function getBoatTypeName(){
		return $this->boatTypeName;
	}
}
