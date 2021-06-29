<div class="write position">
<form method='post' action='/Admin/Board/indb' autocomplete='off'>
	<input type='hidden' name='mode' value='<?=$file?>'>
	<input type='hidden' name='id' value='<?=$id?>'>
	
	<div class='board'>
		<input type='text' name='subject' value='<?=isset($id)?$subject:""?>' placeholder='제목'>
		<input type='text' name='poster' value='<?=$member['memId']?>' disabled>
		<textarea name='content' placeholder='내용'><?=isset($id)?$content:""?></textarea>
		<input type='hidden' name='modDt' value='<?=date("Y-m-d H:i:s")?>'>
		<input type='submit' value='글<?=isset($id)?"수정":"작성"?>'>
	</div>
</form>
</div>