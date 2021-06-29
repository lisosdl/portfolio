<?php

namespace Controller\Admin\Member;

use App;

class indbController
{
	public function __construct()
	{
		global $db;
		$this->db = $db;
		$_POST = array_merge($_POST, $_GET);
		$member = App::load(\Component\Member\adminMember::class);
		$member->validator($_POST);
		$this->index($_POST);
		
	}
	
	public function index($params = [])
	{
		extract($params); 
		
		switch ($mode) {
			/**
			* 회원가입
			*
			*/
			case "join" :
				if (isset($params['cellPhone'])) {
					if (preg_match("/(\d{3})(\d{4})(\d{4})/", $params['cellPhone'], $metches)) {
						$params['cellPhone'] = $metches[1] . "-" . $metches[2] . "-" . $metches[3];
					}
				}
				$params['memPw'] = password_hash($params['memPw'], PASSWORD_DEFAULT, ["cost" => 10]);
				$result = $this->db->table("member")
								->column(array_keys($params))
								->data($params)
								->insert();
				
				session_destroy();
				go("/Admin/Member/login");
				break;
			/**
			* 로그인
			*
			*/
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
				
				go("/Admin/Member");
				break;
			case "update" :
				if (isset($params['cellPhone'])) {
					if (preg_match("/(\d{3})(\d{4})(\d{4})/", $params['cellPhone'], $metches)) {
						$params['cellPhone'] = $metches[1] . "-" . $metches[2] . "-" . $metches[3];
					}
				}
				if (empty($params['memPw']) || $params['memPw'] == "") {
					unset($params['memPw'], $params['memPwRe']);
				}
				$result = $this->db->table("member")
								->data($params)
								->where()
								->update();
				
				go("/Admin/Member");
				break;
			case "delete" :
				$result = $this->db->table("member")
											->data($params)
											->where()
											->delete();
				
				go("/Admin/Member");
				break;
			case "deleteAll" :
				$this->db->table("member")
							->column(["memNo"])
							->data($params)
							->in()
							->where()
							->delete();
				
				go("/Admin/Member");
				break;
		}
		
		return;
	}
}