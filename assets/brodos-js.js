jQuery(document).ready(function () {
	if (jQuery(".BrodosCartCount").length) {
		var cartCount = setInterval(cartCountRefresh, 10000);
		function cartCountRefresh() {
			var siteLink = jQuery(".BrodosCartCount").first().data("site");
			var countAPILink = siteLink + '/api/v1/get_count';
			jQuery.ajax({
				url: countAPILink,
				dataType: 'json',
				type: 'GET',
				crossDomain: true,
				xhrFields: {
					withCredentials: true
				},
				success: function (data) {
					cartCount = data['cart_count'];
					jQuery(".BrodosCartCount").attr("data-count", cartCount);
					jQuery(".BrodosCartCount:not(.showCount)").addClass('showCount');
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					console.error("There was a problem with get_count API.");
					clearInterval(cartCount);
				}
			});
		}
		cartCountRefresh();
	}

	/*
	The code below is for the hero banner slider.
	*/
	if (jQuery(".brodos-hero-banner-top-wrap-background").length > 0) {
		var backgroundImageStyle = jQuery(".brodos-hero-banner-top-wrap-background").css("background-image");
		var backgroundUrls = backgroundImageStyle.split(",");
		if (backgroundUrls.length > 1) {
			jQuery.fx.interval = -5000;
			(function cycleBgImage(elem, bgimg) {
				elem.css("backgroundImage", bgimg)
					// fade in background image
					.fadeTo(300, 1, "linear", function () {
						jQuery(this).delay(5000, "fx").fadeTo(300, 0, "linear", function () {
							var img = jQuery(this).css("backgroundImage").split(","),
								bgimg = img.concat(img[0]).splice(1).join(",");
							cycleBgImage(elem, bgimg);
						});
					});
			})(jQuery(".brodos-hero-banner-top-wrap-background"));
		}
	}
});