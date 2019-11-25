// JavaScript Document
(function ($) {
	"use strict";

$(function () {
	
function getAlgoDescription(){
jQuery.ajax({
	url: esma.ajaxurl,
 data:{ action: 'post_algo', algo : $('select').val()},
 type:'post',
 dataType: 'html',
 success: function( response ) {
$('.description').html(response);
 // console.log(response);  
 }
});
}

getAlgoDescription();
$('select').on('change',function(){
getAlgoDescription();
});
			});
			}(jQuery));