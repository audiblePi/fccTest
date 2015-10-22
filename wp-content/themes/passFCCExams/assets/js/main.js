jQuery(function($){
	var sidebar_icons = ["icon-home", "icon-dotlist", "icon-bookthree", "icon-stocks", "icon-trophy", "icon-user"];
	var main_menu_icons = ["icon-home", "icon-groups-friends", "icon-contact-businesscard", "icon-question-sign"];
	var logoSlider = $('.logo-slider').bxSlider({});
	var footerHeight;
	$(window).resize(function() {adjustSlider();fadeAdjust();});
	$(window).load(function() {adjustSlider();fade();fadeAdjust();});
	$(window).scroll(function() {fade();});
	$('.sidebar-menu .menu-item-has-children > a, #menu-sidebar-menu .sub-menu .menu-item-has-children > a').attr('onclick', 'return false');
	$('.sidebar-menu .menu-item-has-children > a').click(function(){$('.sidebar-menu .menu-item-has-children .sub-menu').slideToggle(200);});
	$('#menu-sidebar-menu ul .menu-item-has-children > a').click(function(){$(this).siblings('.sub-menu').slideToggle(200);});
    $('.footer').css( 'opacity', 0 );
	$('.mobile-menu-wrapper').sidr({side: 'right'});
    $('#user_login').attr('placeholder', 'Username');
	$('#user_pass').attr('placeholder', 'Password');
	$('.front-page-contact-wrapper .name > input').attr('placeholder', 'Name*');
    $('.front-page-contact-wrapper .email > input').attr('placeholder', 'Email*');
    $('.front-page-contact-wrapper .phone > input').attr('placeholder', 'Phone');
    $('.front-page-contact-wrapper .company > input').attr('placeholder', 'Company');
    $('.front-page-contact-wrapper .message > textarea').attr('placeholder', 'Message*');
	$('.testimonials-slider').bxSlider({
		minSlides: 1,
		maxSlides: 1,
		slideWidth: 400,
		slideMargin: 10,
		controls: false,
		moveSlides: 1,
		pager: 1
	});

	//Custom Paypal In-Context Checkout Integration//
	if( $('.pmpro_form').length ){
		$('.pmpro_form').parent().after("<script>window.paypalCheckoutReady = function () {paypal.checkout.setup('NH4LPZLREH8A6', {environment: 'sandbox',container: 'new-button'});};</script><script src='//www.paypalobjects.com/api/checkout.js' async></script>");
		$('.pmpro_submit').before("<div id='new-button'></div>");
	}
	if($('form.pmpro_form .pmpro_submit #pmpro_submit_span').css('display') == 'block'){
		$('#new-button').hide();
	}

	if ( $('.pmpro_content_message').length ){
		$('.pmpro_content_message').wrap('<div class="panel-wrapper"><div class="fcc-panel"><div class="content"><div class="row"></div></div></div>');
		$('.pmpro_content_message').parent().parent().parent().prepend('<div class="title">Access Restricted</div>');
		$('.pmpro_content_message').parent().parent().parent().after('<div class="shadow"></div>');
		$('.pmpro_content_message').append('<div class="insertLevels"></div>');
	}

	if ($('body').hasClass('pmpro-levels') ){
		if ( $('body').hasClass('logged-in') ){
			$('.pmpro_checkout tr:nth-child(5)').css('display', 'none');
		}
	}

	$('#close-mobile-menu').click(function(e){
		e.preventDefault();
		$.sidr('close', 'sidr');
	});

	$('.fcc-panel .title').click(function(){
		var panel = $(this).closest('.fcc-panel');
		if (panel.hasClass('collapsed')){
            panel.children('.content').slideToggle("slow");
			panel.removeClass('collapsed');
			panel.find('.section-collapse').html('collapse <i class="icon-chevron-up"></i>');
        }
        else{
        	panel.children('.content').slideToggle("slow");
			panel.addClass('collapsed');
			panel.find('.section-collapse').html('expand <i class="icon-chevron-down"></i>');
        }
	});
	
	if($('.sidebar-menu').length){
		var i =0;
		$('.sidebar-menu #menu-dashboard-menu > li > a').each(function(){
			$(this).append( "<span class='menu-icon'><i class='"+sidebar_icons[i]+"'></i></span>" );
			i++;
		});
	}

	if($('#menu-sidebar-menu').length){
		// $('#menu-sidebar-menu > li').each(function(){
		// 	$(this).children('a').prepend( "<span class='menu-icon'><i class='"+sidebar_icons[0]+"'></i></span>" );
		// });
		var i =1;
		$('#menu-sidebar-menu > li > .sub-menu > li').each(function(){
			$(this).children('a').prepend( "<span class='menu-icon'><i class='"+sidebar_icons[i]+"'></i></span>" );
			i++;
		});
	}

	if($('.header2').length){
		var i =0;
		$('.header2 li a').each(function(){
			$(this).prepend( "<span class='menu-icon'><i class='"+main_menu_icons[i]+"'></i></span>" );
			i++;
		});
	}

	var config2 = {
		"id": '656459012754399232',
		//"id": '345170787868762112',
		"domId": 'twitter-wrap',
		"maxTweets": 3,
		"enableLinks": true,
		"showUser": false,
		"showTime": true,
		"lang": 'en',
		"showImages": false,
  		"showRetweet": false,
  		"showInteraction": false,
		//"dateFunction": dateFormatter,
	};
	twitterFetcher.fetch(config2);

	// function dateFormatter(date) {
	// 	console.log(date);
	//  	return $.timeago(date);
	// }

	setTimeout(function(){
		$('#twitter-wrap ul li').each(function(){
			timePosted = $(this).find('.timePosted');
			timePosted.children('a').html(timePosted.children('a').html().substring(7));
			tweet = $(this).find('.tweet');
			tweet.before(timePosted);
		});
	}, 1000);
	
    function fade() {
        if ($(window).width() > 767) {
	    	if( $('body').hasClass('home') ){
		        //var animation_height = $(window).innerHeight() * 0.70;
		        var animation_height = footerHeight;
		        var ratio = Math.round( (1 / animation_height) * 10000 ) / 10000;

		        $('.get-started').each(function() {
		            var objectTop = $(this).offset().top;
		            var windowBottom = $(window).scrollTop() + $(window).innerHeight();
		            objectTop += 150;

		            if ( objectTop < windowBottom ) {
		                if ( objectTop < windowBottom - animation_height ) {
		                    $('.footer').css( {
		                        transition: 'opacity 0.1s linear',
		                        opacity: 1
		                    } );

		                } else {
		                    $('.footer').css( {
		                        transition: 'opacity 0.25s linear',
		                        opacity: (windowBottom - objectTop) * ratio
		                    } );
		                }
		            } else {
		                $('.footer').css( 'opacity', 0 );
		            }
		        });
		    }
		}
    }//end fade()

    function fadeAdjust(){
    	if($('body').hasClass('home')){
    		footerHeight = $('.footer').height();
    		$('.fade-wrap').css('margin-bottom',footerHeight );
    	}
    }//end fadeAdjust()

    function adjustSlider(){
    	if ($('.bx-wrapper').length){
		    if ($(window).width() > 990) {
		       	logoSlider.reloadSlider({
			       	minSlides: 5,
					maxSlides: 5,
					slideWidth: 500,
					// slideMargin: 10,
					controls: true,
					moveSlides: 1,
					pager: 0
				});
			}
			if ($(window).width() < 990) {
		       	logoSlider.reloadSlider({
			       	minSlides: 4,
					maxSlides: 4,
					slideWidth: 500,
					// slideMargin: 10,
					controls: true,
					moveSlides: 1,
					pager: 0
				});
			}
	       if ($(window).width() < 767) {
		    	logoSlider.reloadSlider({
					minSlides: 3,
					maxSlides: 3,
					slideWidth: 500,
					// slideMargin: 10,
					controls: true,
					moveSlides: 1,
					pager: 0
				});
			}
	        if ($(window).width() < 600) {
		    	logoSlider.reloadSlider({
					minSlides: 2,
					maxSlides: 2,
					slideWidth: 500,
					// slideMargin: 10,
					controls: true,
					moveSlides: 1,
					pager: 0
				});
			}
			if ($(window).width() < 400) {
		    	logoSlider.reloadSlider({
					minSlides: 1,
					maxSlides: 1,
					slideWidth: 500,
					// slideMargin: 10,
					controls: true,
					moveSlides: 1,
					pager: 0
				});
			}
		}
    }//adjustSlider
});

function openExam(){
	jQuery(function($){
		var panel = $('.fcc-panel.exam-options-panel');
		var exam_panel = $('.fcc-panel.exam-panel');
        panel.children('.content').slideUp("slow");
		panel.addClass('collapsed');
		panel.find('.section-collapse').html('expand <i class="icon-chevron-down"></i>');

    	exam_panel.children('.content').slideDown("slow");
		exam_panel.removeClass('collapsed');
		exam_panel.find('.section-collapse').html('collapse <i class="icon-chevron-up"></i>');
 		
 		// setTimeout(function(){ 
   //          $('html, body').animate({
   //              scrollTop: $('.fcc-panel.exam-panel').offset().top - 100
   //          }, 1000);
   //      }, 1000);
	});
}//global function for plugin access
