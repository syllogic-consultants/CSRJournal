jQuery(document).ready(function($) {
    //set element ID/classes in vars
    var nav         = '#top-menu';
    var search      = '#search-form';
    var siteHead    = '#top-header .top_logo img';
    var header      = '#top-header';
    var main        = '#main';
	var social      = '#short_code_si_icon img';
	var dateDiv     = '.fullwidth-current-date';
    
    //margin fix for masthead function 
    var mastFix = function() {
        $(header).css({
            marginTop: $('#wpadminbar').height() + 'px'
        });
    };
    mastFix();
    //ensure that #wpadminbar doesn't move
    $('#wpadminbar').css( 'position', 'fixed' );


    //function for changing sizes
    $(function(){
        $(header).data('size','big');
    });

    //the main scroll function
    $(window).scroll(function(){
        //set container of the nav element
        var $nav = $(header);
        //when scrolled away from top, marginRight was 125px for dateDiv
        if ($('body').scrollTop() || $('html').scrollTop() > 0) {
            if ($nav.data('size') == 'big') {
                mastFix();
                $( nav ).animate({
                    marginTop:'0px',
                }), {queue:false, duration:600};
                $( search ).animate({
                    marginTop:'9px'
                }), {queue:false, duration:600};
				$( social ).animate({
                    width:'34px'			
                }), {queue:false, duration:600};
                $( nav ).css({
                    display: 'inline',
                     });
                $( search ).css({
                    display: 'inline',
                    }); 
                $nav.data('size','small').stop().animate({
                    height:'48px'
                }, 600);
                $( header ).css('top', '0px'); 
                $( dateDiv ).animate({
                	fontSize:'9px', marginTop:'-3px',marginRight:'-46px'
                }), {queue:false, duration:600};
                $( header ).addClass('header-fixed');//css('background-color', '#DBE5F1');
                if ($(siteHead).length > 0) $( siteHead ).animate({
                      height:'48px',
                       paddingLeft: '1vw',
                      opacity:"show"}, 600);
            }
            $(nav).addClass('top-menu-shrink');
        }
        //when scrolled back, marginRight was 0px for dateDiv
        else {
            if ($nav.data('size') == 'small') {
                mastFix();
                $( nav ).animate({
                    display: 'block',
                    //top: '40px',
                }), {queue:false, duration:600}; 
                $( nav ).animate({
                    marginTop: '25px',
                }), {queue:false, duration:60};
                $( search ).animate({
                    display: 'inline-block',
                 
                }), {queue:false, duration:600}; 
				$( social ).animate({
                    width:'40px'
                }), {queue:false, duration:600};
                $( search ).animate({
                    marginTop: '40px',
                }), {queue:false, duration:60};
                $nav.data('size','big').stop().animate({
                    height:'88px'
                }, 600);
                // $( dateDiv ).animate({
//                 				marginRight:'20px'
//                 	}), {queue:false, duration:600};
                if ($(siteHead).length > 0) $( siteHead ).animate({
                      height:'85px',  paddingLeft: '0vw', marginLeft: '1em' 
                      }, {duration:600, complete: function(){
                      	$( dateDiv ).animate({
                				fontSize:'15px',marginTop:'9px',marginRight:'-76px'
                			}), {queue:false, duration:400};
                      }});
                
                
            	$( header ).removeClass('header-fixed');//css('background-color', 'transparent');
            }
            $(nav).removeClass('top-menu-shrink');
        }
    });
    //Function to fixing margin for #main
    var marginFix = function() {
        $(main).css({
            marginTop: $(header).height() + 'px',
        });
    };
    //do marginFix and again on window resize along with mastFix
    marginFix();
    $( window ).resize(function() {
        marginFix();
        mastFix();
    });


}); //end jQuery noConflict wrapper