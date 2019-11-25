// JavaScript Document
(function ($) {
	"use strict";

$(function () {

function disabletimeinput(){
	$( ".esa" ).each(function() {		
	if(!$(this).is(':checked')){
		var cid=$(this).attr('id');
		$('#'+cid+'_from_1 , #'+cid+'_from_2 , #'+cid+'_from_3 , #'+cid+'_from_4, #'+cid+'_to_1 , #'+cid+'_to_2, #'+cid+'_to_3 , #'+cid+'_to_4').attr('disabled','disabled');

	}
	});
}
disabletimeinput();
$('.esa').on('change',function(){	
	var cid=$(this).attr('id');
	if($(this).is(':checked')){	
		$('#'+cid+'_from_1 , #'+cid+'_from_2 , #'+cid+'_from_3 , #'+cid+'_from_4, #'+cid+'_to_1 , #'+cid+'_to_2, #'+cid+'_to_3 , #'+cid+'_to_4').removeAttr('disabled');
		$('#'+cid+'_from_1').val("12:00am");	
		$('#'+cid+'_to_1').val("11:59pm");		
	}else{
	$('#'+cid+'_from_1 , #'+cid+'_from_2 , #'+cid+'_from_3 , #'+cid+'_from_4, #'+cid+'_to_1 , #'+cid+'_to_2, #'+cid+'_to_3 , #'+cid+'_to_4').val('');
	$('#'+cid+'_from_1 , #'+cid+'_from_2 , #'+cid+'_from_3 , #'+cid+'_from_4, #'+cid+'_to_1 , #'+cid+'_to_2, #'+cid+'_to_3 , #'+cid+'_to_4').attr('disabled','disabled');
	}
});

$('.daterange .time').timepicker({
        'showDuration': true,
        'timeFormat': 'g:ia',
		'step': 15,
    });
$('.daterange').datepair();

			});
			}(jQuery));