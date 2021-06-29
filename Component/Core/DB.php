<?php

namespace Component\Core;

use App;
/**
* INSERT, UPDATE, DELETE, SELECT, WHERE
* INSERT INTO 테이블명 (컬럼, ...) VALUES (값, ..)
* UPDATE 테이블명 SET 컬럼 = 값, ... WHERE 조건
* DELETE FROM 테이블명 WHERE 조건
* SELECT 컬럼, ... FROM 테이블명 WHERE 조건
*/
class DB extends \PDO
{
	private $table; // 테이블 변수
	private $column = "*"; // 컬럼 기본값지정
	private $stmt; // PDOStatment 오브젝트
	private $params = []; // 입력받은 데이터
	private $data = []; // 바인딩변수 저장
	private $where = ""; // where구문
	private $whereParams = [];
	private $in = "";
	private $limit = "";
	
	public function __construct()
	{
		try {
			$config = getConfig();
			$dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
			parent::__construct($dsn, $config["username"], $config["password"]);
			App::log("DB연결성공", "info");
		} catch (\PDOException $e) {
			App::log($e->getMessage(), "error");
			echo $e->getMessage();
			exit;
		}
	}
	
	/**
	* DB 테이블 처리
	* $this->table 에 테이블값 저장
	* 
	* @return $this
	*/
	public function table($table)
	{
		$this->table = $table;
		
		return $this;
	}
	
	/**
	* 조회할 컬럼 처리
	* $this->column에 컬럼값 저장
	* 컬럼, 컬럼, 컬럼, 컬럼 ......
	*
	* @return $this
	*/
	public function column($column = ["*"])
	{
		foreach ($column as $k => $v) {
		if ($v == "mode") unset($column[$k]);
		if ($v == "memPwRe") unset($column[$k]);
		}
		$column = array_values($column);
		$this->column = implode(", ", $column);
		
		return $this;
	}
	
	/**
	* count처리
	* count구문 column에저장
	*
	* @return $this
	*/
	public function count()
	{
		$this->column = "COUNT(*) AS cnt";
		
		return $this;
	}
	
	/**
	* 입력받은 데이터 처리
	* unset = 불필요한 데이터 제거
	* if = 빈열제거
	* foreach => $k=DB컬럼이름, :$k=바인딩변수
	* data에 저장
	*
	* @param Array
	* @return $this
	*/
	public function data($params = [])
	{
		$data = [];
		
		if (isset($params['mode']) && $params['mode'] == "login") unset($params['memPw']);
		if ((isset($params['mode']) && $params['mode'] == "deleteAll") || (isset($params['mode']) && $params['mode'] == "write")|| (isset($params['mode']) && $params['mode'] == "join")) {
			if (isset($params['mode'])) unset($params['mode']);
			if (isset($params['memPwRe'])) unset($params['memPwRe']);
			$data = array_keys($params);
		} else {
			if (isset($params['mode'])) unset($params['mode']);
			if (isset($params['memPwRe'])) unset($params['memPwRe']);
			foreach ($params as $k => $v) {
				$data[] = "{$k} = :{$k}";
			}
		}
		
		$this->data = $data;
		$this->params = $params;
		return $this;
	}
	
	/**
	* where 처리
	* implode => 컬럼이름 = 바인딩변수, 컬럼이름 = 바인딩변수 ...
	* 형태로 where에 저장
	*
	* @return $this
	*/
	public function where()
	{
		$this->whereParams = $this->data;
		if (in_array("memNo = :memNo", $this->whereParams)) {
			foreach ($this->whereParams as $k => $v) {
				if ($v != "memNo = :memNo") unset($this->whereParams[$k]);
			}
		} else if (!in_array("memNo = :memNo", $this->whereParams) && in_array("memId = :memId", $this->whereParams)) {
			foreach ($this->whereParams as $k => $v) {
				if ($v != "memId = :memId") unset($this->whereParams[$k]);
			}
		} else if (in_array("id = :id", $this->whereParams)) {
			foreach ($this->whereParams as $k => $v) {
				if ($v != "id = :id") unset($this->whereParams[$k]);
			}
		}
		if (!empty($this->in) || $this->in != "") {
			$this->where = " WHERE " . $this->column . " " . $this->in;
		} else {
			$this->where = " WHERE " . implode(" AND ", $this->whereParams);
		}
		
		return $this;
	}
	
