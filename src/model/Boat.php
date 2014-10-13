<?php

class Boat {
	private $boatType;
	private $boatLength;

	public function __construct($boatType, $boatLength) {
		$this->boatType = $boatType;
		$this->boatLength = $boatLength;
	}
	
	public function getBoatType(){
		return $this->boatType;
	}
	
	public function getBoatLength(){
		return $this->boatLength;
	}
}
