<?php # Script teacher.php
// This is the cPanle of a teacher.

// Include the configuration file:
require_once ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Start a test';
include ('includes/header.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']) or ($_SESSION['user_level'] != 2))  
{ 
	
	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
	
}
else {  // Welcome the user (by name if they are logged in):
	
	echo '<h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";
	
echo '</h1>';

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
	include ('includes/student_menu.php'); 

	$eid = $_SESSION['exam_id2'];
	
	require_once (MYSQL);
	
	if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) )
	{
		$selected_answer = FALSE;
		$page = (int) $_POST['id'];
		$idq = $_POST['id'];
		
		
		// define the user
	    $user = $_SESSION['user_id'];
		$question_number = $_SESSION['question']; // this save the previous question to add it in answer table 
		$c_answer =  $_SESSION['c_answer']; // to save the correct_answer	  
			  
	       if(isset($_POST['correct_answer']))
		   {
			$selected_answer = $_POST['correct_answer'];
			echo $selected_answer;
			
			$next = $page + 1; // next question 
			$page = $page + 1;
			$prev = $page - 1;  // previous question
			
			
			
			// Add the answer to the database:
			$q = "INSERT INTO answer (exam_id, question_id, user_id, selected_answer, correct_answer) VALUES ('$eid', '$question_number', '$user', '$selected_answer', '$c_answer')";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.
	 
			    echo '<center><p style="color:red;font-size:17px">تم حفظ الإجابة بنجاح<p></center>';	
				
			} 
			else { // If it did not run OK.
				echo '<p class="error">لم تتم إضافة الجواب</p>';
			}
			
			
		   }	
            else 
			{
				echo '<center><p style="color:red;font-size:17px"> اختر إجابة للاستمرار ۔۔ </p></center>';
				$next = $page; // show the current question
				$prev = $page -1 ;
				
			}	
		
		
	}
	elseif ( (isset($_POST['id2'])) && (is_numeric($_POST['id2'])) )
	{
		$selected_answer = FALSE;
		$page = (int) $_POST['id2'];
		$idq = $_POST['id2'];
		
		// define the user
	      $user = $_SESSION['user_id'];
		
		$question_number = $_SESSION['question']; // this save the previous question to add it in answer table 
		$c_answer =  $_SESSION['c_answer']; // to save the correct_answer	 
			  
			  
	       if(isset($_POST['correct_answer']))
		   {
			$selected_answer = $_POST['correct_answer'];
			echo $selected_answer;
			
			$next = $page + 1; // next question 
			//$page = $page + 1;
			$prev = $page - 1;  // previous question
			
			
			
			
			
			// Add the answer to the database:
			$q = "INSERT INTO answer (exam_id, question_id, user_id, selected_answer, correct_answer) VALUES ('$eid', '$question_number', '$user', '$selected_answer', '$c_answer')";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.
	 
			    echo '<center><p style="color:red;font-size:17px">تم حفظ الإجابة بنجاح<p></center>';	
				
			} 
			else { // If it did not run OK.
				echo '<p class="error">لم تتم إضافة الجواب</p>';
				
			}
			
			
			
		   }	
            else 
			{
				echo '<center><p style="color:red;font-size:17px"> اختر إجابة للاستمرار ۔۔  </p></center>';
				$page = $page + 1 ;
				$next = $page ; // show the current question
				$prev = $page - 1 ;
			}		
		
		
	}
	elseif ( (isset($_POST['id3'])) && (is_numeric($_POST['id3'])) )
	{
		$selected_answer = FALSE;
		$page = (int) $_POST['id3'];
		$idq = $_POST['id3'];
		
		// define the user
	      $user = $_SESSION['user_id'];
		
		$question_number = $_SESSION['question']; // this save the previous question to add it in answer table 
		$c_answer =  $_SESSION['c_answer']; // to save the correct_answer	 
			  
			  
	       if(isset($_POST['correct_answer']))
		   {
			$selected_answer = $_POST['correct_answer'];
			echo $selected_answer;
			
			// Add the answer to the database:
			$q = "INSERT INTO answer (exam_id, question_id, user_id, selected_answer, correct_answer) VALUES ('$eid', '$question_number', '$user', '$selected_answer', '$c_answer')";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.
	 
			    echo '<center><p style="color:red;font-size:17px">تم حفظ الإجابة بنجاح<p></center>';	
				
				
				// Finish the page:
			    echo '<center><h1>تم تسليم الاختبار بالنجاح ۔۔ تمنياتنا بالتوفيق </h1>';
				echo '<a href="results.php" title="adding questions"><h1> اضغط هنا لعرض النتيجة</h1></a><br /></center>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
			} 
			else { // If it did not run OK.
				echo '<p class="error">لم تتم إضافة الجواب</p>';
				
			}
			
			
			
		   }	
            else 
			{
				echo '<center><p style="color:red;font-size:17px"> اختر إجابة للاستمرار ۔۔  </p></center>';
				
					$next = $page; // stay in last question 
			        $prev = $page - 1;  // previous question
			}		
		
		
	}
	else 
	{
			$page = 1;	
			$next = $page;
			$prev = 0;
	}
     
 
	
	$questions_at_page = 1;
	
	$q = "SELECT question_id, question, answer1, answer2, answer3, answer4, correct_answer from question WHERE exam_id='$eid'";
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		
	$questions_count = mysqli_num_rows($r);
	@mysqli_free_result($r);
	
	$pages_count = (int)ceil ($questions_count / $questions_at_page );
	
	if (($page > $pages_count) || ($page <=0))
	{
		mysqli_close($dbc);
		die('لا يوجد المزيد من الأسئلة');
	}
	
	$start = ($page - 1 ) * $questions_at_page;
	$end = $questions_at_page;
	
	if ($questions_count !=0)
	{
		$q = "SELECT question_id, question, answer1, answer2, answer3, answer4, correct_answer from question WHERE exam_id='$eid' LIMIT $start,$end";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		
		if (mysqli_num_rows($r) > 0 )
		{
			$row = mysqli_fetch_array($r, MYSQLI_NUM); // very important MYSQLI_NUM insted of MYSQLI_ASSOC
			
			echo '<form action="real_test3.php" method="post">';

			echo '<table align="center" width="40%"  border="0">

<tr>
<td> ' . $page . ' . ' . $row[1] . '; </td>
</tr>
<tr>
<td align="right"> اختر الإجابة الصحيحة: </td>
</tr>
<tr>
             <td> <input type="radio" name ="correct_answer" value="1"> ' . $row[2] . ' <br>
                  <input type="radio" name ="correct_answer" value="2"> ' . $row[3] . '<br>
	              <input type="radio" name ="correct_answer" value="3"> ' . $row[4] . ' <br>
                  <input type="radio" name ="correct_answer" value="4"> ' . $row[5] . ' <br>
                  </td>
</tr>';
          
		   $_SESSION['question'] = $row[0]; // to keep that number then add it to answer table during the forms submitted in next question
		  $_SESSION['c_answer'] = $row[6]; // to save the correct_answer


mysqli_free_result ($r); // Free up the resources
		}




if ($next < $pages_count)
{
	echo '<tr><td><button name="id" type="submit" value="' . $next . '">التالي</button>';
}
	
 if (($next < $pages_count) && ($prev > 0) )
	 {
		 echo ' - ';  
	 }
	 
if ($prev > 0 )
{
	echo '<button name="id2" type="submit" value="' . $prev . '">السابق</button>';
}

 if ($next >= $questions_count )
	 {
	   echo '<tr><td><button name="id3" type="submit" value="' . $page . '">تسليم الاختبار</button>';
	 }
	 
	 
echo '
</td>
</tr>
</table>

</form>
';
 
mysqli_close($dbc);

			
		
		
	}
			
			

?>



</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>