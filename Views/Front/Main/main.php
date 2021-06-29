<div class='main'>
<div class='sbBox'>
	<div class='calendar'>
		<a href='?year=<?=$data['prevYear']?>&month=<?=$data['prevMonth']?>'>이전달</a>
		<div class='current'><?=$year?>.<?=$month?></div>
		<a href='?year=<?=$data['nextYear']?>&month=<?=$data['nextMonth']?>' class='nextMonth'>다음달</a>
		<ul class='yoils'>
		<?php foreach ($yoils as $yoil) : ?>
			<li><?=$yoil?></li>
		<?php endforeach; ?>
		</ul>
		<ul class='days'>
		<?php foreach ($days as $day) : ?>
			<li><?=$day['day']?></li>
		<?php endforeach; ?>
		</ul>

	</div>
	
	<div class='board'>
		<ul>
			<li>제목</li>
			<li>작성자</li>
			<li>등록일자</li>
		</ul>
		<?php foreach ($params as $k => $v) : ?>
		<ul>
			<li>
				<a href='/Front/Board/board?id=<?=$v['id']?>'>
				<?=$v['subject']?>
				</a>
			</li>
			<li>
				<?=$v['poster']?>
			</li>
			<li>
				<?=$v['regDt']?>
			</li>
		</ul>
		<?php endforeach; ?>
	</div>
</div>
	
	<div class='chart'>
		주식차트
	</div>
</div>