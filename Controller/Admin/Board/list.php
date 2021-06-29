<?php

namespace Controller\Admin\Board;

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
		$boardList = $this->index();
		$pagination = $boardList['pagination'];
		unset($boardList['pagination']);
		App::view($boardList, $pagination);
	}
	
	public function index()
	{
		$page = App::load(\Controller\Admin\pagination::class);
		$startLimit = $page->nowPage();
		$pp = $page->lastPage("board");
		extract($pp);
		if ($startLimit == $lastPage) {
			$boardList = $this->boardList($startLimit, $point+1);
		} else {
			$boardList = $this->boardList($startLimit);
		}
		for ($i = 0; $i <= $lastPage+1; $i++) {
			if ($i <= $lastPage) {
				if ($i == 0) {
					$boardList['pagination'][] = "<a href='/Admin/Board/list?page=0'>first</a>";
				}
				$boardList['pagination'][] = "<a href='/Admin/Board/list?page={$i}'>{$i}</a>";
			} else {
				$boardList['pagination'][] = "<a href='/Admin/Board/list?page={$lastPage}'>last</a>";
			}
		}
		
		return $boardList;
	}
	
	public function boardList($startLimit = "", $limit = 10)
	{
		if ($startLimit != "") {
			$startLimit *= 10;
			if ($startLimit >= 10) $startLimit -= 1;
		}
		$row = $this->db->table("board")
								->column()
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