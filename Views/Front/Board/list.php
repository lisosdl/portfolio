<div class='boardList'>
	<ul class='title'>
		<li class='num'>번호</li>
		<li class='sub'>제목</li>
		<li class='poster'>글쓴이</li>
		<li class='regDt'>작성/수정일자</li>
	</ul>
	<div class='list'>
	<?php foreach ($params as $k => $v) : ?>
		<ul>
			<li class='num'>
				<?=$k+1?>
			</li>
			<li class='sub'>
				<a href='/Front/Board/board?id=<?=$v['id']?>'>
				<?=$v['subject']?>
				</a>
			</li>
			<li class='poster'>
				<?=$v['poster']?>
			</li>
			<li class='regDt'>
				<?=$v['regDt']?>/
				<?=$v['modDt']?>
			</li>
		</ul>
		<?php endforeach; ?>
	</div>
	
	<div class='page'>
		<?php foreach ($pagination as $v) :?>
		<?=$v?>
		<?php endforeach; ?>
	</div>
</div>