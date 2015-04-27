<div class="slideshow-boxed" style="margin-bottom: 8px; margin-top: -35px;">
    <div class="container">                                                       <!-- PARTE A MODIFICAR DE DESTACADOS  -->

        <!-- slider revolution start -->
        <!-- ================ -->
           <? php
                        $Textos = new Textos;
                        



                         <?php
                        $rs = $Banners->getBannerbyZonas(15);
						?>
                        <span class="eras rojo20"><?=_("Producto Destacado")?></span></th>
                      </tr>
                      <tr>
                        <th align="left" valign="top" scope="col" style="text-align:justify">
						<center><?= $Banners->showBanners(15);?></center><br />
                             <?php echo var_dump($_SESSION["LOCALE"]); ?>                 
                        <?=nl2br($rs["results"][0]["texto" . $_SESSION["LOCALE"]])?>
                                                
        <div class="slider-banner-container">    <!-- revisar como agregar aqui la parte de los productos destacador -->
            <div class="slider-banner-2">
                <ul>
                    <!-- slide 1 start -->
                    <li data-transition="random" data-slotamount="7" data-masterspeed="500" data-saveperformance="on" data-title="Slide 1">

                        <img src="../estilos/images/slider-1-slide-3.jpg" alt="kenburns" data-bgposition="left center" data-kenburns="on" data-duration="10000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="115" data-bgpositionend="right center">

                        <!-- main image -->
                        <img src="../estilos/images/slider-1-slide-1.jpg" alt="slidebg1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption default_bg large sfr tp-resizeme" data-x="0" data-y="70" data-speed="600" data-start="1200" data-end="9400" data-endspeed="600">Caja Registradora Fiscal CR20
                        </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption dark_gray_bg sfl medium tp-resizeme" data-x="0" data-y="170" data-speed="600" data-start="1600" data-end="9400" data-endspeed="600"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption light_gray_bg sfb medium tp-resizeme" data-x="50" data-y="170" data-speed="600" data-start="1600" data-end="9400" data-endspeed="600">Tamaño compacto
                        </div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption dark_gray_bg sfl medium tp-resizeme" data-x="0" data-y="220" data-speed="600" data-start="1800" data-end="9400" data-endspeed="600"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption light_gray_bg sfb medium tp-resizeme" data-x="50" data-y="220" data-speed="600" data-start="1800" data-end="9400" data-endspeed="600">Emite Notas de Crédito
                        </div>

                        <!-- LAYER NR. 6 -->
                        <div class="tp-caption dark_gray_bg sfl medium tp-resizeme" data-x="0" data-y="270" data-speed="600" data-start="2000" data-end="9400" data-endspeed="600"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption light_gray_bg sfb medium tp-resizeme" data-x="50" data-y="270" data-speed="600" data-start="2000" data-end="9400" data-endspeed="600">Realiza Facturas Personalizadas
                        </div>

                        <!-- LAYER NR. 8 -->
                        <div class="tp-caption dark_gray_bg sfl medium tp-resizeme" data-x="0" data-y="320" data-speed="600" data-start="2200" data-end="9400" data-endspeed="600"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 9 -->
                        <div class="tp-caption light_gray_bg sfb medium tp-resizeme" data-x="50" data-y="320" data-speed="600" data-start="2200" data-end="9400" data-endspeed="600">Almacena hasta 1000 Clientes 
                        </div>

                        <!-- LAYER NR. 10 -->
                        <div class="tp-caption dark_gray_bg sfb medium tp-resizeme" data-x="0" data-y="370" data-speed="600" data-start="2400" data-end="9400" data-endspeed="600">Excelencia en Tecnología Alemana
                        </div>

                        <!-- LAYER NR. 11 -->
                        <div class="tp-caption sfr tp-resizeme" data-x="right" data-y="center" data-speed="600" data-start="2700" data-end="9400" data-endspeed="600"><img src="../estilos/images/slider-1-layer-1.png" alt="">
                        </div>

                    </li>
                    <!-- slide 1 end -->

                    <!-- slide 2 start -->
                    <li data-transition="random" data-slotamount="7" data-masterspeed="500" data-saveperformance="on" data-title="Slide 2">

                        <img src="../estilos/images/slider-1-slide-3.jpg" alt="kenburns" data-bgposition="left center" data-kenburns="on" data-duration="10000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="115" data-bgpositionend="right center">

                        <!-- main image -->
                        <img src="../estilos/images/slider-1-slide-2.jpg" alt="slidebg1" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption white_bg large sfr tp-resizeme" data-x="0" data-y="70" data-speed="600" data-start="1200" data-end="9400" data-endspeed="600"><P>Impresora Fiscal QPrint MF</P>
                        </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption default_bg sfl medium tp-resizeme" data-x="0" data-y="170" data-speed="600" data-start="1600" data-end="9400" data-endspeed="600"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption white_bg sfb medium tp-resizeme" data-x="50" data-y="170" data-speed="600" data-start="1600" data-end="9400" data-endspeed="600">Alta velocidad de imprensión
                        </div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption default_bg sfl medium tp-resizeme" data-x="0" data-y="220" data-speed="600" data-start="1800" data-end="9400" data-endspeed="600"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption white_bg sfb medium tp-resizeme" data-x="50" data-y="220" data-speed="600" data-start="1800" data-end="9400" data-endspeed="600">Diseño ergonómico y silenciosa
                        </div>

                        <!-- LAYER NR. 6 -->
                        <div class="tp-caption default_bg sfl medium tp-resizeme" data-x="0" data-y="270" data-speed="600" data-start="2000" data-end="9400" data-endspeed="600"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption white_bg sfb medium tp-resizeme" data-x="50" data-y="270" data-speed="600" data-start="2000" data-end="9400" data-endspeed="600">Gestión de carga sencilla
                        </div>

                        <!-- LAYER NR. 8 -->
                        <div class="tp-caption default_bg sfl medium tp-resizeme" data-x="0" data-y="320" data-speed="600" data-start="2200" data-end="9400" data-endspeed="600"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 9 -->
                        <div class="tp-caption white_bg sfb medium tp-resizeme" data-x="50" data-y="320" data-speed="600" data-start="2200" data-end="9400" data-endspeed="600">Sistema de corte de papel integrado
                        </div>

                        <!-- LAYER NR. 10 -->
                        <div class="tp-caption default_bg sfb medium tp-resizeme" data-x="0" data-y="370" data-speed="600" data-start="2400" data-end="9400" data-endspeed="600">Reduce costos y ahorro de tiempo.
                        </div>

                        <!-- LAYER NR. 11 -->
                        <div class="tp-caption sfr tp-resizeme" data-x="right" data-y="center" data-speed="600" data-start="2700" data-end="9400" data-endspeed="600"><img src="../estilos/images/images/QPRINTMFweb.png" alt="" style="width: 441.315789473684px; height: 401.10701754386px; margin-right: 160px;">
                        </div>

                    </li>
                    <!-- slide 2 end -->

                    <!-- slide 3 start -->
                    <li data-transition="random" data-slotamount="7" data-masterspeed="500" data-saveperformance="on" data-title="Slide 3">

                        <!-- main image -->
                        <img src="../estilos/images/images/slider-1-slide-3.jpg" alt="kenburns" data-bgposition="left center" data-kenburns="on" data-duration="10000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="115" data-bgpositionend="right center">

                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption white_bg large sfr tp-resizeme" data-x="0" data-y="70" data-speed="600" data-start="1200" data-end="9400" data-endspeed="0">Registradoras Táctiles.
                        </div>

                        <!-- LAYER NR. 2 -->
                        <div class="tp-caption dark_gray_bg sfl medium tp-resizeme" data-x="0" data-y="170" data-speed="600" data-start="1600" data-end="9400" data-endspeed="0"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption white_bg sfb medium tp-resizeme" data-x="50" data-y="170" data-speed="600" data-start="1600" data-end="9400" data-endspeed="0">Ideales para hostelería y tiendas.
                        </div>

                        <!-- LAYER NR. 4 -->
                        <div class="tp-caption dark_gray_bg sfl medium tp-resizeme" data-x="0" data-y="220" data-speed="600" data-start="1800" data-end="9400" data-endspeed="0"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 5 -->
                        <div class="tp-caption white_bg sfb medium tp-resizeme" data-x="50" data-y="220" data-speed="600" data-start="1800" data-end="9400" data-endspeed="0.">Diseños innovadores.
                        </div>

                        <!-- LAYER NR. 6 -->
                        <div class="tp-caption dark_gray_bg sfl medium tp-resizeme" data-x="0" data-y="270" data-speed="600" data-start="2000" data-end="9400" data-endspeed="0"><i class="icon-check"></i>
                        </div>

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption white_bg sfb medium tp-resizeme" data-x="50" data-y="270" data-speed="600" data-start="2000" data-end="9400" data-endspeed="0">De fácil configuración.
                        </div>

                        <!-- LAYER NR. 11 -->
                        <div class="tp-caption sfr" data-x="right" data-hoffset="-660" data-y="center" data-speed="600" data-start="2700" data-endspeed="0" data-autoplay="false" data-autoplayonlyfirsttime="false" data-nextslideatend="true">

                            <div class="embed-responsive embed-responsive-16by9">


                                <iframe class="embed-responsive-item" src='https://www.youtube.com/embed/YqRXtTb54G8?enablejsapi=1&amp;html5=1&amp;hd=1&amp;wmode=opaque&amp;controls=2&amp;showinfo=0;rel=0;' width='640' height='360' style='width:640px;height:360px;'></iframe>



                            </div>
                        </div>

                    </li>
                    <!-- slide 3 end -->

                </ul>
                <div class="tp-bannertimer tp-bottom"></div>
            </div>
        </div>
        <!-- slider revolution end -->

    </div>
