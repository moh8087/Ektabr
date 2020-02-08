<?php # Script 16.1 - header.html
// This page begins the HTML header for the site.

// Start output buffering:
ob_start();

// Initialize a session:
session_start();

// Check for a $page_title value:
if (!isset($page_title)) {
	$page_title = 'User Registration';
}
?>

<!DOCTYPE html>
<html dir="rtl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	
	
	
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body class="homepage">
		<div id="page-wrapper">

			<!-- Header -->
				<div id="header-wrapper">
					<header id="header" class="container">

						<!-- Logo -->
							<div id="logo">
								<h1><a href="index.php">اختبر</a></h1>
								<span>الاختبارات الإلكترونية بطريقة ميسرة</span>
							</div>

						<!-- Nav -->
							<nav id="nav">
								<ul>
									<li class="current"><a href="index.html">الرئيسية</a></li>
									<li>
										<a href="#">التعليمات</a>
										<ul>
											<li><a href="#">شراء نسخة</a></li>
											<li><a href="#">الاشتراك المدفوع</a></li>
											<li>
												<a href="#">اتصل بنا</a>
												<ul>
													<li><a href="#">مثال 1111</a></li>
													<li><a href="#">مثال 22222</a></li>
													<li><a href="#">ما هو اختبر</a></li>
													<li><a href="#">اتصل بنا</a></li>
												</ul>
											</li>
											<li><a href="#">Veroeros feugiat</a></li>
										</ul>
									</li>
									<li><a href="left-sidebar.html">شراء نسخة</a></li>
									<li><a href="right-sidebar.html">ما هو اختبر</a></li>
									<li><a href="no-sidebar.html">اتصل بنا</a></li>
								</ul>
							</nav>

					</header>
				</div>

			
				
				<!-- Scripts -->

			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

			
			
			
			
			
			
			<?php
			
			
		  if (!isset($_SESSION['time_remaining'])) {
			  
		 $time = time();
          $_SESSION['time_started'] = $time;
          $_SESSION['time_remaining'] = 2700; //45 minutes
		  }
		  
		  else{
		  
		  $oldtime = $_SESSION['time_started'];
          $newtime = time();
          $difference = $newtime - $oldtime;
          $_SESSION['time_remaining'] = $_SESSION['time_remaining'] - $difference;
          if ($_SESSION['time_remaining'] > 0)
          { 
              $_SESSION['time_started'] = $newtime; 
             //continue
          } else {
             //out of time
          }
		  }
		  
		  
		  
		  echo gmdate("H:i:s",  $_SESSION['time_remaining']);
		  
		  
		  
			
			
			
			
			
			
			
			?>
			
			
			
			
			<!-- End of Content -->
</div>

<div id="copyright" class="container">
	<p>جميع الحقوق محفوظة لموقع اختبر </p>
</div>
</body>
</html>

<?php // Flush the buffered output.
ob_end_flush();
?>



