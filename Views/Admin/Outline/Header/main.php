<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
	<link rel="stylesheet" type='text/css' href='<?=$cssPath?>style.css?t=<?=time()?>'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="<?=$scriptPath?>script.js?t=<?=time()?>"></script>
</head>
<body>

<?php if (login()) : ?>
<div class='top'>
	<span class='title'>관리자 페이지</span>
	<span class='member'>
		<span class='memNm'><?=$member['memNm']?>님</span>
		<span class='memId'>(<?=$member['memId']?>)</span>
		<a href='<?=$path?>logout'>로그아웃</a>
	</span>
</div>
<?php endif; ?>