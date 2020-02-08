<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - تعديل اختبار';
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
            <h3>تعديل معلومات اختبار:</h3>
            </div>';




	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From teacher.php
           $id = $_GET['id'];


		   require_once (MYSQL);



		// To prevent the other teachter to edit each other
		$q = "SELECT exam_id, user_id, exam_name FROM exam WHERE (exam_id='$id')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			if (($_SESSION['user_id']) != $row['user_id'] )
			{
				$url = BASE_URL . 'index.php'; // Define the URL.
                ob_end_clean(); // Delete the buffer.
	            header("Location: $url");
	            exit(); // Quit the script.

			}

				else
				{




	// Display all teacher's exams
$q = "SELECT exam_id, exam_name, description, active, time_limit, show_result FROM exam WHERE exam_id='$id'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r) == 1)
		{
			$row = mysqli_fetch_array($r, MYSQLI_NUM); // very important MYSQLI_NUM insted of MYSQLI_ASSOC


			echo '<form action="edit_test.php" method="post" role="form">';

			echo '<div class="panel panel-default">
      <div class="panel-heading">اسم الاختبار: </div>
      <div class="panel-body">

<input type="text" name="exam_name" class="form-control" value="' . $row[1] . '">
  </div>
    </div>

 <div class="panel panel-default">
      <div class="panel-heading">مدة الاختبار ( بالدقيقة):</div>
      <div class="panel-body">
	  <input type="text" name="time_limit" class="form-control" value="' . $row[4] . '">
	  </div>
	  </div>

 <div class="panel panel-default">
      <div class="panel-heading">هل تريد تفعيل الاختبار ؟</div>
      <div class="panel-body">';



				if ($row[3] == 1 )
			{
				echo '<input type="radio" name ="active" value="1" checked > نعم
					  <input type="radio" name ="active" value="2"> لا
                       </div>
                       </div>';

			}
			else {
				echo '<input type="radio" name ="active" value="1"  > نعم
					  <input type="radio" name ="active" value="2" checked> لا
                      </div>
                      </div>';

			}

echo ' <div class="panel panel-default">
      <div class="panel-heading">هل تريد عرض النتائج للطلاب عند الانتهاء من الاختبار:</div>
      <div class="panel-body">';

				if ( $row[5] == 1  )
				{
					echo '<input type="radio" name ="show_result" value="1" checked > نعم
							<input type="radio" name ="show_result" value="2"> لا
							</div>
                      </div>';
				}
				else {
					echo '<input type="radio" name ="show_result" value="1"  > نعم
							<input type="radio" name ="show_result" value="2" checked> لا
							</div>
                      </div>';
				}

echo '<div class="panel panel-default">
      <div class="panel-heading">ادخل تعلميات الاختبار ( سوف تظهر للطالب قبل بدء الاختبار ):</div>
      <div class="panel-body">
	   <textarea name="description" class="form-control" rows="5" id="comment">' . $row[2] . '</textarea>
	   </div>
    </div>

		<button type="submit" class="btn btn-primary btn-lg" name="submit">تعديل</button>
		<input type="hidden" name="id" value="' . $id . '" />

</form>
';

mysqli_free_result ($r); // Free up the resources
            }




	}
	}

	 elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission
              $id = $_POST['id'];



		 require_once (MYSQL);

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$en = $tl = FALSE;

	// Check for the exam name:
	if (preg_match ("~^[a-z0-9٠-٩\-+,()/'\s\p{Arabic}]{1,60}$~iu", $trimmed['exam_name'])) {
		$en = mysqli_real_escape_string ($dbc, $trimmed['exam_name']);
	} else {
		echo '<div class="alert alert-danger">الرجاء ادخل اسم الاختبار</div>';
	}


	// Check for a time limit:
	if (preg_match ('/^[1-9][0-9]{0,90}$/', $trimmed['time_limit']) ) {
			$tl = mysqli_real_escape_string ($dbc, $trimmed['time_limit']);
		} else {
			echo '<div class="alert alert-danger">الرجاء ادخال ارقام فقط في خانة وقت الاختبار ، مع ملاحظة أن لا يكون الرقم أكبر من 90 دقيقة</div>';
		}

	// desciption
	$d = $trimmed['description'];

	// active test
	$ac = $trimmed['active'];

	// show result

	$s = $trimmed['show_result'];





	if ($en && $tl) { // If everything's OK...



			// update the exam to the database:
			$q = "UPDATE exam SET exam_name='$en', description='$d', active='$ac', time_limit='$tl', show_result='$s'  WHERE exam_id='$id'";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.


			    echo '<div class="alert alert-success">تم تعديل البيانات</div>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.


			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم تتم عملية تعديل البيانات </div>';
			}
	}


	else { // No valid ID, stop the script.
           echo '<div class="alert alert-danger">ادخل البيانات بالشكل المطلوب </div>';
          }




	}


	else
	{
		echo '<p class="error">خطأ في نقل البيانات</p>';
	}









?>






</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
