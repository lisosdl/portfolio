<?php

namespace Controller\Admin\Board;

use App;

class indbController
{
	public function __construct()
	{
		global $db;
		$this->db = $db;
		$_POST = array_merge($_POST, $_GET);
		$board = App::load(\Component\Board\board::class);
		$board->validator($_POST);
		$this->index($_POST);
	}
	
	public function index($params = [])
	{
		extract($params);
		switch ($mode) {
			case "write" :
				$this->db->table("board")
							->column(array_keys($params))
							->data($params)
							->insert();
				
				go("/Admin/Board/list");
				break;
			case "delete" :
				$this->db->table("board")
							->column()
							->data($params)
							->where()
							->delete();
							
				go("/Admin/Board/list");
				break;
			case "deleteAll" :
				$this->db->table("board")
							->column(["id"])
							->data($params)
							->in()
							->where()
							->delete();
				
				go("/Admin/Board/list");
				break;
			case "update" :
				$result = $this->db->table("board")
							->data($params)
							->where()
							->update();
				
				go("/Admin/Board/list");
				break;
			case "" :
				
				break;
			case "" :
				
				break;
		}
	}
}