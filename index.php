<?php
/**
 * Index shows all of our themes for a user to choose on the signup flow
 *
 * @package NeatstuffReference
 * @author Drew Richards <drew@weebly.com>
 * @since 
 */
require_once( __DIR__ . '/bootstrap/Init.php' );
$tags = array("Bold", "Corporate", "Fun", "Simple", "Sleek");
$themes = \Model\Theme::findAll();
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]> <html class="no-js ie9 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"  dir="ltr" lang="en-US"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="author" content="ppandp">
<meta name="Description" content="FULLSCREEN – Photography Portfolio HTML5" />
<title>NeatStuff – Website Templates</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/contact.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/styles.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/flexslider.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if gt IE 8]><!--><link href="css/retina-responsive.css" rel="stylesheet" type="text/css" media="screen" /><!--<![endif]-->
<!--[if !IE]> <link href="css/retina-responsive.css" rel="stylesheet" type="text/css" media="screen" /> <![endif]-->
<!--[if gt IE 6]> <link href="css/styles-ie.css" rel="stylesheet" type="text/css" media="screen" /> <![endif]-->
<link href="css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,700,600,800' rel='stylesheet' type='text/css' />
</head>
<body class="index full-opacity">
<div id="wrap">
  <!-- Preloader -->
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
  <header id="wrapper">
    <div class="container clearfix">
      <h1 id="logo"><a href="index.html">MY FOLIO</a></h1>
      <!-- start navi -->
      <div id="nav-button"> <span class="nav-bar"></span> <span class="nav-bar"></span> <span class="nav-bar"></span> </div>
      <div id="options" class="clearfix">
        <ul id="main-menu">
          <li><a href="/index.html" class="current">Home</a></li>
          <!--<li><a href="/about.php">About</a></li>-->
          <li><a href="/login.php">Login</a></li>
        </ul>
        <ul id="homepage" class="option-set clearfix" data-option-key="filter">
          <li><a href="#filter=.home" class="selected">All</a>
		  <?php foreach ($tags as $tag): ?>
		  <li><a href="#filter=.<?=$tag?>"><?=$tag?></a></li>
		  <?php endforeach ?>
        </ul>
      </div>
      <!-- end nav -->
    </div>
  </header>
  <!-- end header -->
  <div id="content">
    <ul id="container">
	  <?php foreach ($themes as $theme): ?>
	  <li class="element home <?=str_replace(",", " ", $theme->tags)?>">
	    <a href="/theme/<?=$theme->theme_id?>" title="Esparagus">
        <div class="images"><img src="<?=$theme->getScreenshotUrl()?>" alt="" />
          <div class="title">
            <div class="title-wrap">
              <h3><span><?=$theme->name?></span> </h3>
            </div>
          </div>
          <div class="subtitle">
            <div class="subtitle-wrap">
              <p> <span><?=$theme->price?> - <?=$theme->tags?></span> </p>
            </div>
          </div>
        </div>
        </a>
	  </li>
	  <?php endforeach ?>
    </ul>
  </div>
  <!-- end content -->
</div>
<!-- end wrap -->
<footer>
  <div class="container">
    <ul class="social clearfix alignleft">
	<!--
      <li class="pinterest"><a href="#" onClick="return false">Visit our pinterest Account</a></li>
      <li class="dribble"><a href="#" onClick="return false">Visit our dribble Account</a></li>
      <li class="tweat"><a href="#" onClick="return false">Visit our twitter Account</a></li>
      <li class="instagram"><a href="#" onClick="return false">Visit our instagram Account</a></li>
	-->
    </ul>
    <p class="small alignright"> © 2015, NeatStuff, Inc.</p>
  </div>
</footer>
<!-- BACK TO TOP BUTTON -->
<div id="backtotop">
  <ul>
    <li><a id="toTop" href="#" onClick="return false">Back to Top</a></li>
  </ul>
</div>
<!--<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>-->
<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="js/jquery-easing-1.3.js" type="text/javascript"></script>
<script src="js/modernizr.js" type="text/javascript"></script>
<script src="js/retina.js" type="text/javascript"></script>
<!--<script src="js/jquery.gomap-1.3.2.min.js" type="text/javascript"></script>-->
<script src="js/jquery.isotope.min.js" type="text/javascript"></script>
<script src="js/jquery.ba-bbq.min.js" type="text/javascript"></script>
<script src="js/jquery.isotope.load_home.js" type="text/javascript"></script>
<script src="js/jquery.isotope.perfectmasonry.js"></script>
<!--<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/input.fields.js" type="text/javascript"></script>-->
<script src="js/responsive-nav.js" type="text/javascript"></script>
<script defer src="js/jquery.flexslider-min.js"></script>
<script src="js/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="js/image-hover_opacity1.js" type="text/javascript"></script>
<script src="js/scrollup.js" type="text/javascript"></script>
<script src="js/preloader.js" type="text/javascript"></script>
<script src="js/navi-slidedown.js" type="text/javascript"></script>
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</body>
</html>
