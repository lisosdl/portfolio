<form method='post' action='<?=$path?>indb' autocomplete='off'>
	<input type='hidden' name='mode' value='<?=$file?>'>
	<div class='join'>
		<div class ='box'>
			<div class='mode'>
				<a href='/Front/Member/login'>로그인</a>
			</div>
			<input type='text' name='memId' placeholder='아이디'>
			<input type='password' name='memPw' placeholder='비밀번호'>
			<input type='password' name='memPwRe' placeholder='비밀번호 확인'>
			<input type='text' name='memNm' placeholder='이름'>
			<input type='email' name='email' placeholder='이메일'>
			<input type='text' name='cellPhone' placeholder='휴대전화번호'>
			<input type='submit'  value='회원가입'>
		</div>
	</div>
</form>