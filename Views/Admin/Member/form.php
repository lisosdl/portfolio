<form method='post' action='<?=$path?>indb' autocomplete='off' class='form<?php if (!login()) echo " logged_out";?>'>
	<input type='hidden' name='mode' value='<?=$file?>' class='<?=login()?"login":"logout"?>'>
	<?php if (isset($memNo)) : ?>
	<input type='hidden' name='memNo' value='<?=$memNo?>'>
	<?php endif; ?>
	<div class='<?=$file?>'>
		<div class='box'>
			<div class='logo'>
				<a href='/Front/Main/main'>
					<img src='<?=$ciPath?>mylogo.png'>
				</a>
			</div>
			<div class='modeTit'>
				<div class='title'><?=isset($memNo)?"회원수정":"관리자 회원가입"?></div>
				<a href='/Admin/Member/login'>로그인</a>
			</div>
					<?php if (isset($memId)) : ?>
					<?=$memId?>
					<input type='hidden' name='memId' value='<?=$memId?>'>
					<?php else : ?>
					<input type='text' name='memId' placeholder='아이디'>
					<?php endif; ?>
					<input type='password' name='memPw' placeholder='비밀번호'>
					<input type='password' name='memPwRe' placeholder='비밀번호 확인'>
					<?php if (isset($memNm)) : ?>
					<?=$memNm?>
					<input type='hidden' name='memNm' value='<?=isset($memNm)?$memNm:""?>'>
					<?php else : ?>
					<input type='text' name='memNm' placeholder='이름'>
					<?php endif; ?>
					<input type='email' name='email' value='<?=isset($email)?$email:""?>' placeholder='이메일'>
					<input type='text' name='cellPhone' value='<?=isset($cellPhone)?$cellPhone:""?>' placeholder='휴대전화번호'>
			<?php if ($file == "update") : ?>
			<input type="hidden" name='modDt' value='<?=date("Y-m-d H:i:s")?>'>
			<?php endif; ?>
			<input type='submit'  value='<?=isset($memNo)?"회원수정":"회원가입"?>'>
		</div>
	</div>
</form>