//autodetect window height
$(".contentContainer").css("min-height",$(window).height());

//Smooth scrolling effect: Karl Swedberg @ learningjquery.com
//Smooth scrolling in a page
$(function() {
	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html,body').animate({
				scrollTop: target.offset().top
			}, 1000);
				return false;
			}
		}
	});
});

//Transparent hover effect: webdesignandsuch.com edited for custom icons and descriptions
//Transparent overlay on image hover generic with magnifying glass icon
$(function() {
	// OPACITY OF BUTTON SET TO 0%
	$(".roll").css("opacity","0");
	
	// ON MOUSE OVER
	$(".roll").hover(function () {
	
		// SET OPACITY TO 70%
		$(this).stop().animate({
			opacity: .7
			}, "slow");
		},

		// ON MOUSE OUT
		function () {

			// SET OPACITY BACK TO 50%
			$(this).stop().animate({
				opacity: 0
			}, "slow");
		});
});
