<?php

require_once("src/model/MemberRepository.php");
require_once("src/model/BoatTypeRepository.php");
require_once("src/view/View.php");
require_once("src/view/BoatView.php");

class BoatController {
	private $memberRepository;
	private $boatTypeRepository;
	private $boatTypes;
	private $view;

	public function __construct() {
		$this->memberRepository = new MemberRepository();
		$this->boatTypeRepository = new BoatTypeRepository();
		$this->boatTypes = $this->boatTypeRepository->getBoatTypes();
		$this->view = new BoatView($this->boatTypes);
	}
	
	public function start() {
		
		$memberNo = $this->view->getMemberNo();
		$boatNo = $this->view->getBoatNo();
		$member = $this->memberRepository->getMember($memberNo);
		
		//Om ingen båt har valts
		if(empty($boatNo)) {
			//Om användaren vill lägga till en båt
			if($this->view->userPressedAddBoatSubmit()){
				$string = $member->createBoat($this->view->getBoatType(), $this->view->getBoatLength());
				$ret = $this->view->showAddBoatForm($this->memberRepository->getMember($memberNo), $string);
			}else{
				$ret = $this->view->showAddBoatForm($this->memberRepository->getMember($memberNo), "");
			}
		//Om användaren vill redigera båten som valts
		}elseif($this->view->userPressedEditBoat()) {
			if($this->view->userPressedEditBoatSubmit()){
				$string = $member->editBoat($boatNo - 1, $this->view->getBoatType(), $this->view->getBoatLength());
				$ret =	$this->view->showEditBoatForm($this->memberRepository->getMember($memberNo), $boatNo, $string);
			}else{
				$ret =	$this->view->showEditBoatForm($this->memberRepository->getMember($memberNo), $boatNo, "");
			}
		//Om användaren vill radera båten som valts
		}elseif($this->view->userPressedDeleteBoat()){
			$string = $member->deleteBoat($boatNo - 1);
			$ret = $this->view->showBoatDeletedPage($this->memberRepository->getMember($memberNo), $string);
		}else{
		//Visar den båt som användaren valt	
			$ret = $this->view->showBoat($this->memberRepository->getMember($memberNo), $boatNo - 1);
		}
		return $ret;
	}
}
