jQuery( document ).ready( function( $ ) {
"use strict";


	///////////////////////////////////////    
	// Genre Bar - Andre
	///////////////////////////////////////    
	function genreBar() {
	    $(document).on("mouseover", ".genrebar ul.mainmenu > li.menu-item", function() {
	        var $this = $(this);
			if ( ( $(".sub-menu", $this).css({
				display: "table",
				opacity: 1
			}) ) ) {
	        $(".sub-menu", $this).stop().animate({
	            opacity: 1
	        }),
	        $("a:first", $this).addClass("active"),
	        $('a.maingenre:not(".active")').stop().animate({
	            opacity: 1
	        })
			}
	    }).on("mouseout", ".genrebar ul.mainmenu > li.menu-item", function() {
	        var $this = $(this);
	        $(".sub-menu", $this).stop().animate({
	            opacity: 0
	        }, 750, function() {
	            $(this).css("display", "none")
	        }),
	        $('a.maingenre:not(".active")').stop().animate({
	            opacity: 1
	        }),
	        $("a:first", $this).removeClass("active")
	    });
	};
	genreBar();



	///////////////////////////////////////    
	// New Input Style - Andre
	///////////////////////////////////////    
	function newInputSty() {
		$('#s').focus(function(){
			$(this).parents('#searchform').addClass('isFocused');
		}).blur(function(){
			$(this).parents('#searchform').removeClass('isFocused');
		});
		$('#s').on('keyup', function(e){
			if ($(this).val() != '') {
				$(this).parents('#searchform').addClass('hasValue');
			} else {
				$(this).parents('#searchform').removeClass('hasValue');
			}
		});
	}
	newInputSty();



	///////////////////////////////////////    
	// Slider Featured Articles - Andre
	///////////////////////////////////////    
	var owl = jQuery('.big-thing');
    owl.owlCarousel({
        loop: true,
        autoPlay: true,
        autoPlayTimeout: 5000,
        stopOnHover: true,
        pagination: true,
		singleItem:true,
        navigation: true,
        navigationText: [
        	"<i class='fa fa-chevron-left'></i>",
        	"<i class='fa fa-chevron-right'></i>"],
        autoWidth:true,
        afterInit: customOwl,
        afterUpdate: customOwl
    });
	$(document.documentElement).keyup(function(event) {
		if (event.keyCode == 37) {
			owl.data('owlCarousel').prev();
		} else if (event.keyCode == 39) {
			owl.data('owlCarousel').next();
		}
	});
	function customOwl() {

		// proper fade-in fade-out effect for muscial loading equalizer animation and Main Stage
		setTimeout( function(){ 
			setTimeout( function(){ 
				owl.addClass('carousel-visible'); 
			}, 37);
			$('#main-stage-loader').addClass('main-stage-loaded'); 
			setTimeout( function(){ 
				$('#main-stage-loader').remove();
			}, 370);
		}, 1370);

		// Get Max height of variable length title boxes and set all boxes to this height 
		// this ensures the titles will fade away under the nav arrows on small devices
		var maxHeight = Math.max.apply(null, $("div.an-widget-title").map(function ()	{
			return $(this).height();
		}).get());
		$("div.an-widget-title").height(maxHeight);
		// Set the proper cooresponding height and top-position of nav arrows
		var mainStageImg = $('.entry-thumb-cont');
		var mainStageImgBtm = mainStageImg.position().top + mainStageImg.outerHeight(true);
		$('.owl-buttons div').css({
			'padding-top': '0',
			'padding-bottom': '0',
			'height': maxHeight - 1,
			'top': mainStageImgBtm
		});
		$('.owl-buttons div i').css({
			'line-height': maxHeight+'px'
		});

		// Create and append thumbnail image pagination
		$('.owl-controls .owl-page').append('<a class="item-link" href="#"/>');
		var paginatorsLink = $('.owl-controls .item-link');
		$.each(this.owl.userItems, function (i) {
			$(paginatorsLink[i])
			.css({
				'background': 'url(' + $(this).find('img').attr('src') + ') center center no-repeat',
				'-webkit-background-size': 'cover',
				'-moz-background-size': 'cover',
				'-o-background-size': 'cover',
				'background-size': 'cover'
			})
			.click(function (e) {
				e.preventDefault();
				owl.trigger('owl.goTo', i);
			});
		});
        // add Custom PREV NEXT controls
        //$('.owl-pagination').prepend('<a href="#prev" class="prev-owl"/>');
        //$('.owl-pagination').append('<a href="#next" class="next-owl"/>');

        // set Custom event for NEXT custom control
/*
		$(".next-owl").click(function () {
			owl.trigger('owl.next');
		});
*/
		
		// set Custom event for PREV custom control
/*
		$(".prev-owl").click(function () {
			owl.trigger('owl.prev');
		});
*/		
	}



	//////////////////////////////////////////////////////////////////
	// Type Anywhere MySpace-like Search - Andre
	//////////////////////////////////////////////////////////////////
	// global keycode constant
	var KEYCODE_ESC = 27;
	var noTriggerKeys = [37, 38, 39, 40, 17, 18, 91, 93, 32, 16, 20, 27, 192, 8]; 

	// extending the jQuery prototype with setCursorPosition
	$.fn.setCursorPosition = function(pos) {
		this.each(function(index, elem) {
			if (elem.setSelectionRange) {
				elem.setSelectionRange(pos, pos);
			} else if (elem.createTextRange) {
				var range = elem.createTextRange();
				range.collapse(true);
				range.moveEnd('character', pos);
				range.moveStart('character', pos);
				range.select();
			}
		});
		return this;
	};
	// intialize
	$(document).ready( function() {
		// cache variables
		var $search = $('#ta-search');
		var $searchtext = $('#ta-searchtext');
		var $escapeKey = $('#escape-key');

		// record keys that are being pressed and held down, eg. "Control" or "Command"
		var pressedKeys = [];
		onkeydown = onkeyup = function(e){
			e = e || event;
			pressedKeys[e.keyCode] = e.type == 'keydown';
		}

		// on any keydown, start parsing keyboard input
		$(document).keydown(function(e) {
  			// if the keycode is not found in the array, the result will be -1, 
			// so if not visible, and noTriggerKeys code is not -1, then exit function
			// and also if any pressedKeys are 'true' in the array, then also exit out
			if (!$search.is(':visible')) {
				if ( ($.inArray(e.keyCode, noTriggerKeys) !== -1) || pressedKeys[17] || pressedKeys[18] || pressedKeys[91]) {
 					//pressedKeys = [];
					return;
				}
			}
			if ( !$("*:not(#ta-searchtext)").is(":focus") ) {
				if($search.is(':visible')) {
					switch (e.which) {
						case KEYCODE_ESC:
							$escapeKey.addClass('active');
							setTimeout( function() {
								$search.fadeOut(200);
								$searchtext.blur().hide();
							}, 137 );
							break;
						default:
							$searchtext.focus();
							break;
					}
					setTimeout( function() {
						$escapeKey.removeClass('active');
					}, 137 );
					var loaderHtml = $('<div id="ta-loader"><i class="fa fa-spinner fa-pulse"></i><span>Searching...</span></div>').hide().fadeIn(375);
					document.getElementById('ta-searchform').onsubmit=function() {
						$search.append( loaderHtml );
					}
				} else {
					$searchtext.show().focus();
					// Grab the key pressed ( String.fromCharCode(e.which) ) 
					// and insert it into $searchtext.
					// then, set the cursor to the end of $searchtext.
					$searchtext.val(String.fromCharCode(e).toLowerCase())
						.setCursorPosition($searchtext.val().length);
					$search.fadeIn(200); 
				}
			}
		});
	});



	//////////////////////////////////////////////////////////////////
	// Style the first word of Interview Quetions and Answers - Andre
	//////////////////////////////////////////////////////////////////
	$('.post-question, .post-answer').each(function(){
		var postQA = $(this);
		var intervText = postQA.text().split(':');
		postQA.html( '<span class="interviewee">'+intervText.shift()+':</span> '+intervText.join('') );
	});



	///////////////////////////////////////    
	// Masonry style for sidebar
	///////////////////////////////////////    
    jQuery( window ).load( function( $ ) {"use strict"; var $container = jQuery('.sidebar'); $container.imagesLoaded( function(){ $container.masonry({ itemSelector : '' }); });});



	///////////////////////////////////////    
	// Accordion 
	///////////////////////////////////////    
    jQuery(".accordionButton").click(function(){jQuery(".accordionButton").removeClass("on");jQuery(".accordionContent").slideUp("normal");if(jQuery(this).next().is(":hidden")==true){jQuery(this).addClass("on");jQuery(this).next().slideDown("normal")}});jQuery(".accordionButton").mouseover(function(){jQuery(this).addClass("over")}).mouseout(function(){jQuery(this).removeClass("over")});jQuery(".accordionContent").hide(); 



	///////////////////////////////////////    
	// Go to TOP & Prev/Next Article.
	///////////////////////////////////////    
    // hide #back-top first
    jQuery("#back-top").hide();
    
    // fade in #back-top
    jQuery(function () {
        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > 100) {
                jQuery('#back-top').fadeIn();
            } else {
                jQuery('#back-top').fadeOut();
            }
        });

        // scroll body to 0px on click
        jQuery('#back-top a').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });





	///////////////////////////////////////    
	// The Harlem Shake Easter Egg - Andre
	///////////////////////////////////////
	function harlemShakeFunc() {
		javascript:(function(){function c(){var e=document.createElement("link");e.setAttribute("type","text/css");e.setAttribute("rel","stylesheet");e.setAttribute("href",f);e.setAttribute("class",l);document.body.appendChild(e)}
		function h(){var e=document.getElementsByClassName(l);for(var t=0;t<e.length;t++){document.body.removeChild(e[t])}}
		function p(){var e=document.createElement("div");e.setAttribute("class",a);document.body.appendChild(e);setTimeout(function(){document.body.removeChild(e)},100)}
		function d(e){return{height:e.offsetHeight,width:e.offsetWidth}}
		function v(i){var s=d(i);return s.height>e&&s.height<n&&s.width>t&&s.width<r}
		function m(e){var t=e;var n=0;while(!!t){n+=t.offsetTop;t=t.offsetParent}
		return n}
		function g(){var e=document.documentElement;if(!!window.innerWidth){return window.innerHeight}else if(e&&!isNaN(e.clientHeight)){return e.clientHeight}
		return 0}
		function y(){if(window.pageYOffset){return window.pageYOffset}
		return Math.max(document.documentElement.scrollTop,document.body.scrollTop)}
		function E(e){var t=m(e);return t>=w&&t<=b+w}
		function S(){var e=document.createElement("audio");e.setAttribute("class",l);e.src=i;e.loop=false;e.addEventListener("canplay",function(){setTimeout(function(){var k = document.getElementById('earmilk-logo');x(k);},500);setTimeout(function(){N();p();for(var e=0;e<O.length;e++){T(O[e])}},14850)},true);e.addEventListener("ended",function(){N();h()},true);e.innerHTML=" <p>If you are reading this, it is because your browser does not support the audio element. We recommend that you get a new browser.</p> <p>";document.body.appendChild(e);e.play()}
		function x(e){e.className+=" "+s+" "+o}
		function T(e){e.className+=" "+s+" "+u[Math.floor(Math.random()*u.length)]}
		function N(){var e=document.getElementsByClassName(s);var t=new RegExp("\\b"+s+"\\b");for(var n=0;n<e.length;){e[n].className=e[n].className.replace(t,"")}}
		var e=30;var t=30;var n=350;var r=350;var i="/wp-content/uploads/earmillk-harlem-shake/Harlem-Shake-DjSliink-Remix-Edited.mp3";var s="mw-harlem_shake_me";var o="im_first";var u=["im_drunk","im_baked","im_trippin","im_blown"];var a="mw-strobe_light";var f="/wp-content/uploads/earmillk-harlem-shake/earmilk-harlem-shake.css";var l="mw_added_css";var b=g();var w=y();var C=document.getElementsByTagName("*");var k=null;for(var L=0;L<C.length;L++){var A=C[L];if(v(A)){if(E(A)){k=A;break}}}
		if(A===null){console.warn("Could not find a node of the right size. Please try a different page.");return}
		c();S();var O=[];for(var L=0;L<C.length;L++){var A=C[L];if(v(A)){O.push(A)}}})()
	}
	$('#earmilky').on('click', function(){
		harlemShakeFunc();
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});
    




    
}); // jQuery(document).