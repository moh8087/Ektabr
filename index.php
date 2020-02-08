<?php # Script index.php
// This is the main page for the site.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر';
include ('includes/header.html');

?>

<?php
//Welcome the user (by name if they are logged in):
//echo '<h1>مرحبا';
if (isset($_SESSION['fullname'])) {
//	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

			if ($_SESSION['user_level'] == 1)
				{
					$url = BASE_URL . 'teacher.php'; // Define the URL:
					ob_end_clean(); // Delete the buffer.
					header("Location: $url");
					exit(); // Quit the script.
					}

			elseif ($_SESSION['user_level'] == 2)
			    {
					$url = BASE_URL . 'student.php'; // Define the URL:
					ob_end_clean(); // Delete the buffer.
					header("Location: $url");
					exit(); // Quit the script.

					}
			else {
					echo '<center><div class="alert alert-danger">الحساب غير مفعل <a href="logout.php">تسجيل الخروج</a></div></center>';
					}

}

else {

	echo '<!-- Banner -->
				<div id="banner-wrapper">
					<div id="banner" class="box container">
						<div class="row">
							<div class="7u 12u(medium)">
								<div class="container-fluid">
  <h2>الاختبار الإلكتروني الميسر</h2>
  <p>اختبر هي خدمة لإنشاء الاختبارات الإلكترونية بكل سهولة</p>
</div>
							</div>
							<div class="5u 12u(medium)">
								<ul>
									 <li><a href="register.php" ><img src="images/teacher.png" alt="" /></a> <a href="register.php"><div id="logo"><h4> إنشــاء اختبــار</h4><div></a> </li>

									 <li><a href="student_register.php" ><img src="images/student.png" alt="" /></a> <a href="login.php"><div id="logo"><h4>دخول الاختبار</h4><div></a> </li>



								</ul>
							</div>
						</div>
					</div>
				</div>';



	echo'<!-- Features -->
				<div id="features-wrapper">
					<div class="container">
						<div class="row">

						</div>
					</div>
				</div>';


	echo ' <!-- Main -->
				<div id="main-wrapper">
					<div class="container">
						<div class="row 200%">
							<div class="4u 12u(medium)">

								<!-- Sidebar -->
									<div id="sidebar">
										<section class="widget thumbnails">
											<h3>اختبر متوافق مع جميع الأجهزة: </h3>
											<div class="grid">
												<div class="row 50%">

													<img class="img-responsive" src="images/responsive.png" alt="">

												</div>
											</div>

										</section>
									</div>

							</div>
							<div class="8u 12u(medium) important(medium)">

								<!-- Content -->
									<div id="content">
										<section class="last">
											<div class="container-fluid">
											<div id="logo">
											<h2>ما هي خدمة اختبر ؟ </h2>
											<div>
											<p class="fontg">نظام متكامل لإدارة الاختبارات بشكل إلكتروني ، يساعد المعلم على إدارة الاختبارات وحفظ النتائج بكل سهولة<p>
  <table class="table table-condensed">
    <thead>
      <tr class="warning" >
        <td><b>المميزات: </b></td>
      </tr>
	  <tr >
        <td>يوفر وقت وجهد التصحيح</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>نتائج فورية</td>
      </tr>
      <tr>
        <td>يدعم العربية بالكامل</td>
      </tr>
      <tr>
        <td>مناسب للجامعات والمدارس والمعاهد والمؤسسات</td>
      </tr>
	   <tr>
        <td>اختبر خدمة آمنة ، مجانية ، موثوقة</td>
      </tr>
    </tbody>
  </table>
</div>



										</section>
									</div>

							</div>
						</div>
					</div>
				</div>




				';


	echo '<br> <br>
	<!-- Main -->
				<div id="main-wrapper">
					<div class="container">
						<div class="row 200%">
							<div class="4u 12u(medium)">

							<!-- Sidebar -->
								<div id="sidebar">
									<section class="widget thumbnails">

										<div class="grid">
											<div class="row 50%">

												<img class="img-responsive" src="images/member2.png" alt="">

											</div>
										</div>

									</section>
								</div>

							</div>
							<div class="8u 12u(medium) important(medium)">

								<!-- Content -->
									<div id="content">
										<section class="last">
											<div id="logo">
											<h2>التسجيل والاشتراك:  </h2>
											<table class="table table-bordered">
										   <thead>
										      <tr class="warning" >
										        <td><b>مجاني: </b></td>
														<td><b>مدفوع: ١٠٠ ريال /سنة </b></td>
										      </tr>
											  <tr >
										        <td> إنشاء ٥ اختبارات فقط</td>
														<td> عدد لا محدود من الاختبارات</td>
										      </tr>
										    </thead>
										    <tbody>
										      <tr>
										        <td>٢٠ سؤال لكل اختبار</td>
														<td> ٢٠٠ سؤال لكل اختبار</td>
										      </tr>
										      <tr>
										        <td>٢٠ طالب لكل اختبار</td>
														<td> ٥٠٠ طالب لكل اختبار</td>
										      </tr>

										    </tbody>
										  </table>
											<div>
										</section>
									</div>

							</div>
						</div>
					</div>
				</div>';

	echo'<!-- Footer -->
				<div id="footer-wrapper">
					<footer id="footer" class="container">
						<div class="row">
							<div class="3u 6u(medium) 12u$(small)">

								<!-- Links -->
									<section class="widget links">
										<h3>معلم</h3>
										<ul class="style2">
											<li><a href="#">مميزات إنشاء الاختبارات</a></li>
										</ul>
									</section>

							</div>
							<div class="3u 6u$(medium) 12u$(small)">

								<!-- Links -->
									<section class="widget links">
										<h3>طالب</h3>
										<ul class="style2">
											<li><a href="#">شرح طريقة الاختبار</a></li>
										</ul>
									</section>

							</div>
							<div class="3u 6u(medium) 12u$(small)">

								<!-- Links -->
									<section class="widget links">
										<h3>مسؤول تقنية المعلومات</h3>
										<ul class="style2">
											<li><a href="http://ektabr.com/contact.html">شراء نسخة محلية</a></li>
										</ul>
									</section>

							</div>
							<div class="3u 6u$(medium) 12u$(small)">

								<!-- Contact -->
									<section class="widget contact last">
										<h3>تواصل معنا</h3>
										<ul>
											<li><a href="https://twitter.com/ektabr" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
											<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
											<li><a href="https://www.instagram.com/ektabr/" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
										</ul>
									</section>

							</div>
						</div>

					</footer>
				</div>';


}

?>


<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
