$(document).ready(function(){


          		$('.klick').click(function(){
				$("#video_in").each(function() { 
					$("#video_in").remove(); 
				});
					$('#video').css("display","none");				
				});
				
				$('#play').click(function(){	
				window.vid_in='<iframe width="640" height="360" src="//www.youtube.com/embed/YqRXtTb54G8?rel=0" frameborder="0" allowfullscreen></iframe>';
				
				var xxx='<div id="video_in">'+window.vid_in+'</div>';
					$('#video').append(xxx);
					$('#video').css("display","block");
				});

$("#krug_slider_solo1").css("background","#d5393c");
$("#krug_slider_solo1 h3").css("color","#ffffff");
$("#krug_slider_solo1 p").css("color","#ffffff");

if (innerWidth>960){
var slid_height=505*innerWidth/1500;
slid_height=slid_height+'px';}
else {slid_height='327px'}
$("#nino_slider").css("height",slid_height);

$("#nino_slider > div:gt(0)").hide();

nino_slider_new();


$('.nivo-nextNav').click(function() {
  $('#nino_slider > div:first')
    .fadeOut(500)
    .next()
    .fadeIn(500)
    .end()
    .appendTo('#nino_slider');
	slide_prenesi_id="#krug_"+$('#nino_slider > div:first').attr("id");
	uradi_slider_promenu(slide_prenesi_id);	
});				 				 

$('.nivo-prevNav').click(function() {
  $('#nino_slider > div:first')
    .fadeOut(500);
  $('#nino_slider > div:last')
    .fadeIn(500)
    .prependTo('#nino_slider');	
	slide_prenesi_id="#krug_"+$('#nino_slider > div:first').attr("id");
	uradi_slider_promenu(slide_prenesi_id);	
});		


$('.circles').click(function() {
$('#nino_slider > div:first')
  .hide();
while ($('#nino_slider > div:first').attr('id')!==$(this).attr('rel')) {
  $('#nino_slider > div:first')
  .appendTo('#nino_slider');
}
$('#nino_slider > div:first')
  .show();
slide_prenesi_id="#"+$(this).attr("id");
	uradi_slider_promenu(slide_prenesi_id);	
});

/* catalog */
$('.home #tab1 a').css("background","url(./images/tab_white.png) no-repeat");
$('.home #tab1 a h3').css("color","#333333");

$('#tab1').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										bezvezna=$(this).attr("id");
										tabovi(bezvezna);
							$('#tab1_p').animate({opacity: 1}, 400);
						});
$('#tab2').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										bezvezna=$(this).attr("id");
										tabovi(bezvezna);
							$('#tab2_p').animate({opacity: 1}, 400);
						});
$('#tab3').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										bezvezna=$(this).attr("id");
										tabovi(bezvezna);
							$('#tab3_p').animate({opacity: 1}, 400);
						});
$('#tab4').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										bezvezna=$(this).attr("id");
										tabovi(bezvezna);
							$('#tab4_p').animate({opacity: 1}, 400);
						});

$('#tab51').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										$('.panes').css('min-height','550px');
										bezvezna=$(this).attr("id");
										tabovi5(bezvezna);
							$('#tab51_p').animate({opacity: 1}, 400);
						});	
$('#tab52').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										$('.panes').css('min-height','900px');
										bezvezna=$(this).attr("id");
										tabovi5(bezvezna);
							$('#tab52_p').animate({opacity: 1}, 400);
						});		
$('#tab53').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										$('.panes').css('min-height','550px');
										bezvezna=$(this).attr("id");
										tabovi5(bezvezna);
							$('#tab53_p').animate({opacity: 1}, 400);
						});	
$('#tab54').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										$('.panes').css('min-height','550px');
										bezvezna=$(this).attr("id");
										tabovi5(bezvezna);
							$('#tab54_p').animate({opacity: 1}, 400);
						});	
$('#tab55').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										$('.panes').css('min-height','650px');
										$('.panes_div').css("display","none");
										$('#tab55_p').css("display","block");
										$('.yellow_tab .triangl').css("display","block");
										$( ".tabs_become li" ).removeClass( "red_tab" ).addClass( "gray_tab" );
										$('#visit_img').css('display','block');
							$('#tab55_p').animate({opacity: 1}, 400);
						});	

						$('#tab61_p').css("display","block");
						
$('.tabs_prod li').click(function(){
							$('.glavni_tab').animate({opacity: 0}, 300);
										bezvezna=$(this).attr("id");
										tarabx_p='#' + bezvezna + '_p';
										tabovi6(bezvezna);
							$(tarabx_p).animate({opacity: 1}, 400);
										
						});
