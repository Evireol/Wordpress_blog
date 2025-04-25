$(document).ready(function () {

	/* Mobile menu */
	function mobileMenu(){
		$('.burger').toggleClass('burger_open');
		$('.burger__icon').toggleClass('burger__icon_close');
		$('.menu').toggleClass('menu_open');
		$('body').toggleClass('scroll_disable');
	}
	$('.burger').on('click', mobileMenu);

	

	/* Sticky sidebar */
	if ($('.sidebar').length > 0) {
		$('.sidebar').theiaStickySidebar({
			additionalMarginTop: 0,
			additionalMarginBottom: 0,
			minWidth: 1024,
		});
	}


	/* Smooth scroll */
	$('.article__toc-link').click(function () {
		$('html, body').animate({
			scrollTop: $($.attr(this, 'href')).offset().top + "px"
		}, 700);
		return false;
	});


});