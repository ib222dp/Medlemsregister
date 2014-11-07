<?php

abstract class Repository {
	protected $members;
	protected $file;
	
	public function __construct() {
		$this->members = simplexml_load_file("members.xml");
		$this->file = "members.xml";
	}
}
