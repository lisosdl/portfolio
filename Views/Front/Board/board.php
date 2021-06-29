<div class='boardContent'>
	<dl>
		<dt>게시글 번호</dt>
		<dd><?=$id?></dd>
	</dl>
	<ul>
		<li class='subject'>
			제목 : <?=$subject?>
		</li>
		<li class='poster'>
			글쓴이 : <?=$poster?>
		</li>
		<li class='regDt'>
			작성일 : <?=$regDt?>
		</li>
		<li>
			수정일 : <?=($modDt == "")?"":$modDt;?>
		</li>
	</ul>
	<dl>
		<dt>내용</dt>
		<dd>
			<div class='content'>
				<?=$content?>
			</div>
		</dd>
	</dl>
</div>