</div>







<div class="section clearfix">

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2> Productos</h2>
                <div class="separator-2"></div>
         
                    <?php
error_reporting(-1);
$strsqls= "select distinct  *  from tbl_productos ORDER BY rand() limit 16";
$rss = mysql_query($strsqls);
$num_regs = mysql_num_rows($rss);
$imagen="";
$productos="";
$productos2="";
if ($num_regs > 0) {
    while($row= mysql_fetch_array($rss)) { 
        $imagen.= '<div class="owl-carousel carousel">';
        $imagen.= '<div class="image-box object-non-visible" data-animation-effect="fadeInLeft" data-effect-delay="300"> ";'
        $imagen.= '<div class="overlay-container">';
        $imagen.='<img id="producto1" src="/images/products/tb2'.$row["pk_producto"].'.jpg" > </br>';
        $imagen.= '<div class="overlay">
                   <div class="overlay-links">
                   <a href="shop-product.html"><i class="fa fa-external-link"></i></a>
                   <a href="images\pos.png" class="popup-img"><i class="fa fa-search"></i></a>
                   </div>
                   </div>
                   </div> ';
        $imagen.= '<div class="image-box-body ">
                   <h3 class="title"><a href="portfolio-item.html"> Solución POS</a></h3>
                   <p >Pantalla Táctil y Software de POS Integrado Diseño compacto combinado con un sistema de pantalla táctil de avanzadas funciones de hardware y software, ideal para aquellos negocios que requieren de un Sistema POS ergonomico de alto rendimiento.</p>
                   <a href="portfolio-item.html" class="link"><span>Más información</span></a>
                   </div>
         

';
        
       }
} 
echo $imagen;