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
	
	if (!isset($_POST['id'])) 
	{
		$page = 1;
	}
	else 
	{
		$page = (int) $_POST['id'];
	}
     
    /* if ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) // Form submission
	{ 
              $idq = $_POST['id'];
			  
			  
	        $co = $_POST['correct_answer'];
			echo $co;
	
	
	 }	 */
	
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
			
			echo '<form action="next_test3.php" method="post">';

			echo '<table align="center" width="40%"  border="0">
<td align="right" > ادخل السؤال: </td>
</tr>
<tr>
<td> ' . $row[1] . '; </td>
</tr>
<tr>
<td align="right"> اختر الإجابة الصحيحة: </td>
</tr>
<tr>
             <td> <input type="radio" name ="correct_answer" checkedvalue="1"> ' . $row[2] . ' <br>
                  <input type="radio" name ="correct_answer" value="2"> ' . $row[3] . '<br>
	              <input type="radio" name ="correct_answer" value="3"> ' . $row[4] . ' <br>
                  <input type="radio" name ="correct_answer" value="4"> ' . $row[5] . ' <br>
                  </td>
</tr>';



mysqli_free_result ($r); // Free up the resources
		}


$next = $page + 1;
$prev = $page -1;

if ($next <= $pages_count)
{
	echo '<button type="submit" name="submit">التالي</button>
	<input type="hidden" name="id" value="' . $next . '" />	';
}
	
	 if (($next <= $pages_count) && ($prev > 0) )
	   echo ' - '; 
	 
if ($prev > 0 )
{
	echo '<button type="submit" name="submit">السابق</button>
	<input type="hidden" name="id" value="' . $prev . '" />	';
}
echo '<tr>
<td> <button type="submit" formaction="submit_test.php" name="submit">إنهاء الاختبار</button> </td>
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
