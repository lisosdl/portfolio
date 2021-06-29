<?php

namespace Component\Member;

use App;

class adminMember
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
			case "join" :
				/** 아이디 유효성 검사 **/
				$this->idValidator($memId, $mode);
				
				// 중복 검사
				$row = $this->db->count()
											->table("member")
											->data(["memId"=>$memId])
											->where()
											->select()->row();
				if ($row['cnt'] > 0) {
					msg("사용할수 없는 아이디 입니다.");
				}
				/** 비밀번호 유효성 검사 **/
				$this->pwValidator($memPw);
				// 비밀번호확인 입력값 확인
				if (!$memPwRe || $memPwRe == "") {
					msg("비밀번호를 확인해주세요.");
				}
				// 비밀번호 확인
				if ($memPw != $memPwRe) {
					msg("비밀번호가 일치하지 않습니다.");
				}
				
				/**  회원명 입력값 확인 **/
				if (!$memNm || $memNm == "") {
					msg("이름을 입력해 주세요.");
				}
				
				/** 휴대전화번호 유효성 검사 **/
				if ($cellPhone && $cellPhone != "") {
					$this->cpValidator($cellPhone);
				}
				break;
			case "login" :
				// 입력값 확인
				if (!$memId || $memId == "") {
					msg("아이디를 입력해 주세요.");
				}
				// 입력값 확인
				if (!$memPw || $memPw == "") {
					msg("비밀번호를 입력해 주세요.");
				}
				break;
			case "delete" :
				unset($params['mode']);
				$row = $this->db->table("member")
								->column()
								->data($params)
								->where()
								->select()
								->row();
				if (empty($row) || !isset($row) || !$row) {
					msg("등록된 사용자 정보가 존재하지 않습니다.");
				}
				break;
			case "update" :
				if ($memPw != "" || !empty($memPw)) { // 비밀번호 변경O
					/** 비밀번호 유효성 검사 **/
					$this->pwValidator($memPw);
					// 비밀번호확인 입력값 확인
					if (!$memPwRe || $memPwRe == "") {
						msg("비밀번호를 확인해주세요.");
					}
					// 비밀번호 확인
					if ($memPw != $memPwRe) {
						msg("비밀번호가 일치하지 않습니다.");
					}
				}
				
				/** 휴대전화번호 유효성 검사 **/
				if ($cellPhone && $cellPhone != "") {
					$this->cpValidator($cellPhone);
				}
				break;
		}//endswitch
		return;
	}
	
	/**
	* 아이디 유효성 검사
	*
	* 1. 특수문자 X, 한글 X, 영어대문자 O, 숫자 O
	* 2. 영어 소문자 무조건 포함
	* 3. 8~20자
	*/
	public function idValidator($memId, $mode)
	{
		// 입력값 확인
		if (!$memId || $memId == "") {
			msg("아이디를 입력해 주세요.");
		}
		if ($mode == "join") {
			// 형식 확인
			if (preg_match("/[^a-z0-9]/", $memId) || !preg_match("/[a-z0-9]/i", $memId) || strlen($memId) < 8 || strlen($memId) > 20) {
				msg("8~20자 사이의 특수문자, 한글 이외의 영어소문자를 포함한 문자로 입력해 주세요.");
			}
		}
		return;
	}
	
	/**
	* 비밀번호 유효성 검사
	*
	* 1. 한글 X
	* 2. 특수문자, 영어대문자, 영어소문자, 숫자 각각 1자 이상
	* 3. 8~20자
	*/
	public function pwValidator($memPw)
	{
		// 입력값 확인
		if (!$memPw || $memPw == "") {
			msg("비밀번호를 입력해 주세요.");
		}
		// 비밀번호 형식 확인
		if (preg_match("/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/", $memPw) || !preg_match("/[`~!@#$%^&*()_+}{\[\];:'\",<.>\\\|\/?=\-]/", $memPw) || !preg_match("/[a-z]/", $memPw) || !preg_match("/[A-Z]/", $memPw) || !preg_match("/[0-9]/", $memPw)) {
			msg("비밀번호는 8~20자 사이의 한글을 제외한 특수문자, 영어 대소문자, 숫자를 각각 1자이상 조합해주세요. ");
		}
		return;
	}
	
	/**
	* 휴대전화번호 유효성 검사
	*
	* 1. 숫자만 O
	* 2. 13자
	* 3. (010)(1234)(1234)
	*/
	public function cpValidator($cellPhone)
	{
		if (preg_match("/[^0-9]/", $cellPhone)) {
			msg("휴대전화번호는 숫자만 입력해 주세요");
		}
		if (strlen($cellPhone) != 11) {
			msg("휴대전화번호는 11자 입니다.");
		}
		if (!preg_match("/(01[016789])(\d{4})(\d{4})/", $cellPhone)) {
			msg("휴대전화번호 형식이 맞지 않습니다.");
		}
		return;
	}
}