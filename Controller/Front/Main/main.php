<?php

namespace Controller\Front\Main;

use App;

class mainController
{
	public function __construct()
	{
		global $db;
		$this->db = $db;
		$board = $this->board();
		$calendar = $this->calendar();
		foreach ($calendar as $k => $v) {
			$board[$k] = $v;
		}
		App::view($board);
	}
	
	public function calendar()
	{
		$year = $_GET['year'] ?? date("Y");
		$month = $_GET['month'] ?? date("m");
		
		$calendar = App::load(\Component\Calendar\Calendar::class);
		$data = $calendar->get($year, $month);
		$days = $data['days'];

		$yoils = $calendar->getYoils();
		
		$schedule = [
			"year" => $year,
			"month" => $month,
			"yoils" => $yoils,
			"days" => $days,
			"data" => $data
		];
		
		return $schedule;
	}
	
	public function board()
	{
		$row = $this->db->table("board")
								->column()
								->limit(10)
								->select()
								->row();
		foreach ($row as $k => $v) {
			$v['regDt'] = explode(" ", $v['regDt']);
			$row[$k]['regDt'] = $v['regDt'][0];
		}
		
		return $row;
	}
}