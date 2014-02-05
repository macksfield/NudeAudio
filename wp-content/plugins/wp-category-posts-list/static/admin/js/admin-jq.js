jQuery(document).ready(function($){
    /**
     * ajaxComplete gives the only way to the Global ajax
     * So I would bind and unbind click function whenever any ajax req is performed on the widget page
     * It is indeed a ugly way I worked around, but it works for sure!
     * If you have any better solution, do let me know
     * Swashata <swashata4u@gmail.com>
     */
    $(document).ajaxComplete(function(e, xhr, settings){
        $('.wp-cpl-itg-but').unbind();
        $('.wp-cpl-itg-but').bind('click', function(){
            $(this).next('div.wp-cpl-itg-advop').stop(true, true).toggle('fast');
            return false;
        });
    });
    //alert($('.wp-cpl-itg-but').length);
    if($('.wp-cpl-itg-but').length) {
        $('.wp-cpl-itg-but').bind('click', function(){
            $(this).next('div.wp-cpl-itg-advop').stop(true, true).toggle('fast');
            return false;
        });
    }
});