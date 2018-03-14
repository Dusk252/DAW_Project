$(document).ready(function() {
	$('.faq').removeClass('open');
	$('.faq').addClass('faq_hover');
 
    $('.question').click(function() {
 
        if ($(this).parent().is('.open')){
            $(this).closest('.faq').removeClass('open');
 
            }else{
                $(this).closest('.faq').addClass('open');
            }
 
    });
 
});