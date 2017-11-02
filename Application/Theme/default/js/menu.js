(function($){
    $(".user-account-nav").click(function() {
        
    }).trigger('click');
    $('.left_tree').find('li ul').stop(true).slideUp('fast');
    if($(".left_tree").find('.active')){
        var _this=$(".left_tree").find('.active');
        _this.parent('ul').slideDown('slow');
    }
    $(".user-account-nav-item").click(function() {
        var li = $(this).parent(),
        ul = li.find("ul"),
        height = ul.height();
        if(ul.is(':visible')){
            ul.stop(true).slideUp();
        }else{
            $.each($('.user-account-nav li'), function(name, value) {
               if($(this).find('ul').is(":visible")){
                    $(this).find('ul').stop(true).slideUp();
               }
            });
            ul.slideDown('slow');
        }
    });
})(jQuery);