<?php

namespace Controller\Front\Board;

use App;

class boardController
{
	public function __construct()
	{
		global $db;
		$this->db = $db;
		$_POST = array_merge($_GET, $_POST);
		$board = $this->index($_POST);
		App::view($board);
	}
	
	public function index($params = [])
	{
		$row = $this->db->table("board")
								->column()
								->data($params)
								->where()
								->select()
								->row();
		
		$regDt = explode(" ", $row['regDt']);
		$modDt = explode(" ", $row['modDt']);
		$row['regDt'] = $regDt[0];
		$row['modDt'] = $modDt[0];
		
		return $row;
	}
}