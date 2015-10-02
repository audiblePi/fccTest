jQuery(function($){
	var sidebar_icons = ["icon-home", "icon-dotlist", "icon-bookthree", "icon-stocks", "icon-trophy", "icon-user"];
	var main_menu_icons = ["icon-home", "icon-groups-friends", "icon-contact-businesscard", "icon-question-sign"];
	$(window).resize(function() {adjustColumns();});
	$(window).load(function() {adjustColumns();fade();});
	$(window).scroll(function() {fade();});
    $('.footer').css( 'opacity', 0 );
	$('.mobile-menu-wrapper').sidr({side: 'right'});
    $('#user_login').attr('placeholder', 'Username');
	$('#user_pass').attr('placeholder', 'Password');
	$('.logo-slider').bxSlider({
		minSlides: 5,
		maxSlides: 5,
		slideWidth: 500,
		slideMargin: 10,
		controls: true,
		moveSlides: 1,
		pager: 0
	});
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
		if ($(this).closest('.fcc-panel').hasClass('collapsed')){
			var restoreHeight;
			// if ($(this).closest('.fcc-panel').hasClass('exam-options-panel'))
			// 	restoreHeight = 700;
			// else
				restoreHeight = $(this).attr('id');
			$(this).closest('.fcc-panel').animate({height:restoreHeight+'px'}, function() {   
				$(this).removeClass('collapsed');
			});
			$(this).children('i').removeClass('icon-chevron-down');
			$(this).children('i').addClass('icon-chevron-up');
			
		}else{
			var currentHeight = $(this).closest('.fcc-panel').height();
			$(this).attr('id', currentHeight);
			$(this).closest('.fcc-panel').addClass('collapsed').animate({height:'52px'}, function(){		});
			$(this).children('i').removeClass('icon-chevron-up');
			$(this).children('i').addClass('icon-chevron-down');
		}
	});

	$('.exam-start, .resume-exam').click(function(){
		var panel = $('.fcc-panel.exam-options-panel');
		var currentHeight = panel.height();
		var exam_panel = $('.fcc-panel.exam-panel');
		var examRestoreHeight = exam_panel.children().children('.section-collapse').attr('id');

		//close options panel
		panel.children().children('.section-collapse').attr('id', currentHeight);
		panel.addClass('collapsed').animate({height:'52px'}, function(){		});
		$('.fcc-panel.exam-options-panel .section-collapse i').removeClass('icon-chevron-up');
		$('.fcc-panel.exam-options-panel .section-collapse i').addClass('icon-chevron-down');

		//open exam panel
		exam_panel.animate({height:examRestoreHeight+'px'}, function() {   
			exam_panel.removeClass('collapsed');
		});
		$('.fcc-panel.exam-panel .section-collapse i').removeClass('icon-chevron-down');
		$('.fcc-panel.exam-panel .section-collapse i').addClass('icon-chevron-up');
	}); 

	if($('.sidebar-menu').length){
		var i =0;
		$('.sidebar-menu #menu-dashboard-menu li a').each(function(){
			$(this).append( "<span class='menu-icon'><i class='"+sidebar_icons[i]+"'></i></span>" );
			i++;
		});
	}

	// if($('#menu-sidebar-menu').length){
	// 	var i =0;
	// 	$('#menu-sidebar-menu .sub-menu li a').each(function(){
	// 		$(this).prepend( "<span class='menu-icon'><i class='"+sidebar_icons[i]+"'></i></span>" );
	// 		i++;
	// 	});
	// }

	if($('.header2').length){
		var i =0;
		$('.header2 li a').each(function(){
			$(this).prepend( "<span class='menu-icon'><i class='"+main_menu_icons[i]+"'></i></span>" );
			i++;
		});
	}
	
    function fade() {
        //var animation_height = $(window).innerHeight() * 0.70;
        var animation_height = 400;
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
    }//end fade()

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

});