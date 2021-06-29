<script type='text/babel' src='<?=$scriptPath?>main.js'></script>
<div class='main_page'>
<ul id="menu">
	<li data-menuanchor="firstPage" class="active">
		<a href="#firstPage">Home</a>
	</li>
	<li data-menuanchor="2ndPage">
		<a href="#2ndPage">Skills</a>
	</li>
	<li data-menuanchor="3rdPage">
		<a href="#3rdPage">Project</a>
	</li>
	<li data-menuanchor="4thPage">
		<a href="#4thPage">About</a>
	</li>
	<li data-menuanchor="lastPage">
		<a href="#lastPage">Contact</a>
	</li>
</ul>

<div id="fullpage">
	<div class="section" id="section0">
		<h1 class='text'>
			방정환의 포트폴리오입니다.
		</h1>
	</div>
	<div class="section about_me" id="section1">
		<div class='tit'>Skills</div>
		<div class='skillsBox'>
			<div class='stit'>publishing & Front-end</div>
			<ul class='skills'>
				<li class='js'></li>
				<li class='html'></li>
				<li class='css'></li>
				<li class='jquery'></li>
			</ul>
			
			<div class='stit'>Back-end</div>
			<ul class='skills'>
				<li class='php'></li>
				<li class='node'></li>
			</ul>
		</div>
	</div>
	
	<div class="section " id="section2">
		<div class='tit_wrap'><span class='tit tit2'>Project</span></div>
		<ul class='portfolios'>
			<li class='portfolio'>
			<a href='/Front/Main/main'>
				<div class='phpProject'></div>
			</a>
				<div class='desc'>
				<a href='/Front/Main/main'>
					<div class='t1 font-_roboto'>PHP Board</div>
				</a>
					<div class='t3'>개발기간 : 2021.05.15 ~ 진행중</div>
					<div class='t3'>
						PHP 로그인, 게시판 관리 프로젝트<br><br>
						<a>#PHP</a>
						<a>#Javascript</a>
						<a>#css</a>
					</div>
				</div>
			</li>
		</ul>
		
		<ul class='portfolios'>
			<li class='portfolio'>
			<a href='https://bjungh.cafe24app.com/'>
				<div class='phpProject'></div>
			</a>
				<div class='desc'>
				<a href='https://bjungh.cafe24app.com/'>
					<div class='t1'>Node Board</div>
				</a>
					<div class='t3'>개발기간 : 2021.06.26 진행예정</div>
					<div class='t3'>
						Node.js 로그인, 게시판 관리 프로젝트<br><br>
						<a href='#'>#Node.js</a>
						<a href='#'>#Javascript</a>
						<a href='#'>#Html</a>
						<a href='#'>#css</a>
					</div>
				</div>
			</li>
		</ul>
	</div>
	
	<div class="section " id="section3">
		<div class='tit'>About Project!</div>
		<ul class='portfolios'>
			<li class='portfolio'>
			<a href='/Front/Board/list'>
				<div class='aboutProject'></div>
			</a>
				<div class='desc'>
				<a href='/Front/Board/list'>
					<div class='t1 font-_roboto'>PHP CODE 설명서</div>
				</a>
				</div>
			</li>
		</ul>
		
		<ul class='portfolios'>
			<li class='portfolio'>
			<a href='/Front/Board/list'>
				<div class='aboutProject'></div>
			</a>
				<div class='desc'>
				<a href='/Front/Board/list'>
					<div class='t1'>Node CODE 설명서</div>
				</a>
				</div>
			</li>
		</ul>
	</div>
	<div class="section " id="section4">
		<div class='tit_wrap'>
			<span class='tit tit3'>CONTACT!</span>
		</div>
		
		<a class='text'>Email : vqldwjdghks@naver.com</a>
		
		<a href='https://github.com/lisosdl' class='github_logo' target='_blank'>
			<img src='<?=$imagePath?>githubLogo.png'>
			<div class='giturl'>
				https://github.com/lisosdl
			</div>
		</a>
	</div>
</div>

</div>
<!--// main_page -->