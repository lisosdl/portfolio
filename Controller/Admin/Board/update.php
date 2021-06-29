<?php

namespace Controller\Admin\Board;

use App;

class updateController
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
		$_POST = array_merge($_POST, $_GET);
		$boardData = $this->boardData($_POST);
		App::view($boardData);
	}
	
	public function boardData($params = [])
	{
		$row = $this->db->table("board")
								->column()
								->data($params)
								->where()
								->select()
								->row();
		
		return $row;
	}
}