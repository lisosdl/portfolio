<?php

namespace Controller\Front\Member;

use App;

class indbController
{
	public function __construct()
	{
		$memvt = App::load(\Component\Member\adminMember::class);
		$memvt->validator($_POST);
		global $db;
		$this->db = $db;
		$this->index($_POST);
	}
	
	public function index($params = [])
	{
		extract($params);
		switch ($mode) {
			case "join" :
				if (isset($params['cellPhone'])) {
					if (preg_match("/(\d{3})(\d{4})(\d{4})/", $params['cellPhone'], $metches)) {
						$params['cellPhone'] = $metches[1] . "-" . $metches[2] . "-" . $metches[3];
					}
				}
				$params['memPw'] = password_hash($memPw, PASSWORD_DEFAULT, ["cost" => 10]);
				$result = $this->db->table("member")
							->column(array_keys($params))
							->data($params)
							->insert();
				
				go("/Front/Member/login");
				return;
				break;
			case "login" :
				$row = $this->db->table("member")
										->data($params)
										->where()
										->select()->row();
				
				if (empty($row)) { // 데이터가 없을경우
					msg("아이디 일치하지 않습니다.");
				}
				
				$result = password_verify($params['memPw'], $row['memPw']);
				
				if (!$result) {
					msg("비밀번호가 일치하지 않습니다.");
				}
				
				unset($row['memPw'], $row['regDt'], $row['modDt']);
				
				$_SESSION['member'] = $row;
				
				go("/Front/Main/main");
				break;
			case "" :
				
				break;
			case "" :
				
				break;
			case "" :
				
				break;
		}
	}
}