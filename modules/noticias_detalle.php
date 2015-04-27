<?php
$rs = $Shop->getNoticia(array("pk_noticia"=>$_GET["i"]));
$value = $rs["results"][0];
?>


  <!--  -->
            	<section class="main-container">

				<div class="container">
					<div class="row">

						<!-- main start -->
						<!-- ================ -->
						<div class="main col-md-8">

							<!-- page-title start -->
							<!-- ================ -->
							<h3 class="page-title"> <?php echo $value["titulo" . $_SESSION["LOCALE"]]; ?> </h3>
							<!-- page-title end -->

							<!-- blogpost start -->
                                                        <article class="clearfix blogpost full">
                                                            <div class="blogpost-body">
                                                                <div class="side">
                                                                    <div class="post-info">
                                                                        <span class="day"><?php echo date('d', strtotime($value["fecha_noticia"])); ?></span>
                                                                        <span class="month"><?php echo substr($Shop->month2letter(date("n", strtotime($value["fecha_noticia"]))), 0, 3) . '</br> ' . date("Y", strtotime($value["fecha_noticia"])); ?></span>
                                                                    </div>
                                                <!--                    <div id="affix"><span class="share">Visitanos en</span><div id="share"></div> <i class="fa facebook"> </i></div> -->

                                                                </div>
                                                                
                                                                <div class="blogpost-content">
                                                                <header>
                                                                    <div class="submitted"><i class="fa fa-user pr-5"></i> by <a href="#">Corporación ECRS</a></div>
                                                                </header>
                                                                     <?php if (is_file(SERVER_ROOT . "images/noticias/" . $value["pk_noticia"] . ".jpg")) { ?>
                                                                    		<div class="owl-carousel content-slider">
											<div class="overlay-container">
                                                                                        <img src="images/noticias/<?= $value["pk_noticia"] ?>.jpg" style="margin: auto;" class="img-responsive" />
									        	<a href="images/noticias/<?= $value["pk_noticia"] ?>.jpg"  class="popup-img overlay" title="image title"><i class="fa fa-search-plus"></i></a>
											</div>
							                 	</div>
                                                                    
                                                                       <?php } ?>
                                                                    
                                                                    <p>  <?php echo $value["texto" . $_SESSION["LOCALE"]]; ?> </p>
                                                                      <?php
                                                                if (is_file(SERVER_ROOT . "images/noticias/" . $value["pk_noticia"] . ".pdf")) {
                                                                    ?>
                                                                    <a href="?dw=<?= $Shop->encode($value["pk_noticia"]) ?>" target="_blank" style="text-decoration:none; font-size:14px;" class="aoverunderline"> <i class="fa fa-file-pdf-o"> </i> <?= _("Descargar Archivo PDF") ?></a>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </div>
                                                              
                                                            </div>
                                                            <!--			<footer class="clearfix">
                                                                                            <ul class="links pull-left">
                                                                                                    <li><i class="fa fa-comment-o pr-5"></i> <a href="#">22 comments</a> |</li> 
                                                                                                    <li><i class="fa fa-tags pr-5"></i> <a href="#">tag 1</a>, <a href="#">tag 2</a>, <a href="#">long tag 3</a> </li>
                                                                                            </ul>
                                                                                    </footer> -->
                                                        </article>
                                                        <!-- blogpost end -->

                                                        <!-- comments start -->
                                                        <div class="comments">


                                                            <!-- comment start -->

                                                            <!-- comment end -->

                                                            <!-- comment start -->

                                                            <!-- comment end -->

                                                        </div>
                                                        <!-- comments end -->

                                                        <!-- comments form start -->

                                                        <!-- comments form end -->

                                                </div>
                                                <!-- main end -->

                                                <!-- sidebar start -->
                                                <aside class="col-md-3 col-md-offset-1">
                                                    <div class="sidebar">
                                                        <div class="block clearfix">
                                                            <h3 class="title">Menú</h3>
                                                            <div class="separator"></div>
                                                            <nav>
                                                                <ul class="nav nav-pills nav-stacked">
                                                                    <li><a href="/">Home</a></li>
                                                                    <li class="active"><a href="?module=noticias_home#">Blog</a></li>

                                                                    <li><a href="page-contact.html">Contact</a></li>
                                                                </ul>
                                                            </nav>
                                                        </div> 

                                                        <div class="block clearfix" lang="es">
                                                            <a class="twitter-timeline" href="https://twitter.com/corp_ecrs" data-widget-id="591261198701715457">Tweets por el @corp_ecrs.</a>
                                                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                                                        </div>					
                                                </aside>
                                                <!-- sidebar end -->

					</div>
				</div>
                                    
                                    
			</section>
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