$('#hardware_sec').click(function(){
							$('.glavni_tab').animate({opacity: 0}, 300);
										bezvezna='tab61';
										tarabx_p='#' + bezvezna + '_p';
										tabovi6(bezvezna);
							$(tarabx_p).animate({opacity: 1}, 400);
										
						});

						
						
$('.tabsli_pos').click(function(){
							$('.panes_div').animate({opacity: 0}, 300);
										bezvezna=$(this).attr("id");
										tarabx_p='#' + bezvezna + '_p';
										tabovi5(bezvezna);
							$(tarabx_p).animate({opacity: 1}, 400);
						});	
						
$('#cont_tab1_p').css('display', 'block');
$('.cont_tab').click(function(){
							$('.contact_tab').animate({opacity: 0}, 300);
							$('.contact_tab').css('display', 'none');
										bezvezna=$(this).attr("id");
										tarabx_p='#' + bezvezna + '_p';
										bezvezna_t='#' + bezvezna;
										$( ".cont_tab" ).removeClass( "active" );
										$( bezvezna_t ).addClass( "active" );
							$(tarabx_p).css('display', 'block');
							$(tarabx_p).animate({opacity: 1}, 400);
						});	
						
$('.product .nivo-nextNav').click(function(){
							$('.glavni_tab').animate({opacity: 0}, 300);
										tekuci_red=$('.product .red_tab').attr("id");
										switch (tekuci_red)
  {
  case "tab61":    tekuci_red1="tab62";
    break;
  case "tab62":    tekuci_red1="tab63";
    break;
  case "tab63":    tekuci_red1="tab64";
    break;
  case "tab64":    tekuci_red1="tab65";
    break;
  case "tab65":    tekuci_red1="tab66";
    break;
  case "tab66":    tekuci_red1="tab61";
    break;
 }
										tekuci_red2='#' + tekuci_red1 + '_p';
										tabovi6(tekuci_red1);
							$(tekuci_red2).animate({opacity: 1}, 400);
						});	
$('.product .nivo-prevNav').click(function(){
							$('.glavni_tab').animate({opacity: 0}, 300);
										tekuci_red=$('.product .red_tab').attr("id");
										switch (tekuci_red)
  {
  case "tab61":    tekuci_red1="tab66";
    break;
  case "tab62":    tekuci_red1="tab61";
    break;
  case "tab63":    tekuci_red1="tab62";
    break;
  case "tab64":    tekuci_red1="tab63";
    break;
  case "tab65":    tekuci_red1="tab64";
    break;
  case "tab66":    tekuci_red1="tab65";
    break;
 }
										tekuci_red2='#' + tekuci_red1 + '_p';
										tabovi6(tekuci_red1);
							$(tekuci_red2).animate({opacity: 1}, 400);
						});						

						$( "#sign_prod" ).removeClass( "sign_prod_close" );
var up=1;
						
$('#sign_div').click(function(){	
    $( ".signup_cl_sel" ).toggle(800);
	if (up==1){
		$('.triangl_bot').css('border-top','none');
		$('.triangl_bot').css('border-bottom','9px solid #665757');
		up=0;
	}
	else {
		$('.triangl_bot').css('border-bottom','');
		$('.triangl_bot').css('border-top','');
		up=1;
	}
});	

			
$( "#tab51" ).removeClass( "gray_tab" ).addClass( "red_tab" );
$( "#tab51_p" ).css('display','block');
$( "#pos_tab51_p" ).css('display','block');
			
var big_img_h=247*(innerWidth-20)/1500;
big_img_h=big_img_h + 'px';
$('.big_img').css('height',big_img_h);	

$( "#tab41 .img_tab_div" ).addClass( "red_tab" );
$( "#tab41_p" ).css('display','block');
$( "#tab411_p" ).css('display','block');
$( ".absol" ).css('display','block');
$( "#tab41 .absol" ).css('display','none');

$('.img_tab').click(function(){
							$('.img_nivo2').animate({opacity: 0}, 300);
										bezvezna=$(this).attr("id");
										tarabx_p='#' + bezvezna + '_p';
										tarabx_p1='#' + bezvezna + '1_p';
										tarabx_p2='#' + bezvezna + '1';
										tarab_absol='#' + bezvezna + ' .absol';
										$('.absol').css('display','block');
										$(tarab_absol).css('display','none');
										
										$( ".img_tab2" ).removeClass( "red_tab" );
										$(tarabx_p2).addClass( "red_tab" );
										tabovi7(bezvezna);
							$('.panes_div41').animate({opacity: 0}, 300);
							$('.panes_div41').css('display','none');
							$(tarabx_p1).css('display','block');
							$(tarabx_p).animate({opacity: 1}, 400);
							$(tarabx_p1).animate({opacity: 1}, 400);
						});
