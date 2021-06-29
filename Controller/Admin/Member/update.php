<?php

namespace Controller\Admin\Member;

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
		$member = $this->memData($_GET);
		App::view($member);
	}
	
	public function memData($params)
	{
		$row = $this->db->column()
					->table("member")
					->data($params)
					->where()
					->select()->row();
		
		unset($row['memPw'], $row['regDt'], $row['modDt']);
		if (isset($row['cellPhone']) && preg_match("/(\d{3})-(\d{4})-(\d{4})/", $row['cellPhone'], $metches)) {
			$row['cellPhone'] = $metches[1] . $metches[2] . $metches[3];
		}
		return $row;
	}
}