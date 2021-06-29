<form method='post' action='<?=$path?>indb' autocomplete='off'>
	<input type='hidden' name='mode' value='<?=$file?>'>
	<div class='login'>
		<div class='box'>
			<div class='logo'>
				<a href='/Front/Main/main'>
					<img src='<?=$ciPath?>mylogo.png'>
				</a>
			</div>
			<div class='modeTit'>
				<div class='title'>관리자 로그인</div>
				<div class='mode'>
					<a href='/Admin/Member/join'>회원가입</a> / 
					<a href='/Front/Member/login'>사용자모드</a>
				</div>
			</div>
			<input type='text' name='memId' placeholder='아이디'>
			<input type='password' name='memPw' placeholder='비밀번호'>
			<input type='submit' value='로그인'>
		</div>
	</div>
</form>