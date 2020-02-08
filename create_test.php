<?php # Script create_test.php
// to create a new test

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبار جديد';
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

<div id="banner-wrapper">
					<div id="banner" class="box container">

<?php

// Welcome the user (by name if they are logged in):
echo '<h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";

echo '</h1>';


// Display teacher menu:
	include ('includes/teacher_menu.php');

	echo'<ol class="breadcrumb" style="margin-bottom: 5px;">
	<li class="active"><a href="create_test.php">إنشاء اختبار</a></li>
	<li>إضافة أسئلة</li>
	<li >نشر الاختبار</li>
</ol>
<br>';

						echo'<div id="logo">
            <h3>إضافة اختبار جديد:  </h3>
            </div>';
                        
                        

// to identify how many exam created by this user 
// لمعرفة اذا كانت العضوية مجانية فلا يمكن انشاء اكثر من ٥ اختبارات
                        
    // define the user
	$u = $_SESSION['user_id'];
                        
    require_once (MYSQL);


	// Check if user's membership is free or paid
	$q = "SELECT *  FROM users WHERE user_id='$u'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) > 0)
		{
        
         if ($row['membership'] = "free" )
			{
				$membership="free";
			}
			else{
				$membership="paid";
				
			}
        
        
        }
        
        
        
        
            // THEN
            // Calculate number OF Exams
        	// new query to identify the number of quetions in this exam
			$q2 = "SELECT * from exam WHERE user_id='$u'";
         	$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


	        $questions_count = mysqli_num_rows($r2);
	        @mysqli_free_result($r2);
            
            
            if ($membership == "free" && $questions_count >=5)
            {
             echo '<div class="alert alert-danger">لا يمكن إنشاء اكثر من خمس اختبارات بسبب عضويتك المجانية</div>';            
             echo'<div class="panel panel-success">
				<div class="panel-heading">طريقة الترقية:</div>
				<div class="panel-body">
                
                <a href="upgrade.php">لترقية العضوية .. اضغط هنا</a>
                
                
                
                </div>
				</div>';
                
                exit(); // Quit the script.   
            
            }
                        
                        
    // Or
    /*if ( $_SESSION['membership'] == "free" )
    {
        
         require_once (MYSQL);

	// define the user
     $user = $_SESSION['user_id'];


	$q = "SELECT exam_id, user_id FROM exam WHERE user_id='$user'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) >= 5)
		{ // 100
            
            echo '<div class="alert alert-danger">لا يمكن إنشاء اكثر من خمس اختبارات بسبب عضويتك المجانية</div>';            
             echo'<div class="panel panel-success">
				<div class="panel-heading">طريقة الترقية:</div>
				<div class="panel-body">
                
                <a href="upgrade.php">لترقية العضوية .. اضغط هنا</a>
                
                
                
                </div>
				</div>';
            	exit(); // Quit the script.

            
        }
        
        
        
        
    }
                        
    else
    {
        
        
        
    }*/

                        
                        




