jQuery(function($){
	$(window).resize(function() {adjustColumns();});
	$(window).load(function() {adjustColumns();});

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

	$('#user_login').attr('placeholder', 'Username');
	$('#user_pass').attr('placeholder', 'Password');

	$('.section-collapse').click(function(){
		if ($(this).closest('.fcc-panel').hasClass('collapsed')){
			var restoreHeight = $(this).attr('id');
			
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

	$('.exam-start').click(function(){
		var panel = $('.fcc-panel.exam-options-panel');
		var currentHeight = panel.height();
		
		panel.attr('id', currentHeight);
		panel.addClass('collapsed').animate({height:'52px'}, function(){		});
		$('.fcc-panel.exam-options-panel .section-collapse i').removeClass('icon-chevron-up');
		$('.fcc-panel.exam-options-panel .section-collapse i').addClass('icon-chevron-down');
	}); 

	if($('.sidebar-menu').length){
		var sidebar_icons = ["icon-home", "icon-dotlist", "icon-bookthree", "icon-stocks", "icon-trophy", "icon-user"];
		var i =0;
		$('.sidebar-menu #menu-dashboard-menu li a').each(function(){
			$(this).append( "<span class='menu-icon'><i class='"+sidebar_icons[i]+"'></i></span>" );
			i++;
		});
	}

	var sidebar_icons = ["icon-home", "icon-groups-friends", "icon-contact-businesscard", "icon-question-sign"];
	var i =0;
	$('.header2 li a').each(function(){
		$(this).prepend( "<span class='menu-icon'><i class='"+sidebar_icons[i]+"'></i></span>" );
		i++;
	});

});