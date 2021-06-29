<?php

namespace Controller\Front\Board;

use App;

class listController
{
	public function __construct()
	{
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
					$boardList['pagination'][] = "<a href='/Front/Board/list?page=0'>first</a>";
				}
				$boardList['pagination'][] = "<a href='/Front/Board/list?page={$i}'>{$i}</a>";
			} else {
				$boardList['pagination'][] = "<a href='/Front/Board/list?page={$lastPage}'>last</a>";
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
			$v['regDt'] = explode(" ", $v['regDt']);
			$row[$k]['regDt'] = $v['regDt'][0];
			$v['modDt'] = explode(" ", $v['modDt']);
			$row[$k]['modDt'] = $v['modDt'][0];
		}
		
		return $row;
	}
}