(function(){
	$.fn.curtain = function(){
		setTimeout(function(){$(window).scrollTop(0)},0);

		var stepHeight = screen.availHeight;
		var steps = $(this).children('.step');

        $(this).height(stepHeight*steps.length);
        steps.css({position:'fixed'}).hide();

        steps.eq(0).height(stepHeight).css({top:0}).show();
        steps.eq(1).height(0).css({'top':stepHeight}).show();
        
        $(window).scroll(function(){
    	    var top = $(window).scrollTop();
    	    var current = Math.floor(top/stepHeight);
    	    steps.hide();
    	    steps.eq(current).height(stepHeight).css({top:0}).show();
    		steps.eq(current+1).height(top%stepHeight).css({'top':stepHeight-top%stepHeight}).show();
        });

        $('.curtain-controler .step').click(function(){
            $('html,body').animate({scrollTop:$(this).data('num')*stepHeight},{queue:false,duration:1200});
        });

        $('.scroll').click(function(){
            $('html,body').animate({scrollTop:stepHeight},{queue:false,duration:1200});
        });
	}

	$('.curtain-controler .step').hover(function(){
        // $(this).animate({width:"261px"},{queue:false});
        $(this).animate({width:"261px"});
        $(this).find('.hidden').show();
    },function(){
    	// $(this).animate({width:"50px"},{queue:false});
    	$(this).animate({width:"50px"});
    	$(this).find('.hidden').hide();
    });

	$(document).ready(function(){
        $('.curtain').curtain();   
	}); 
})();