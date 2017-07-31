jQuery(document).ready(function($) {
    //Masonry blocks
	$blocks = $(".posts");

	$blocks.imagesLoaded(function(){
		$blocks.masonry({
			itemSelector: '.post-container'
		});

		// Fade blocks in after images are ready (prevents jumping and re-rendering)
		$(".post-container").fadeIn();
	});

	$(document).ready( function() { setTimeout( function() { $blocks.masonry(); }, 500); });

	$(window).resize(function () {
		$blocks.masonry();
	});

	// Toggle navigation
	$(".nav-toggle").on("click", function(){	
		$(this).toggleClass("active");
		$(".mobile-navigation").slideToggle();
	});

	// Hide mobile-menu > 1000
	$(window).resize(function() {
		if ($(window).width() > 1000) {
			$(".nav-toggle").removeClass("active");
			$(".mobile-navigation").hide();
		}
	});

	// Load Flexslider
    $(".flexslider").flexslider({
        animation: "slide",
        controlNav: false,
        smoothHeight: true,
        start: $blocks.masonry(),
    });

	// resize videos after container
	var vidSelector = ".post iframe, .post object, .post video, .widget-content iframe, .widget-content object, .widget-content iframe";	
	var resizeVideo = function(sSel) {
		$( sSel ).each(function() {
			var $video = $(this),
				$container = $video.parent(),
				iTargetWidth = $container.width();

			if ( !$video.attr("data-origwidth") ) {
				$video.attr("data-origwidth", $video.attr("width"));
				$video.attr("data-origheight", $video.attr("height"));
			}

			var ratio = iTargetWidth / $video.attr("data-origwidth");

			$video.css("width", iTargetWidth + "px");
			$video.css("height", ( $video.attr("data-origheight") * ratio ) + "px");
		});
	};

	resizeVideo(vidSelector);

	$(window).resize(function() {
		resizeVideo(vidSelector);
	});

	// When Jetpack Infinite scroll posts have loaded
	$( document.body ).on( 'post-load', function () {
		var $container = $('.posts');
		$container.masonry( 'reloadItems' );

		$blocks.imagesLoaded(function(){
			$blocks.masonry({
				itemSelector: '.post-container'
			});

			// Fade blocks in after images are ready (prevents jumping and re-rendering)
			$(".post-container").fadeIn();
		});

		// Rerun video resizing
		resizeVideo(vidSelector);

		$container.masonry( 'reloadItems' );

		// Load Flexslider
	    $(".flexslider").flexslider({
	        animation: "slide",
	        controlNav: false,
	        prevText: "Previous",
	        nextText: "Next",
	        smoothHeight: true   
	    });

		$(document).ready( function() { setTimeout( function() { $blocks.masonry(); }, 500); });
	});
});

jQuery.fn.rdo = function() {
	return jQuery(this).each( function(k,v) {
        var $this = jQuery(v);
        if( $this.is(':radio') && !$this.data('radio-replaced') ) {
            // add some data to this checkbox so we can avoid re-replacing it.
            $this.data('radio-replaced', true);

            // create HTML for the new checkbox.
            var $l = jQuery('<label for="'+$this.attr('id')+'" class="radio"></label>');
            var $p = jQuery('<span class="pip"></span>');

            // insert the HTML in before the checkbox.
            $l.append( $p ).insertBefore( $this );
            $this.addClass('replaced');

            // check if the radio is checked, apply styling. trigger focus.
            $this.on('change', function() {
                jQuery('label.radio').each( function(k,v) {
                    var $v = jQuery(v);
                    if( jQuery('#'+ $v.attr('for') ).is(':checked') ) {
                        $v.addClass('on'); 
                    } else {
                        $v.removeClass('on'); 
                    }
                });

                $this.trigger('focus');
            });

            $this.on('focus', function() { $l.addClass('focus') });
            $this.on('blur', function() { $l.removeClass('focus') });

            // check if the radio is checked on init.
            jQuery('label.radio').each( function(k,v) {
                var $v = jQuery(v);
                if( jQuery('#'+ $v.attr('for') ).is(':checked') ) {
                    $v.addClass('on'); 
                } else {
                    $v.removeClass('on'); 
                }
            });
        }
    });
}; 

jQuery(':radio').rdo();