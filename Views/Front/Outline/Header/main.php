<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" type='text/css' href='<?=$cssPath?>style.css?t=<?=time()?>'>
	<link rel="stylesheet" type="text/css" href='<?=$cssPath?>fullpage.min.css'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
	<script src='<?=$scriptPath?>fullpage.min.js'></script>
	<script src='<?=$scriptPath?>script.js?t=<?=time()?>'></script>
	<script type='text/babel' src='<?=$scriptPath?>common.js?t=<?=time()?>'></script>
	<title>방정환 Portolio</title>
</head>
<body>
<?php if ($file != 'index') : ?>
<?php if (!login()) : ?>
	<ul class='topMenus'>
		<li>
			<a href='/Front/Board/list'>게시판</a>
		</li>
		<li>
			<a href='/Front/stock/list'>주식차트</a>
		</li>
		<li>
			<a href='/Admin/Member/login'>관리자모드</a>
		</li>
		<li>
			<a href='/Front/Member/login'>로그인</a>
		</li>
		<li>
			<a href='/Front/Member/join'>회원가입</a>
		</li>
	</ul>
	<?php else : ?>
	<?=isset($_SESSION['member'])?$_SESSION['member']['memNm']."님(":""?>
	<?=isset($_SESSION['member'])?$_SESSION['member']['memId']:""?>
		<?php if (isset($_SESSION['member']) && $_SESSION['member']['level'] == 1) : ?>
		관리자 계정
		<?php endif; ?>
	<?=isset($_SESSION['member'])?")":""?>
	<ul class='topMenus menuLogin'>
		<li>
			<a href='/Front/Board/list'>게시판</a>
		</li>
		<li>
			<a href='/Front/stock/list'>주식차트</a>
		</li>
		<li>
			<a href='/Admin/Member/list'>관리자모드</a>
		</li>
		<li>
			<a href='/Front/Member/logout'>로그아웃</a>
		</li>
	</ul>
	<?php endif; ?>
	
	<div class='logoBox'>
	<div class='logo'>
		<a href='/Front/Main/main'>
			<img src='<?=$ciPath?>mylogo.png'>
		</a>
	</div>
	</div>
<?php endif; ?>