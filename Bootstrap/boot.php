<?php
session_start();

// 컴포저로 설치한 외부 모듈 자동 추가
include_once __DIR__ . "/../vendor/autoload.php";

// 공통함수
include_once "functions.php";
// 공통클래스
include_once "app.php";
// Component, Controller 파일 자동 추가
include_once "autoload.php";

$db = App::load(\Component\Core\DB::class);

App::routes();