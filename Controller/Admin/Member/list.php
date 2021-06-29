<?php

namespace Controller\Admin\Member;

use App;

class listController
{
	public function __construct()
	{
		if (!login()) {
			message("로그인후 이용해 주세요.", "/Admin/Member/login");
		}
		if ($_SESSION['member']['level'] == 0) {
			message("접근 권한이 없습니다.", "/Front/Board/list");
		}
		global $db;
		$this->db = $db;
		$memList = $this->index();
		$pagination = $memList['pagination'];
		unset($memList['pagination']);
		App::view($memList, $pagination);
	}
	
	public function index()
	{
		$page = App::load(\Controller\Admin\pagination::class);
		$startLimit = $page->nowPage();
		$pp = $page->lastPage("member");
		extract($pp);
		if ($startLimit == $lastPage) {
			$memList = $this->memList($startLimit, $point+1);
		} else {
			$memList = $this->memList($startLimit);
		}
		
		for ($i = 0; $i <= $lastPage+1; $i++) {
			if ($i <= $lastPage) {
				if ($i == 0) {
					$memList['pagination'][] = "<a href='/Admin/Member/list?page=0'>first</a>";
				}
				$memList['pagination'][] = "<a href='/Admin/Member/list?page={$i}'>{$i}</a>";
			} else {
				$memList['pagination'][] = "<a href='/Admin/Member/list?page={$lastPage}'>last</a>";
			}
		}
		
		return $memList;
	}
	
	/**
	* 모든 회원 데이터 추출
	* unset = 불필요한 데이터 삭제
	*
	* @return Array $row
	*/
	public function memList($startLimit = "", $limit = 10)
	{
		if ($startLimit != "") {
			$startLimit *= 10;
			if ($startLimit >= 10) $startLimit -= 1;
		}
		$row = $this->db->column()
						->table("member")
						->limit($limit, $startLimit)
						->select()
						->row();
		
		foreach ($row as $k => $v) {
			$regDt = explode(" ", $v['regDt']);
			$row[$k]["regDt"] = $regDt; 
			if ($v['modDt'] != "" && !empty($v['modDt'])) {
				$modDt = explode(" ", $v['modDt']);
				$row[$k]['modDt'] = $modDt;
			}
		}
		
		return $row;
	}
	
}