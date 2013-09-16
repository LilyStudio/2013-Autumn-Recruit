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

        if($('#name').val().length == 0){
            alert('请填写真实有效的姓名');
            return false;
        }
        if($('#number').val().length == 0){
            alert('请填写真实有效的学号');
            return false;
        }
        if($('#dept').val().length == 0){
            alert('请填写真实有效的院系');
            return false;
        }
        if($('#phone').val().length == 0){
            alert('请填写真实有效的电话号码');
            return false;
        }

        var data = new FormData($(this)[0]);
        var url = $(this).attr('action');
        $.ajax({
            url: url,
            data: data,
            type: $(this).attr('method'),
            success: function(response){
                // console.log(response);
                if(JSON.parse(response).success){
                    $('#submit').fadeTo("slow",0).hide();
                    $('input').add($('textarea')).add($('select')).each(function(){
                        $(this)[0].disabled = true;
                    });
                    $('.ok').show().transition({'x':0,'y':0});
                }else{
                    alert('服务器好像有点问题哦。如果你认为这是一个bug，请联系J22Melody@Gmail.com，谢谢你的反馈。');
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

	$(document).ready(function(){
        //判断是否为手机浏览器
        var u = navigator.userAgent; 
        if(!(u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/) || (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1))) { 
            $('.curtain').curtain();  
        }
	}); 
})();