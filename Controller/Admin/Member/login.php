<?php

namespace Controller\Admin\Member;

use App;

class loginController
{
	public function __construct()
	{
		if (login()) {
			msg("잘못된 접근입니다.");
		}
		App::view();
	}
}