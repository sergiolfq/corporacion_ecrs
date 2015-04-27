<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/css">
.fb_edge_widget_with_comment span.fb_edge_comment_widget iframe.fb_ltr {
    display: none !important;
}

.fb-like{
    height: 20px;
    overflow: hidden;
}

</script>
                       <?php  
                 //      var_dump('https://'.SERVER_HOST.'/?module=noticias_detalle&t='.$value["fk_tipo"].'&i='.$value["pk_noticia"].'"');
                      $rss = $Shop->getNoticia(array("fk_tipo"=>1,"fk_fija"=>0,"orderby"=>"fk_fija desc,  pk_noticia desc"),$_GET["page"],10);
                      $i=1;
                      $fecha='';
                      
                      
                      $var='contenido';
		      foreach($rss["results"] as $key => $value){
                        if($var!='') {
                             $var= '<div class="timeline-date-label clearfix">'.$Shop->month2letter(date("n",strtotime($value["fecha_noticia"]))).' '.date('Y',strtotime($value["fecha_noticia"])).'</div> ';
                        }
                               
                                                   

    if($i==2)  // se agrega un post a la derecha y una a la izquierda   
                                                   {
                                                    $i=1;
                                                    $clase='pull-right';
                                                   }
                                               else {
                                                   $clase='';
                                                   $i++;
                                                    }   
                                                   $imagen='';  
                                                if(is_file(SERVER_ROOT . "images/noticias/" . $value["pk_noticia"] . ".jpg"))
                                                {
                                                    $imagen=' <img class="img-responsive" style="margin:auto;" src="../images/noticias/'.$value["pk_noticia"].'.jpg" > ';
                                                }
                                              
                                                        $articulo.='   
                                                        '.$var.' 
                                                        <!-- timeline item start -->
							<div class="timeline-item '.$clase.' object-non-visible" data-animation-effect="fadeInUpSmall" data-effect-delay="200">
							<!-- blogpost start -->
							<article class="clearfix blogpost">
							<div class="overlay-container" >
							'.$imagen.' 
							<div>
							<div class="overlay-links">
							<a href="blog-post.html"><i class="fa fa-link"></i></a>
							<a href="images\blog-1.jpg" class="popup-img-single" title="image title"><i class="fa fa-search-plus"></i></a>
							</div>
							</div>
							</div>
							<div class="blogpost-body">
							<div class="post-info">
							<span class="day">'.date('d',strtotime($value["fecha_noticia"])).'</span>
							<span class="month">'.substr($Shop->month2letter(date("n",strtotime($value["fecha_noticia"]))),0,3).'</br> '.date("Y",strtotime($value["fecha_noticia"])).' </span>
							</div>
							<div class="blogpost-content">
							<header>
							<h2 class="title text-right"><a href="?'.'module=noticias_detalle&t='.$value["fk_tipo"].'&i='.$value["pk_noticia"].'">'.$value["titulo" . $_SESSION["LOCALE"]].'</a></h2>
							<div class="submitted"><i class="fa fa-user pr-5"></i> by <a href="#">Corporación ECRS</a></div>
							</header>
							<p>'.$value["sumario" . $_SESSION["LOCALE"]].'</p>
							</div>
							</div>
							<footer class="clearfix">
							<ul class="links pull-left">
                                                        <!--   <li><i class="fa fa-facebook"></i> <a target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.ecrs.com.ve/">Compartir</a> | -->
                                                        <div style="overflow:hidden;"> <div class="fb-like" data-href="www.'.SERVER_HOST.'/?module=noticias_detalle&t='.$value["fk_tipo"].'&i='.$value["pk_noticia"].'" data-colorscheme="light"  data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
                                                        </li> 
							</ul>
							<a class="pull-right link" href="?module=noticias_detalle&t='.$value["fk_tipo"].'&i='.$value["pk_noticia"].'"><span>Leer Más</span></a>
							</footer>
							</article>
							<!-- blogpost end -->
							</div>
							<!-- timeline item end -->
                                                        
                                                        ';   
                                                 //       var_dump(' https://www.'.SERVER_HOST.'/?module=noticias_detalle&t='.$value["fk_tipo"].'&i='.$value["pk_noticia"].'');
                                                         $var='';   
                                                }
                                        ?> 
                        <section class="main-container">

				<div class="container">
					<div class="row">

						<!-- main start -->
						<!-- ================ -->
						<div class="main col-md-12">

							<!-- page-title start -->
							<!-- ================ -->
							<h1 class="page-title">Noticias & Novedades</h1>
							<div class="separator-2"></div>							<!-- page-title end -->

							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									
									<!-- timeline start -->
									<div class="timeline row">

										<div class="timeline-icon hidden-xs"><i class="fa fa-angle-double-up"></i></div>
										

                                                                                <?php  echo $articulo; ?>
                                                                   
									</div>

								</div>
							</div>

						</div>
						<!-- main end -->
        </div>
					</div>
				</div>
			</section>
			<!-- main-container end -->

			<!-- section start -->
			<!-- ================ -->
			<div class="section gray-bg text-muted footer-top clearfix" style="padding-top: 20px;">
                        <div class="container">
                                <div class="row">
                                        <div class="col-md-7">
                                                <div class="owl-carousel clients">


                                                        <div class="client">
                                                            <a href="#"><img src="../estilos/images/client-1.png" alt=""></a>
                                                        </div>
                                                        <div class="client">
                                                                <a href="#"><img src="../estilos/images/client-2.png" alt=""></a>
                                                        </div>

                                                </div>
                                        </div>
                                        <div class="col-md-5">
                                                <blockquote class="inline">
                                                        <p class="margin-clear">Representante oficial de las mejores marcas en máquinas fiscales y equipos POS. <br> <tt title="Source Title">Gerente General Corporación ECRS, C.A. </tt></p>	

                                                </blockquote>
                                        </div>
                                </div>
                        </div>
                </div>




                <section>
               