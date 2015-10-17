jQuery(function($){
	var sidebar_icons = ["icon-home", "icon-dotlist", "icon-bookthree", "icon-stocks", "icon-trophy", "icon-user"];
	var main_menu_icons = ["icon-home", "icon-groups-friends", "icon-contact-businesscard", "icon-question-sign"];
	var logoSlider = $('.logo-slider').bxSlider({});
	var footerHeight;
	$(window).resize(function() {adjustColumns();adjustSlider();fadeAdjust();});
	$(window).load(function() {adjustColumns();adjustSlider();fade();fadeAdjust();});
	$(window).scroll(function() {fade();});
	$('.sidebar-menu .menu-item-has-children > a, #menu-sidebar-menu .sub-menu .menu-item-has-children > a').attr('onclick', 'return false');
	$('.sidebar-menu .menu-item-has-children > a').click(function(){$('.sidebar-menu .menu-item-has-children .sub-menu').slideToggle(200);});
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

	$('#close-mobile-menu').click(function(e){
		e.preventDefault();
		$.sidr('close', 'sidr');
	});

	$('.section-collapse').click(function(){
		var panel = $(this).closest('.fcc-panel');
		//console.log($(this).closest('.section-collapse').text());
		if (panel.hasClass('collapsed')){
            panel.children('.content').slideToggle("slow");
			panel.removeClass('collapsed');
			panel.find('i').removeClass('icon-chevron-down');
			panel.find('i').addClass('icon-chevron-up');
        }
        else{
        	panel.children('.content').slideToggle("slow");
			panel.addClass('collapsed');
			panel.find('i').removeClass('icon-chevron-up');
			panel.find('i').addClass('icon-chevron-down');
        }
	});

	if($('.sidebar-menu').length){
		var i =0;
		$('.sidebar-menu #menu-dashboard-menu > li > a').each(function(){
			$(this).append( "<span class='menu-icon'><i class='"+sidebar_icons[i]+"'></i></span>" );
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

	function adjustColumns() {
        if ($(window).width() <= 991) {
            $('.dashboard-sidebar').removeClass('three columns');
            $('.dashboard-sidebar').addClass('twelve columns');
            $('.dashboard-main').removeClass('nine columns');
            $('.dashboard-main').addClass('twelve columns');
        }
        else {
            $('.dashboard-sidebar').removeClass('twelve columns');
            $('.dashboard-sidebar').addClass('three columns');
            $('.dashboard-main').removeClass('twelve columns');
            $('.dashboard-main').addClass('nine columns');
        }
    }//end adjustColmns()

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
		panel.find('i').removeClass('icon-chevron-up');
		panel.find('i').addClass('icon-chevron-down');
        
    	exam_panel.children('.content').slideDown("slow");
		exam_panel.removeClass('collapsed');
		exam_panel.find('i').removeClass('icon-chevron-down');
		exam_panel.find('i').addClass('icon-chevron-up');
 		
 		setTimeout(function(){ 
            $('html, body').animate({
                scrollTop: $('.fcc-panel.exam-panel').offset().top - 100
            }, 1000);
        }, 1000);
	});
}//global function for plugin access
