<?php

require_once("src/model/MemberRepository.php");
require_once("src/view/View.php");
require_once("src/view/BoatView.php");

class BoatController {
	private $view;
	private $memberRepository;

	public function __construct() {
		$this->view = new BoatView();
		$this->memberRepository = new MemberRepository();
	}
	
	public function start() {
		
		$memberNo = $this->view->getMemberNo();
		$boatNo = $this->view->getBoatNo();
		$member = $this->memberRepository->getMember($memberNo);

		if(empty($boatNo)) {
			if($this->view->userPressedAddBoatSubmit()){
				$string = $member->createBoat($this->view->getBoatType(), $this->view->getBoatLength());
				$ret = $this->view->showAddBoatForm($this->memberRepository->getMember($memberNo), $string);
			}else{
				$ret = $this->view->showAddBoatForm($this->memberRepository->getMember($memberNo), "");
			}
		}elseif($this->view->userPressedEditBoat()) {
			if($this->view->userPressedEditBoatSubmit()){
				$string = $member->editBoat($boatNo - 1, $this->view->getBoatType(), $this->view->getBoatLength());
				$ret =	$this->view->showEditBoatForm($this->memberRepository->getMember($memberNo), $boatNo, $string);
			}else{
				$ret =	$this->view->showEditBoatForm($this->memberRepository->getMember($memberNo), $boatNo, "");
			}
		}elseif($this->view->userPressedDeleteBoat()){
			$string = $member->deleteBoat($boatNo - 1);
			$ret = $this->view->showMember($this->memberRepository->getMember($memberNo), $string);
		}else{
			$ret = $this->view->showBoat($this->memberRepository->getMember($memberNo), $boatNo - 1);
		}
		return $ret;
	}
}
