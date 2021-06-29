<div class="boardList position">
	<form method='get' action='<?=$path?>indb'>
		<input type='hidden' name='mode' value='deleteAll'>
		<ul class='title'>
			<li class='cehckbox'>
				<input type='checkbox' id="allChecked">
			</li>
			<li class='num'>번호</li>
			<li class='sub'>제목</li>
			<li class='poster'>글쓴이</li>
			<li class='regDt'>등록일</li>
			<li class='modDt'>수정일</li>
			<li class='ud'>수정/삭제</li>
		</ul>
		<div class='list'>
		<?php if (is_array($params)) : ?>
		<?php foreach ($params as $k => $val) : ?>
			<ul>
				<li class='cehckbox'>
					<input type='checkbox' name='id<?=$val['id']?>' value='<?=$val['id']?>' class='ck'>
				</li>
				<li class='num'><?=$k+1?></li>
				<li class='sub'>
					<a href='/Admin/Board/board?id=<?=$val['id']?>'><?=$val['subject']?></a>
				</li>
				<li class='poster'><?=$val['poster']?></li>
				<li class='regDt'><?=$val['regDt'][0]?></li>
				<li class='modDt'><?=$val['modDt'][0]?></li>
				<li class='ud'>
					<a href='<?=$path?>indb?mode=delete&id=<?=$val['id']?>'>삭제</a>
					<a href='<?=$path?>update?id=<?=$val['id']?>'>수정</a>
				</li>
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