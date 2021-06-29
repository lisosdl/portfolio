<?php

namespace Controller\Admin\Board;

use App;

class writeController
{
	public function __construct()
	{
		if (!login()) {
			message("로그인후 이용해 주세요.", "/Admin/Member/login");
		}
		if ($_SESSION['member']['level'] == 0) {
			message("접근 권한이 없습니다.", "/Front/Board/list");
		}
		App::view();
	}
}