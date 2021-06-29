$(function () {
	// 회원관리탭 리스트표시, 아이콘 변경
	$("#member").click(function () {
		listPrint("#member", ".member_box", ".memIcon");
	});
	
	// 게시물관리탭 리스트표시, 아이콘 변경
	$("#board").click(function () {
		listPrint("#board", ".board_box", ".boardIcon");
	});
	// 로그인 클래스가 있을때
	if ($('input[name=mode]').hasClass("login")) {
		$(".form").addClass("position");
	} else { // 없을때
		$(".form").removeClass("position");
	}
	
	// 체크박스 전체체크
	$("#allChecked").click(function () {
		if ($("#allChecked").is(":checked")) {
			$(".ck").prop("checked", true);
		} else {
			$(".ck").prop("checked", false);
		}
	});
});

/**
* dn클래스 display: none
* XEIcon 변경
*/
function listPrint(id, box, chclass) {
	if ($(id).is(":checked")) {
		$(box).removeClass("dn");
		$(chclass).removeClass("xi-angle-right-min").addClass("xi-angle-down-min");
	} else {
		$(box).addClass("dn");
		$(chclass).removeClass("xi-angle-down-min").addClass("xi-angle-right-min");
	}
}