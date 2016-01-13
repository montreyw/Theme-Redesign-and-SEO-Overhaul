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
    
}); // jQuery(document).