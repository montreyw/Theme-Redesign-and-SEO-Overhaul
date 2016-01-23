jQuery( document ).ready( function( $ ) {
"use strict";

    /////////////////////////////////
    // Slider Featured Articles
    /////////////////////////////////
    jQuery("#featured-slider, .big-thing").hide().css({'left' : "0px"}).fadeIn(1000); // fade effect for images, lovely.
    jQuery('#featured-slider').owlCarousel({
        loop: true,
        center: true,
        autoWidth: true,
        autoplay: true,
        autoplayTimeout: 4000,
        items:2 
    }) 

    jQuery('.big-thing').owlCarousel({
        loop:true,
        autoWidth:true,
        autoplay: true,
        autoplayTimeout: 5000,
        items:4
    }) 


    /////////////////////////////////
    // Masonry style for sidebar
    ///////////////////////////////// 
    jQuery( window ).load( function( $ ) {"use strict"; var $container = jQuery('.sidebar'); $container.imagesLoaded( function(){ $container.masonry({ itemSelector : '' }); });});


    /////////////////////////////////
    // Accordion 
    /////////////////////////////////       
    jQuery(".accordionButton").click(function(){jQuery(".accordionButton").removeClass("on");jQuery(".accordionContent").slideUp("normal");if(jQuery(this).next().is(":hidden")==true){jQuery(this).addClass("on");jQuery(this).next().slideDown("normal")}});jQuery(".accordionButton").mouseover(function(){jQuery(this).addClass("over")}).mouseout(function(){jQuery(this).removeClass("over")});jQuery(".accordionContent").hide(); 


    /////////////////////////////////
    // Go to TOP & Prev/Next Article.
    /////////////////////////////////
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


    /////////////////////////////////
    // Sticky Header
    /////////////////////////////////
    var stickyNavTop = jQuery('.main-header').offset().top;    
    var stickyNav = function(){  
    var scrollTop = jQuery(window).scrollTop();  
           
    if (scrollTop > stickyNavTop) {   
        jQuery('.main-header, body').addClass('sticky');  
    } else {  
        jQuery('.main-header, body').removeClass('sticky');   
    }  
    };  
    stickyNav();  
    jQuery(window).scroll(function() { stickyNav(); });



    /////////////////////////////////    
    //The Harlem Shake Easter Egg - Andre
    /////////////////////////////////
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
		function S(){var e=document.createElement("audio");e.setAttribute("class",l);e.src=i;e.loop=false;e.addEventListener("canplay",function(){setTimeout(function(){x(k)},500);setTimeout(function(){N();p();for(var e=0;e<O.length;e++){T(O[e])}},15500)},true);e.addEventListener("ended",function(){N();h()},true);e.innerHTML=" <p>If you are reading this, it is because your browser does not support the audio element. We recommend that you get a new browser.</p> <p>";document.body.appendChild(e);e.play()}
		function x(e){e.className+=" "+s+" "+o}
		function T(e){e.className+=" "+s+" "+u[Math.floor(Math.random()*u.length)]}
		function N(){var e=document.getElementsByClassName(s);var t=new RegExp("\\b"+s+"\\b");for(var n=0;n<e.length;){e[n].className=e[n].className.replace(t,"")}}
		var e=30;var t=30;var n=350;var r=350;var i="//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake.mp3";var s="mw-harlem_shake_me";var o="im_first";var u=["im_drunk","im_baked","im_trippin","im_blown"];var a="mw-strobe_light";var f="//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake-style.css";var l="mw_added_css";var b=g();var w=y();var C=document.getElementsByTagName("*");var k=null;for(var L=0;L<C.length;L++){var A=C[L];if(v(A)){if(E(A)){k=A;break}}}
		if(A===null){console.warn("Could not find a node of the right size. Please try a different page.");return}
		c();S();var O=[];for(var L=0;L<C.length;L++){var A=C[L];if(v(A)){O.push(A)}}})()
	}
	$('#earmilky').on('click', function(){
		harlemShakeFunc();
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});
    




    
}); // jQuery(document).