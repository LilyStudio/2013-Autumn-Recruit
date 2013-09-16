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
            if(current === steps.length-1){
                $('.scroll').hide();
            }else{
                $('.scroll').show();
            }
        });

        $('.curtain-controler .step').click(function(){
            $('html,body').animate({scrollTop:$(this).data('num')*stepHeight},{queue:false,duration:1200});
        });

        $('.scroll').click(function(){
            var top = $(window).scrollTop();
            var current = Math.floor(top/stepHeight);
            $('html,body').animate({scrollTop:stepHeight*(current+1)},{queue:false,duration:1200});
        });
	}

	$('.curtain-controler .step').hover(function(){
        // $(this).animate({width:"220px"},{queue:false});
        $(this).animate({width:"220px"});
        $(this).find('.hidden').show();
    },function(){
    	// $(this).animate({width:"50px"},{queue:false});
    	$(this).animate({width:"50px"});
    	$(this).find('.hidden').hide();
    });

    $('.register').submit(function(){
        var registerData = new FormData($(this));
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            data: registerData,
            processData: false,
            type: 'POST',
            success: function(data){
                $(this).find('#submit').hide();
                $('.ok').show().transition({'x':0,'y':0});
            }
        })
        return false;
    });

	$(document).ready(function(){
        $('.curtain').curtain();   
	}); 
})();