	/**
	* IN
	* WHERE 컬럼 IN (값1, 값2, 값3, ..)
	* where구문의 선택된 컬럼에 값1, 값2, 값3, .. 이 포함된
	* 데이터를 찾음
	*
	* @return $this
	*/
	public function in()
	{
		$this->in = "IN (:" . implode(", :", $this->data) . ")";
		
		return $this;
	}
	
	/**
	* limit 처리
	* 
	* @return $this
	*/
	public function limit($limit, $start = "")
	{
		$this->limit = " LIMIT " . $limit;
		if ($start != "") $this->limit = " LIMIT " . $start . ", " . $limit;
		
		return $this;
	}
	
	/**
	* SELECT처리
	* SELECT 컬럼, ... FROM 테이블명 WHERE 조건
	* bind() 데이터 바인딩처리
	* 
	* @return $this
	*/
	public function select()
	{
		$sql = "SELECT " . $this->column . " FROM " . $this->table;
		if ($this->where != "") $sql .= $this->where;
		if ($this->limit != "") $sql .= $this->limit;
		$this->stmt = $this->prepare($sql);
		$this->bind();
		$this->stmt->execute();
		
		return $this;
	}
	
	/**
	* insert
	* INSERT INTO 테이블명 (컬럼, ...) VALUES (값, ..)
	*
	* @return Boolean true||false
	*/
	public function insert()
	{
		$sql = "INSERT INTO " . $this->table . " (" . $this->column . ")" . " VALUES " . "(:" . implode(", :", $this->data) . ")";
		$this->stmt = $this->prepare($sql);
		$this->bind();
		$result = $this->stmt->execute();
		
		return $result;
	}
	
	/**
	* UPDATE
	* UPDATE 테이블명 SET 컬럼 = 값, ... WHERE 조건
	*
	* @return Boolean true||false
	*/
	public function update()
	{
		$sql = "UPDATE " . $this->table . " SET " . implode(", ", $this->data) . " " . $this->where;
		$this->stmt = $this->prepare($sql);
		$this->bind();
		$result = $this->stmt->execute();
		
		return $result;
	}
	
	/**
	* DELETE
	* DELETE FROM 테이블명 WHERE 조건
	*
	* @return Boolean true||false $result
	*/
	public function delete()
	{
		$sql = "DELETE FROM " . $this->table . $this->where;
		$this->stmt = $this->prepare($sql);
		$this->bind();
		$result = $this->stmt->execute();
		return $result;
	}
	
	/**
	* 데이터 바인딩 처리
	* foreach => $k=바인딩 변수, $v=바인딩데이터
	* $type = Integer||String 데이터타입
	*
	* @param Array
	*/
	public function bind()
	{
		foreach ($this->params as $k => $v) {
			$type = is_numeric($v)?\PDO::PARAM_INT:\PDO::PARAM_STR;
			$this->stmt->bindValue(":".$k, $v, $type);
			
		}
		
		return;
	}
	
	/**
	* 데이터 반환값 처리
	* while = DB에서 찾은 데이터 배열형태로 저장
	* fetchall = 데이터가 많아지면 메모리문제가 발생
	* if = count를 실행했을경우
	* array_reduce = 2차원배열을 1차원배열로 반환
	*
	* @return Array $row
	*/
	public function row()
	{
		$row = [];
		while($list = $this->stmt->fetch(\PDO::FETCH_ASSOC)){
			$row[] = $list;
		}
		
		if ($this->column == "COUNT(*) AS cnt" || count($row) == 1) {
			$row = array_reduce($row, "array_merge", array());
		}
		
		return $row;
	}
}
