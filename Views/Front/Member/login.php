<form method='post' action='<?=$path?>indb' autocomplete='off'>
	<input type='hidden' name='mode' value='<?=$file?>'>
	<div class='login'>
		<div class='box'>
			<div class='mode'>
				<a href='/Admin/member/login'>관리자모드</a> / 
				<a href='/Front/Member/join'>회원가입</a>
			</div>
			<input type='text' name='memId' placeholder='아이디'>
			<input type='password' name='memPw' placeholder='비밀번호'>
			<input type='submit' value='로그인'>
		</div>
	</div>
</form>