$('.img_tab2').click(function(){
							$('.panes_div41').animate({opacity: 0}, 300);
										bezvezna=$(this).attr("id");
										tarabx_p='#' + bezvezna + '_p';
										tabovi8(bezvezna);
							$(tarabx_p).animate({opacity: 1}, 400);
							
						});
		
});

$(window).resize(function() {
if (innerWidth>960){
var slid_height=505*innerWidth/1500;
slid_height=slid_height+'px';}
else {slid_height='327px'}
$("#nino_slider").css("height",slid_height);
//$(".slider_text").css("margin-top",-slid_height);
});

function tabovi(xxx){
tarabx_p='#' + xxx + '_p';
tarabx='#' + xxx + ' a';
tarabx_span=tarabx + ' h3';
										$('.panes_div').css("display","none");
										$(tarabx_p).css("display","block");
										$('ul.tabs a').css("background","");
										$('ul.tabs a').css("z-index","");
										$(tarabx).css("z-index","5");
										$(tarabx).css("background","url(./images/tab_white.png) no-repeat");
										$('ul.tabs a h3').css("color","");
										$(tarabx_span).css("color","#333333");
										
										
}
function tabovi5(xxx){
xxxtab='#' + xxx;
tarabx_p='#' + xxx + '_p';
tarabx='#' + xxx + ' a';
tarabx_span=tarabx + ' span';
										$('.glavni_tab').css("display","none");
										$(tarabx_p).css("display","block");
										$( ".tabs_become li" ).removeClass( "red_tab" ).addClass( "gray_tab" );
										$( "#tab55" ).removeClass( "gray_tab" ).addClass( "yellow_tab" );
										$( xxxtab ).removeClass( "gray_tab" ).addClass( "red_tab" );
										$('#visit_img').css('display','none');
										$('.yellow_tab .triangl').css("display","none");
										
}
function tabovi6(xxx){
xxxtab='#' + xxx;
tarabx_p='#' + xxx + '_p';
tarabx='#' + xxx + ' a';
tarabx_span=tarabx + ' span';
										$('.glavni_tab').css("display","none");
										$(tarabx_p).css("display","block");
										$( ".tabs_prod li" ).removeClass( "red_tab" ).addClass( "gray_tab" );
										$( xxxtab ).removeClass( "gray_tab" ).addClass( "red_tab" );
										
}
function tabovi7(xxx){
xxxtab='#' + xxx + ' .img_tab_div';
tarabx_p='#' + xxx + '_p';
tarabx='#' + xxx + ' a';
tarabx_span=tarabx + ' span';

										$('.img_nivo2').css("display","none");
										$(tarabx_p).css("display","block");
										$( ".img_tab_div" ).removeClass( "red_tab" );
										$( xxxtab ).addClass( "red_tab" );
										
}
function tabovi8(xxx){
xxxtab='#' + xxx;
tarabx_p='#' + xxx + '_p';
tarabx='#' + xxx + ' a';
tarabx_span=tarabx + ' span';

										$('.panes_div41').css("display","none");
										$(tarabx_p).css("display","block");
										$( ".img_tab2" ).removeClass( "red_tab" );
										$( xxxtab ).addClass( "red_tab" );
										
}

function nino_slider_new() {
	if ($('#nino_slider > div:first').attr("id")=='slider_solo1') {
		var vreme=20000;
	}
	else {
		var vreme=10000;	
	}

	setTimeout( function() {	
		$('#nino_slider > div:first')
			.fadeOut(1500)
			.next()
			.fadeIn(1500)
			.end()
			.appendTo('#nino_slider');
			slide_prenesi_id="#krug_"+$('#nino_slider > div:first').attr("id");
			uradi_slider_promenu(slide_prenesi_id);
			nino_slider_new();
	},vreme);			
}


function uradi_slider_promenu(slide_id) {
kruzko=slide_id;
kruzko_h6=kruzko+' h3';
kruzko_p=kruzko+' p';
$(".circles").css("background","");
$(".circles h3").css("color","");
$(".circles p").css("color","");
$(kruzko).css("background","#d5393c");
$(kruzko_h6).css("color","#ffffff");
$(kruzko_p).css("color","#ffffff");
}

