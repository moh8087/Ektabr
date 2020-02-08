<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php');
include ('includes/header_print.html');

// Set the page title and include the HTML header:
$page_title = 'اختبر - عرض النتائج';


// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']) or ($_SESSION['user_level'] != 1))
{

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

}


?>



<?php

	// Welcome the user (by name if they are logged in):





	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // 100
           $id = $_GET['id'];


		   require_once (MYSQL);

		   // To prevent the other teachter to edit each other
		$q = "SELECT exam_id, user_id, exam_name FROM exam WHERE (exam_id='$id')";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			if (($_SESSION['user_id']) != $row['user_id'] )
			{ //101
				$url = BASE_URL . 'index.php'; // Define the URL.
                ob_end_clean(); // Delete the buffer.
	            header("Location: $url");
	            exit(); // Quit the script.

			} //101

				else
				{ //200


									// to identify exam name by using exam id
									$q2 = "SELECT exam_id, exam_name FROM exam WHERE exam_id='$id'";
									$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q2\n<br />MySQL Error: " . mysqli_error($dbc));


										if (mysqli_num_rows($r2) > 0)
											{
											  $row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);

											  $ex_name = $row2['exam_name'];
											  mysqli_free_result ($r2); // Free up the resources

											}





	// Display all students' results
	$q3 = "SELECT result_id, exam_id, user_id, total_mark, got_mark, start_test, end_test from result WHERE exam_id='$id'";
	$r3 = mysqli_query ($dbc, $q3) or trigger_error("Query: $q3\n<br />MySQL Error: " . mysqli_error($dbc));


		if (mysqli_num_rows($r3) > 0)
		{ // 201

			

			$file="results.xls";
			$test='<table>
			<tr><td><h1>اسم الاختبار: </h1></td><td><h1>  ' . $ex_name . ' </h1></td></tr>
			<tr></tr>
			
			
			<tr><td><b>رقم</b></td>
			<td><b>اسم الطالب</b></td>
			<td><b>البريد الإلكتروني</b></td>
			<td><b>الدرجة</b></td>
			<td><b>من</b></td>
			<td><b>النسبة</b></td>
			<td><b>التاريخ</b></td>
			

			</tr>';
			
			$i=0;

			// Fetch and print the records:
			while ($row3 = mysqli_fetch_array($r3, MYSQLI_ASSOC)) {


			$i++;
			$test .='<tr><td>' . $i . '</td>';

			$total_mark = $row3['total_mark'];
			$got_mark = $row3['got_mark'];
			$per = ($got_mark/$total_mark) * 100;
			$per2 = round($per, 2);
			$student_id = $row3['user_id'];



										// to get the student name from users table by identified user_id on answer table:
										$q4 = "SELECT user_id, fullname, email FROM users WHERE user_id='$student_id'";
										$r4 = mysqli_query ($dbc, $q4) or trigger_error("Query: $q4\n<br />MySQL Error: " . mysqli_error($dbc));


										if (mysqli_num_rows($r4) > 0)
											{
											  $row4 = mysqli_fetch_array($r4, MYSQLI_ASSOC);

											  $student_name = $row4['fullname'];
												$student_email = $row4['email'];
											  mysqli_free_result ($r4); // Free up the resources

											}





			$test .='<td>' . $student_name . '</td>
			<td>' . $student_email . '</td>
			<td>' . $got_mark . ' </td>
			<td>' . $total_mark . '</td>
			<td>' . $per2 . ' %</td>
			<td>' . $row3['end_test'] . '</td>

			
			</tr>';
			}

			$test .='</table></div>'; // Close the table

			// print page
						
			header("Content-Disposition: attachment; filename=\"$file\""); 
			header("Content-Type: application/vnd.ms-excel");
			echo $test;



			mysqli_free_result ($r3); // Free up the resources
		} // 201

		else
		{
			echo '<div class="alert alert-warning">لا توجد نتيجة لعرضها</div>';

		}


	} // 200
	}	 //100

	else { // No valid ID exam.
           echo '<div class="alert alert-danger">لا يوجد نتيجة لعرضها</div>';
          }




  // define the exam_id from teacher.php
  //$exam_iddd = $_GET['id'];
  // echo $exam_iddd;






?>





</div>
<?php // Include the HTML footer file:
include ('includes/footer_print.html');
?>
