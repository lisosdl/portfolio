<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// 인스턴스 생성
$instances = [];

class App
{
	/** 
	* 로그 기록 
	*
	* @param String $msg 기록 내용 
	* @mode String 처리모드 (info, warning, error, notice, critical)
	*/
	public static function log($msg, $mode = "info")
	{
		$mode = strtolower($mode);
		$logPath = __DIR__ . "/../log/".date("Ymd").".log";
		
		$log = $log ?? new Logger('general');
		$streamHandler = $streamHandler ?? new StreamHandler($logPath, Logger::DEBUG);
		$log->pushHandler($streamHandler);
		// mode에 따른 메세지 출력
		$log->$mode($msg);
		
	}
	
	/**
	* 인스턴스 생성 
	*
	* @param String $nsp - 클래스명을 포함한 네임스페이스
	* @param Array $args - 생성자(__cunstruct()) 인수
	*
	* @return Object 생성된 인스턴스
	*/
	public static function load($nsp, ...$args)
	{
		/**
		 $GLOBALS['instances'][$nsp]가 true || false 일경우
		 true = $GLOBALS['instances'][$nsp]
		 false = ""
		*/
		 $GLOBALS['instances'][$nsp] = $GLOBALS['instances'][$nsp] ?? "";
		 // 전역변수 instances 배열에 생성된 객체가 없을경우
		 if (!$GLOBALS['instances'][$nsp]) {
			 /**
			  args 가 true || false 일경우
			  ture = $args
			  false = []
			 */
			 $args = $args ?? [];
			 // 찾은클래스의 객체생성
			 $class = new ReflectionClass($nsp);
			 $GLOBALS['instances'][$nsp] = $class->newInstanceArgs($args);
		 }
		 
		 // 객체를 반환
		 return $GLOBALS['instances'][$nsp];
	}//end load()
	
	/**
	* URI 매칭을 위한 REQUEST URI 가공
	*
	* @return Array - $pathData - type, dir, file
	*/
	public static function processing()
	{
		$path = [];
		$pathData = [];
		
		// 현재위치 URI 추출
		$uri = $_SERVER['REQUEST_URI'];
		
		// URI가 http://lisosdl.cafe24.com/ 일경우
		if ($uri == '/') { // 프론트 메인
			array_unshift($path, "front", "main");
			$uri .= implode('/', $path);
		}
		
		// '/'이후 (?와~가 아닐때) 여러번 반복
		$pattern = "/\/([^\?]+)/";
		
		/**
		 현재위치 URI가 '/'이후 ? 가 아닐때 반복매칭
		 ?이후 문자를 제거 (쿼리스트링 형식을 제거)
		 매치된 데이터를 $matches에 추출
		*/
		if (preg_match($pattern, $uri, $matches)) {
			
			// 추출한 URI를 '/'단위로 나눠서 배열형태로 재구성
			$path = explode("/", $matches[1]);
			
			// type이 정해지지 않은경우 front
			if (!(strtolower($path[0]) == "admin") && !(strtolower($path[0]) == "front")) {
				array_unshift($path, "front");
			}
			
			// 사이트 타입 : 관리자모드-> admin, 사용자모드-> front 
			$type = ucfirst($path[0]);
			
			// 배열을 역순으로 새로 작성
			$path = array_reverse($path);
			
			// URI에 admin이 있을경우
			if (strtolower($path[0]) == 'admin') { // 관리자메인
				// path 첫번째 열부터 index($path[0])을 추가 나머지열은 뒤로 밀림
				array_unshift($path, "list", "member");
			} else if (strtolower($path[1]) == 'admin') {
				array_unshift($path, "list");
			} else { // 폴더별 메인 페이지
				if (empty($path[2])) {
					array_unshift($path, "index");
				}
			}
			
			// 폴더, 파일이름
			$dir = ucfirst($path[1]);
			$file = $path[0];
			
			$pathData = [$type, $dir, $file];
		}//endif
		
		return $pathData;
		
	}//end processing()
	
