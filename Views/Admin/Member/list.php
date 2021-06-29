<div class='memList position'>
	<form method='get' action='<?=$path?>indb'>
		<input type='hidden' name='mode' value='deleteAll'>
		<ul class='title'>
			<li class='cehckbox'>
				<input type='checkbox' id="allChecked">
			</li>
			<li class='num'>번호</li>
			<li class='id'>아이디</li>
			<li class='name'>회원명</li>
			<li class='email'>이메일</li>
			<li class='cellPhone'>전화번호</li>
			<li class='level'>관리레벨</li>
			<li class='regDt'>가입일자</li>
			<li class='modDt'>수정일자</li>
			<li class='ud'>수정/삭제</li>
		</ul>
		<div class='list'>	
		<?php if (is_array($params)) : ?>
		<?php foreach ($params as $k => $val) : ?>
			<ul>
				<li class='cehckbox'>
					<input type='checkbox' name='memNo<?=$val['memNo']?>' value='<?=$val['memNo']?>' class='ck'>
				</li>
				<li class='num'><?=$k+1?></li>
				<li class='id'><?=$val['memId']?></li>
				<li class='name'><?=$val['memNm']?></li>
				<li class='email'><?=$val['email']?></li>
				<li class='cellPhone'><?=$val['cellPhone']?></li>
				<li class='level'><?=$val['level']?></li>
				<li class='regDt'><?=$val['regDt'][0]?></li>
				<li class='modDt'><?=$val['modDt'][0]?></li>
				<li class='ud'><a href='<?=$path?>indb?mode=delete&memNo=<?=$val['memNo']?>'>삭제</a>
				<a href='<?=$path?>update?memNo=<?=$val['memNo']?>'>수정</a></li>
			</ul>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class='page'>
			<?php foreach ($pagination as $v) :?>
			<?=$v?>
			<?php endforeach; ?>
			<input type='submit' value='선택삭제'>
		</div>
	</form>
</div>