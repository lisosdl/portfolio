<?php

namespace Controller\Front\Member;

class logoutController
{
	public function __construct()
	{
		if (!login()) {
			message("로그인후 이용해 주세요.", "/Admin/Member/login");
		}
		session_destroy();
		go("/Front/Main/main");
	}
}