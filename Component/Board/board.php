<?php

namespace Component\Board;

class board
{
	public function __construct()
	{
		global $db;
		$this->db = $db;
	}
	
	public function validator($params = [])
	{
		extract($params);
		switch ($mode) {
			case "write" :
				if (empty($subject) || $subject == "") {
					msg("제목을 입력해 주세요.");
				}
				
				if (empty($poster) || $poster == "") {
					msg("작성자를 입력해주세요.");
				} else if (strlen($poster) > 20) {
					msg("작성자는 20자 이내로 입력해 주세요.");
				}
				return;
				break;
			case "delete" :
				unset($params['mode']);
				$row = $this->db->table("board")
								->column()
								->data($params)
								->where()
								->select()
								->row();
				if (empty($row) || !isset($row)) {
					msg("등록된 사용자 정보가 존재하지 않습니다.");
				}
				return;
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