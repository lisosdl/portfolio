<?php
/**
* Component, Controller 파일 자동 로드 
* Component -> Controller 순서로 include하기위한 작업
*
*/
// 로드할 경로 list
$path = [
	__DIR__ . "/../Component",
	__DIR__ . "/../Controller",
];

// app클래스의 ccFileList 함수 호출
$tmp = App::ccFileList($path);

// 빈배열 생성
$fileList = $tmp2 = [];
// Component, Controller 디렉토리내의 파일목록을 순회
foreach ($tmp as $t) {
	if (!preg_match("/Component/", $t)) { // Controller
		$tmp2[] = $t;
	} else {
		// Component
		$fileList[] = $t;
	}
}

// 배열순서 Component -> Controller
$fileList = array_merge($fileList, $tmp2);

// include순서
foreach ($fileList as $f) {
	include_once $f;
}