	/**
	* 컨트롤러 매칭
	* REQUEST URI에 매칭되는 컨트롤러 호출
	*
	*/
	public static function routes()
	{
		$pathData = implode("\\", self::processing());
		
		// URI에 따라 컨트롤러 호출
		$nsp = "\\Controller\\{$pathData}Controller";
		/**
		* 없는 페이지 체크 - class_exists 
		*  클래스가 존재 X -> 없는 페이지 -> 없는 페이지 안내로 이동 
		* Response 헤더 -> Location -> 페이지 이동
		*/
		if (!class_exists($nsp)) {
			header("Location: /Error/err404");
			return;
		}
		
		$controller = self::load($nsp);
		
	}//end routes()
	
	/**
	* 뷰 출력
	* REQUEST URI에 매칭되는 뷰 출력
	*
	* @param Array $params 키 => 값, ...
	* @return $키 = 값, ...
	*/
	public static function view($params = [], $pagination = "")
	{
		// URI 가공 메서드 실행
		$pathData = self::processing();
		// type 구분
		$type = $pathData[0];
		$dir = $pathData[1];
		// file 이름
		$file = $pathData[2];
		// REQUEST URI에 매칭되는 뷰 pathData
		if ($file == "join" || $file == "update" || $file == "write") {
			$pathData = "{$type}/{$dir}/form";
		} else {
			$pathData = implode("/", $pathData);
		}
		if (!empty($params) && $file != 'list') {
			extract($params);
			if (isset($params['year']) && isset($params['month']) && isset($params['yoils']) && isset($params['days']) && $params['data']) {
				unset($params['year'], $params['month'], $params['yoils'], $params['days'], $params['data']);
			}
		}
		
		// REQUEST URI에 매칭되는 뷰 path
		$viewPath = __DIR__ . "/../Views/{$pathData}.php";
		
		
		$path = "/{$type}/{$dir}/";
		$menuPath = __DIR__ . "/../Views/{$type}/Submenu/submenu.php";
		
		$member = $_SESSION['member'] ?? [];
			
		// type에 따른 style, script 경로
		$cssPath = "/Assets/{$type}/css/";
		$scriptPath = "/Assets/{$type}/js/";
		$ciPath = "/Assets/Common/images/";
		$imagePath = "/Assets/{$type}/images/";
		
		if ($file == "err404") { // 에러 view
			$outlinePath = __DIR__ . "/../Views/Front/Outline/";
			include $outlinePath . "Header/error.php";
			include $viewPath;
			include $outlinePath . "Footer/error.php";
		} else { // type별 view
			$outlinePath = __DIR__ . "/../Views/{$type}/Outline/";
			include $outlinePath . "Header/main.php";
			if (file_exists($menuPath)) {
				include_once $menuPath;
			}
			include $viewPath;
			include $outlinePath . "Footer/main.php";
		}//endif
	}//end viewPrint()
	
	/**
	* 초기 boot시 Component, Controller 추가될 파일목록
	*
	* @param Array 조회할 디렉토리 목록
	* @return Array 디렉토리내 모든 파일목록(서브디렉토리 포함)
	*/
	public static function ccFileList ($dirs = [])
	{
		// list 배열생성
		$list = [];
		// 디렉토리 순회
		foreach ($dirs as $dir) {
			// 디렉토리 스캔
			$fileList = scandir($dir);
			
			// 값이 . 또는 .. 인경우 배열제거
			unset($fileList[array_search(".", $fileList, true)]);
			unset($fileList[array_search("..", $fileList, true)]);
			
			// 디렉토리 또는 파일이 존재하지 않을경우 멈춤
			if (count($fileList) < 1) {
				break;
			}
			// 스캔한 디렉토리 리스트를 순회
			foreach ($fileList as $flist) {
				// php파일일경우 list에 추가
				if (preg_match("/.php$/i", $flist)) { 
					$list[] = $dir . "/" . $flist;
				} else if (is_dir($dir."/".$flist)) { // 디렉토리가 존재하면 재귀적으로 순회
					$_list = self::ccFileList([$dir."/".$flist]);
					// 재귀적으로 순회 후 값이 있을경우
					if ($_list) {
						// 배열을 합침
						$list = array_merge($list, $_list );
					}
				} // endif
			} 
		} // endforeach
	
		return $list;
	} // end ccFileList()

	/**
	* 로그기록
	*
	*/
	public function logRecord($result, $mode)
	{
		if ($result) {
			self::log("{$mode} 성공", "INFO");
		} else {
			self::log("{$mode} 실패", "INFO");
		}
	}// end logRecord()
	
} // end class App