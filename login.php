<?php
/**
 * Login exposes a login interface for web users
 *
 * @package NeatstuffReference
 * @author Dustin Doiron <dustin@weebly.com>
 * @since 
 */
require_once( __DIR__ . '/bootstrap/Init.php' );
$theme = new \Model\Theme(364);
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
<meta name="Description" content="FULLSCREEN Ð Photography Portfolio HTML5" />
<title>NeatStuff - Website Templates</title>
<link href="/css/reset.css" rel="stylesheet" type="text/css" media="screen" />
<link href="/css/contact.css" rel="stylesheet" type="text/css" media="screen" />
<link href="/css/styles.css" rel="stylesheet" type="text/css" media="screen" />
<link href="/css/flexslider.css" rel="stylesheet" type="text/css" media="screen">
<link href="/css/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if gt IE 8]><!--><link href="/css/retina-responsive.css" rel="stylesheet" type="text/css" media="screen" /><!--<![endif]-->
<!--[if !IE]> <link href="/css/retina-responsive.css" rel="stylesheet" type="text/css" media="screen" /> <![endif]-->
<!--[if gt IE 6]> <link href="/css/styles-ie.css" rel="stylesheet" type="text/css" media="screen" /> <![endif]-->
<link href="/css/print.css" rel="stylesheet" type="text/css" media="print" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,700,600,800' rel='stylesheet' type='text/css' />
</head>
<body class="classic">
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
          <li><a href="/">Home</a></li>
          <!--<li><a href="/about.php">About</a></li>-->
          <li><a href="/login.php" class="current">Login</a></li>
        </ul>
      </div>
      <!-- end nav -->
    </div>
  </header>
  <!-- end header -->
  <div id="content">
    <div class="container clearfix">
      <!--<div class="combi clearfix col1-1">-->
      <div class="col3-3">
        <div class="images"> <img src="<?=$theme->getScreenshotUrl()?>" alt="" /> </div>
        <div class="break"></div>
      </div>
      <div class="col1-3 white">
    <h2>Login to edit your site</h2>
    <form method="post" action="endpoint.php" name="contactform" id="contact" autocomplete="off">
      <fieldset>
        <div class="alignleft padding-right">
        <label for="email" accesskey="E"><span class="required">Email</span></label>
        <input name="email" type="text" id="email" size="30" title="Email *" />
        <label for="password" accesskey="E"><span class="required">Password</span></label>
        <input name="method" type="hidden" value="user::login" />
        <input name="password" type="password" id="password" size="30" title="password *" />
      </div>
      </fieldset>
    </form>
        <div class="grey-area clearfix">
          <p class="big button check alignleft"><a id="start-button" href="#">Login</a></p>
        </div>
        <p class="small">
      <span class="alignleft">
      </span>
    </p>
      </div>
      <div class="clear"></div>
      <!--</div>-->
    </div>
  </div>
  <!-- end content -->
</div>
<!-- end wrap -->
<footer>
  <div class="container">
    <ul class="social clearfix alignleft">
    </ul>
    <p class="small alignright"> &copy; 2015, NeatStuff, Inc.</p>
  </div>
</footer>
<!-- BACK TO TOP BUTTON -->
<div id="backtotop">
  <ul>
    <li><a id="toTop" href="#" onClick="return false">Back to Top</a></li>
  </ul>
</div>
<!--<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>-->
<script src="/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="/js/jquery-easing-1.3.js" type="text/javascript"></script>
<script src="/js/modernizr.js" type="text/javascript"></script>
<script src="/js/retina.js" type="text/javascript"></script>
<!--<script src="js/jquery.gomap-1.3.2.min.js" type="text/javascript"></script>-->
<script src="/js/jquery.isotope.min.js" type="text/javascript"></script>
<script src="/js/jquery.ba-bbq.min.js" type="text/javascript"></script>
<script src="/js/jquery.isotope.load.js" type="text/javascript"></script>
<script src="/js/jquery.isotope.perfectmasonry.js"></script>
<script src="/js/jquery.form.js" type="text/javascript"></script>
<script src="/js/input.fields.js" type="text/javascript"></script>
<script src="/js/responsive-nav.js" type="text/javascript"></script>
<script defer src="/js/jquery.flexslider-min.js"></script>
<script src="/js/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="/js/image-hover.js" type="text/javascript"></script>
<script src="/js/scrollup.js" type="text/javascript"></script>
<script src="/js/preloader.js" type="text/javascript"></script>
<script src="/js/navi-slidedown.js" type="text/javascript"></script>
<script src="/js/app.js" type="text/javascript"></script>
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</body>
</html>
