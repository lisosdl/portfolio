<?php
/** 공통 함수 */

/**
* 변수, 객체, 배열의 데이터 확인 함수
*
* @param Mixed $data 확인 데이터 
*/
function debug($data = [])
{
	echo "<pre style='background-color: black; color: yellow; font-size: 12px; padding: 10px; font-weight: bold;'>";
	print_r($data);
	echo "</pre>";
}

/**
* 설정파일 추출
*
*/
function getConfig()
{
	// 경로설정
	$path = __DIR__ . "/../../config.ini";
	// 파일 추출
	$config = parse_ini_file($path);
	
	// 추출한 파일 반환
	return $config;
}

/**
* 메시지 출력, 이전 페이지로 이동
*
*/
function msg($msg)
{
	echo "<script>alert('{$msg}');history.back();</script>";
	exit;
}

/**
*
*
*/
function message($msg, $url)
{
	echo "<script>alert('{$msg}');location.href='{$url}';</script>";
	exit;
}

/**
* 페이지 이동
*
*/
function go($url)
{
	echo "<script>location.href='{$url}';</script>";
	exit;
}

/**
* 로그인 확인
*
*/
function login()
{
	if (isset($_SESSION['member']) || !empty($_SESSION['member'])) {
		return true;
	} else {
		return false;
	}
}