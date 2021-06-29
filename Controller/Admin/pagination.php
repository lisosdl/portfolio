<?php

namespace Controller\Admin;

class pagination
{
	public function __construct()
	{
		global $db;
		$this->db = $db;
	}
	
	/**
	* 현재 페이지
	* GET방식으로 현재페이지 체크
	* GET데이터가 없을경우 0번째페이지
	*
	* @return Integer $page
	*/
	public function nowPage()
	{
		$page = "";
		if (isset($_GET['page'])) {
			$page = $_GET['page'];
		}
		
		return $page;
	}
	
	/**
	* 마지막 페이지
	* 0 ~ n 페이지
	*
	* @param $page = 목록을 나눌 단위
	* @return Array $lpp = $lastPage, $point
	*/
	public function lastPage($table, $page = 10)
	{
		$row = $this->db->count()
					->table($table)
					->select()->row();
		
		extract($row);
		$point = $cnt % $page;
		$lastPage = floor($cnt / $page);
		if (!$point) $lastPage -= 1;
		$lpp = [ "lastPage" => $lastPage, "point" => $point ];
		return $lpp;
	}
}