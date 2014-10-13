<?php

require_once("src/model/MemberRepository.php");
require_once("src/view/View.php");
require_once("src/view/MemberView.php");

class MemberController {
	private $view;
	private $memberRepository;
	
	public function __construct() {
		$this->view = new MemberView();
		$this->memberRepository = new MemberRepository();
	}
	
	public function userClickedBoat(){
		if(array_key_exists("boat", $_GET)){
			return true;
		}else{
			return false;
		}
	}
	
	public function start() {

		$memberNo = $this->view->getMemberNo();
		
		if($this->view->userPressedShowFullList()){
			$ret = $this->view->showFullList($this->memberRepository->getMembers());
		}elseif(empty($memberNo) && !$this->view->userPressedCreateMember() && !$this->view->userPressedCreateMSubmit()) {
			$ret = $this->view->showCompactList($this->memberRepository->getMembers(), "");
		}elseif($this->view->userPressedCreateMember()){
			if($this->view->userPressedCreateMSubmit()){
				$string =	$this->memberRepository->createMember($this->view->getLastName(), 
							$this->view->getFirstName(), $this->view->getPersNo());
				$ret = $this->view->showCreateMemberForm($string);
			}else{
				$ret = $this->view->showCreateMemberForm("");
			}
		}elseif($this->view->userPressedEditMember()){
			if($this->view->userPressedEditMSubmit()){
				$string =	$this->memberRepository->editMember($memberNo, $this->view->getLastName(), 
							$this->view->getFirstName(), $this->view->getPersNo());
				$ret = $this->view->showEditMemberForm($this->memberRepository->getMember($memberNo), $string);
			}else {
				$ret = $this->view->showEditMemberForm($this->memberRepository->getMember($memberNo), "");
			}
		}elseif($this->view->userPressedDeleteMember()){
			$string = $this->memberRepository->deleteMember($memberNo);
			$ret = $this->view->showCompactList($this->memberRepository->getMembers(), $string);
		}else{
			$ret = $this->view->showMember($this->memberRepository->getMember($memberNo), "");
		}
		return $ret;
	}
}
