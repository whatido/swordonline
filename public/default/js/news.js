const newLoad = {
	menu: function () {
		let idMenu = $("menuLoad");
		$(document).on("click", '.menuLoad a', function (e) {
			e.preventDefault();
			let _this = $(this);
			$.ajax({
				type: 'POST',
				url: _this.attr('href'),
				data: [],
				dataType: 'HTML',
				async: false,
				beforeSend: function () {
					$("#overlay").fadeIn(0);
				},
				success: function (content) {
					setTimeout(function () {
						$(".main-container").html(content);
						$("#overlay").fadeOut(300);
					}, 500);
				}
			});
		});
	},
	lazyLoad: function () {
		let lazyloadImages = document.querySelectorAll(".info-img");
		$(".main-container").on("scroll", function (event) {
			lazyloadImages.forEach(function (image) {
				if (SYS.isInViewport(image) === true) {
					$(image).find('#loading').hide();
				}
			});
		});
	},
	init: function () {
		this.menu();
		this.lazyLoad();
	}
};


$(document).ready(function () {
	newLoad.init();
	let lazyloadImages = document.querySelectorAll(".info-img");
	lazyloadImages.forEach(function (image) {
		if (SYS.isInViewport(image) === true) {
			$(image).find('#loading').hide();
		}
	});
});
