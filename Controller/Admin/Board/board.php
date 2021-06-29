<?php

namespace Controller\Admin\Board;

use App;

class boardController
{
	public function __construct()
	{
		if (!login()) {
			message("로그인후 이용해 주세요.", "/Admin/Member/login");
		}
		if ($_SESSION['member']['level'] == 0) {
			message("접근 권한이 없습니다.", "/Front/Main/main");
		}
		global $db;
		$this->db = $db;
		$boardData = $this->board($_GET);
		App::view($boardData);
	}
	
	public function board($params = [])
	{
		if (!isset($params['id'])) {
			msg("잘못된 접근입니다.");
		} else {
			$row = $this->db->table("board")
						->column()
						->data($params)
						->where()
						->select()
						->row();
			
			return $row;
		}
	}
}