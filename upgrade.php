<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'لوحة التحكم';
include ('includes/header_teacher.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']) or ($_SESSION['user_level'] != 1))
{

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

}



?>
<div class="container-fluid">

<div id="banner-wrapper">
					<div id="banner" class="box container">

<?php

// Welcome the user (by name if they are logged in):
echo '<h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';

	// Display teacher menu:
	include ('includes/teacher_menu.php');



    echo'<div id="logo">
            <h3>ترقية الحساب: </h3>
            </div>';
                        
                        
                        
    echo'<div class="panel panel-warning">
				<div class="panel-heading">أسعار الترقية:</div>
				<div class="panel-body">
                
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
                
                
                
                
                </div>
				</div>';
                        
    echo '<div class="alert alert-success">طريقة الدفع:</div>';
                        
                        
                        
                                                            
    
    echo'<div class="panel panel-success">
				<div class="panel-heading">بطاقة ائتمانية ( فيزا \ ماستر كارد )</div>
				<div class="panel-body">
                
                يمكنكم الدفع عن طريق بطاقة ائتمانية ( فيزا \ ماستر كارد ) من خلال الرابط التالي:
                
                
      <br> <center> <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="3VYY9K3UFQU9Y">
<input type="image" src="http://ektabr.com/paypal.jpg" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/ar_EG/i/scr/pixel.gif" width="1" height="1">
</form>



</center>






                
               ';
                        
                echo'
                
                </div>
				</div>';
                        
     echo'<div class="panel panel-success">
				<div class="panel-heading">عن طريق التحويل البنكي</div>
				<div class="panel-body">
                
خدمة الدفع عن طريق التحويل البنكي متاحة في جميع مناطق المملكة
<br>
يتم تحويل المبلغ إلى حسابنا التالي:
<br>
<br>

<b> Al-Rajhi Bank | مصرف الراجحي </b>
<br>
رقم الحساب: 
<br>
الآيبان: 
<br>
اسم الجهة المحول لها:
<br>


                
                
                </div>
				</div>';
    
     echo'<div class="panel panel-default">
				<div class="panel-heading">الاتصال والمراسلة:</div>
				<div class="panel-body">
                
                 عن طريق الاتصال أو من خلال الواتس اب:
                <br>
                0583030313
                
                <br>                
                أو علي الايميل التالي:
                <br>
                moh8087@gmail.com
                
                
                
                
                </div>
				</div>';
                        
                        
                


?>



</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
