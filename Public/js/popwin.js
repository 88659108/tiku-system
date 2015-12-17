
//·µ»Ø¶¥²¿
function b() {
	h = $(window).height(),
	t = $(document).scrollTop(),
	t > h ? $("#moquu_top").show() : $("#moquu_top").hide()
}


$(document).ready(function() {
	b(),
	$("#moquu_top").click(function() {
		
		$('html,body').animate({scrollTop: '0px'}, 600);
	})
}),


$(window).scroll(function() {
	b()
});