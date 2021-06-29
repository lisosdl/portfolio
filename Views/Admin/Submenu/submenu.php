<?php if (login()) : ?>
<div class='submenu'>
	<div class='logo'>
		<a href='<?=$path?>'>
			<img src='<?=$ciPath?>mylogo.png'>
		</a>
	</div>
	<div class='content'>
		<div class='box memtitle'>
			<input type='checkbox' id='member'>
			<label for='member'>
				<i class='memIcon xi-angle-right-min'></i>
				회원관리
			</label>
		</div>
		<ul class='member_box dn'>
			<li>
				<a href='/<?=$type?>/Member/list'>회원목록</a>
			</li>
			<li>
				<a href='/<?=$type?>/Member/join'>회원추가</a>
			</li>
		</ul>
		<div class='box boardtitle'>
			<input type='checkbox' id='board'>
			<label for='board'>
				<i class='boardIcon xi-angle-right-min'></i>
				게시물관리
			</label>
		</div>
		<ul class='board_box dn'>
			<li>
				<a href='/<?=$type?>/Board/list'>게시물목록</a>
			</li>
			<li>
				<a href='/<?=$type?>/Board/write'>게시물작성</a>
			</li>
		</ul>
	</div>
</div>
<?php endif; ?>