if (isset($_POST['submitted'])) { // Handle the form.

	require_once (MYSQL);

	// define the user
	$u = $_SESSION['user_id'];

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$en = $tl = FALSE;

	// Check for the exam name:
	if (!empty ($trimmed['exam_name'] ) )
	 {

		$en = mysqli_real_escape_string ($dbc, $trimmed['exam_name']);
		$en = trim($en);
    $en = htmlspecialchars($en);
	} else {
		echo '<div class="alert alert-danger">الرجاء ادخل اسم الاختبار</div>';

	}

	/* Check for the exam name:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['exam_name'])) {
		$en = mysqli_real_escape_string ($dbc, $trimmed['exam_name']);
		//$en = trim($en);
  //  $en = stripslashes($en);
  //  $en = htmlspecialchars($en);
	} else {
		echo '<div class="alert alert-danger">الرجاء ادخل اسم الاختبار</div>';

	} */


	// Check for a time limit:
	if (preg_match ('/^[1-9][0-9]{0,90}$/', $trimmed['time_limit']) ) {
			$tl = mysqli_real_escape_string ($dbc, $trimmed['time_limit']);
		} else {
			echo '<div class="alert alert-danger">الرجاء ادخال ارقام فقط في خانة وقت الاختبار ، مع ملاحظة أن لا يكون الرقم أكبر من 90 دقيقة</div>';

		}

	// desciption
	$d = mysqli_real_escape_string ($dbc, $trimmed['editor1']);
	$d = htmlspecialchars_decode($d);


	// active test
	$ac = $trimmed['active'];

	// show result

	$s = $trimmed['show_result'];




	if ($en && $tl) { // If everything's OK...

		// Create the exam code:
		//	$c = uniqid();
		// new way to great code has 6 digits.
		$c = substr ( md5(uniqid(rand(), true)), 3, 6);

		// Make sure the exam code is available:
		$q = "SELECT exam_id FROM exam WHERE exam_code='$c'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

		if (mysqli_num_rows($r) == 0) { // Available.


			// Add the exam to the database:
			$q = "INSERT INTO exam (user_id, exam_name, description, exam_code, created, active, time_limit, show_result) VALUES ('$u','$en', '$d', '$c', now() , '$ac', '$tl', '$s' )";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

                    $last_id = mysqli_insert_id($dbc); // to get the exam id number

					 $_SESSION['exam_idd'] = $last_id;

					 $q = "SELECT exam_code FROM exam WHERE exam_id='$last_id'";
					 $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
					 $row = mysqli_fetch_assoc($r);


					 $_SESSION['exam_code'] = $row['exam_code'];


				// echo '<a href="add_question.php?id=' . $last_id . '" title="adding questions"><h1> اضغط هنا لإضافة الاسئلة</h1></a><br /></center>';



				$url = BASE_URL . 'add_question.php'; // Define the URL.
	            ob_end_clean(); // Delete the buffer.
	            header("Location: $url");
	            exit(); // Quit the script.

				// Finish the page:
			    //echo '<center><h1>تم إنشاء الاختبار </h1>';
				//echo '<a href="add_question.php" title="adding questions"><div id="logo">
											//<h2>إضافة أسئلة للاختبار </h2>
										//	<div></a><br /></center>';
				//include ('includes/footer.html'); // Include the HTML footer.
				//exit(); // Stop the page.



			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">لا يمكن اضافة اختبار جديد ، فضلا حاول مرة أخرى</div>';
					}

		} else { // The exam code is not available.
			echo '<div class="alert alert-danger">الرجاء تأكيد إضافة الاختبار مرة أخرى</div>';
				}

	} else { // If one of the data tests failed.
		echo '<div class="alert alert-danger">الرجاء ادخال البيانات بالشكل الصحيح</div>';
			}

	mysqli_close($dbc);

} // End of the main Submit conditional.









?>



<div class="container-fluid">

   <form action="create_test.php" method="post" role="form">

	<div class="panel panel-default">
      <div class="panel-heading">اسم الاختبار: </div>
      <div class="panel-body"><input type="text" name="exam_name" class="form-control" id="text" placeholder="" value="<?php if (isset($trimmed['exam_name'])) echo $trimmed['exam_name']; ?>">
	  </div>
    </div>


	<div class="panel panel-default">
      <div class="panel-heading">مدة الاختبار ( بالدقيقة):</div>
      <div class="panel-body"><input type="text" name="time_limit" class="form-control" id="text" placeholder="">
	  </div>
    </div>

<div class="panel panel-default">
      <div class="panel-heading">هل تريد تفعيل الاختبار ؟</div>
      <div class="panel-body">
	  <input type="radio" name ="active" value="1" checked > نعم
     <br>
	 <input type="radio" name ="active" value="2"> لا
	 </div>
    </div>


	 <div class="panel panel-default">
      <div class="panel-heading">هل تريد عرض النتائج للطلاب عند الانتهاء من الاختبار:</div>
      <div class="panel-body"><input type="radio" name ="show_result" value="1" checked > نعم
     <br><input type="radio" name ="show_result" value="2"> لا
	 </div>
    </div>

	<div class="panel panel-default">
      <div class="panel-heading">ادخل تعلميات الاختبار ( سوف تظهر للطالب قبل بدء الاختبار ):</div>
      <div class="panel-body">
	  <textarea name="editor1"></textarea>
        <script>
            CKEDITOR.replace( 'editor1' );
        </script></div>
	  </div>
    </div>

	<button type="submit" class="btn btn-primary btn-lg">تأكيد</button>
	<input type="hidden" name="submitted" value="TRUE" />
  </form>
</div>





</div>
</div>



<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
