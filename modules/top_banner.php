<?php
$picW = 944;
$picH=386;
$rsDest = $Banners->getBannerbyZonas(1);  
$arrpp = array();
foreach($rsDest["results"] as $keyrsDest => $valuersDest){
        $arrpp[]=$valuersDest;
}
?>

<script>var actual =0;</script>  
    <div style="position:relative; ">
        <div style="position:absolute; display:block; z-index:100; left:830px; width:100px; top:350px; height:29px; padding-left:10px;">  
        <?php
        for( $x=0;$x<sizeof($arrpp);$x++){      
                ?>
          <div style="float:left;"><a href="JavaScript:void(false)" onclick="pboton(<?=$x?>)"><img src="/images/iconos/botslide_<? if($x==0){ ?>on<? }else{?>off<? } ?>.png" border="0" id="dd<?=$x?>" /></a></div>
        <?php
                }
                ?>
        </div>
    
        <div id="slide-show">
          <ul id="slide-images">
	  <?= $Banners->showBanners(1);?>

          </ul>
        </div>
      </div>
<script> 
var delay = 3000;
var start_frame = 0;
var ctime = null;
var lis = $('slide-images').getElementsByTagName('li');
var end_frame = lis.length -1;
function init() {
        for( i=0; i < lis.length; i++){
                if(i!=0){
                        lis[i].style.display = 'none';
                }
        }
        start_slideshow(start_frame, end_frame, delay, lis);
}

function start_slideshow(start_frame, end_frame, delay, lis) {
        setTimeout(fadeInOut(start_frame,start_frame,end_frame, delay, lis), delay);
}
function fadeInOut(frame, start_frame, end_frame, delay, lis) {
        var lis = $('slide-images').getElementsByTagName('li');
        
        return (function() {
                Effect.Fade(lis[actual]);
                //alert(actual)
                if (frame == end_frame) { frame = start_frame; } else { frame++; }
                actual = frame
                lisAppear = lis[frame];
                for( i=0; i < lis.length; i++){
                        if(i==frame){
                                //$('dd' + i).style.backgroundColor='#c02131'
                                $('dd' + i).src='/images/iconos/botslide_on.png'
                        }else{
                                //$('dd' + i).style.backgroundColor='#ffffff'
                                $('dd' + i).src='/images/iconos/botslide_off.png'
                        }
                }
                setTimeout("Effect.Appear(lisAppear);", 0);
                ctime = setTimeout(fadeInOut(frame, start_frame, end_frame, delay), delay + 1850);
        })
        
}
function pboton(frame){
        clearTimeout(ctime);
        fun = fadeInOut( (frame-1),start_frame,end_frame, delay, lis);
        fun();
}
<?php if(sizeof($arrpp)>1){ ?>
init()
<?php } ?>
</script>
      <style>

#slide-images{
        position:relative;
        display:block;
        margin:0px;
        padding:0px;
        width:<?=$picW?>px;
        height:<?=$picH?>px;
        left:0px;
        overflow:hidden;
}

#slide-images li{
        position:absolute;
        display:block;
        list-style-type:none;
        margin:0px;
        padding:0px;
        background-color:#FFFFFF;
}

#slide-images li img{
        display:block;
        background-color:#FFFFFF;
}

</style>