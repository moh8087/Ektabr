<?php # Script create_test.php
// to create a new test

// Include the configuration file:
require_once ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'اختبر - إضافة الأسئلة';
include ('includes/header_teacher.html');

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']) or ($_SESSION['user_level'] != 1)) {

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

}





?>

<div id="banner-wrapper">
					<div id="banner" class="box container">

<?php

echo '<p><h1>مرحبا';
	echo ", {$_SESSION['fullname']}!";

echo '</h1></p>';



	// Display teacher menu:
	include ('includes/teacher_menu.php');
                        
                        
// لمعرفة اذا كانت العضوية مجانية فلا يمكن انشاء اكثر من 100 سؤال
                        
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
			$q2 = "SELECT * from question WHERE user_id='$u'";
         	$r2 = mysqli_query ($dbc, $q2) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));


	        $questions_count = mysqli_num_rows($r2);
	        @mysqli_free_result($r2);
            
            
            if ($membership == "free" && $questions_count >=100)
            {
             echo '<div class="alert alert-danger">لا يمكن إنشاء اكثر من 100 سؤال بسبب عضويتك المجانية</div>';            
             echo'<div class="panel panel-success">
				<div class="panel-heading">طريقة الترقية:</div>
				<div class="panel-body">
                
                <a href="upgrade.php">لترقية العضوية .. اضغط هنا</a>
                
                
                
                </div>
				</div>';
                
                exit(); // Quit the script.   
            
            }
                        
                        
                        
                        
                        
                        




	if ($_SESSION['exam_idd']) {
//echo '  رقم الاختبار  ' . $_SESSION['exam_idd'];
$last_id = $_SESSION['exam_idd'] ; // this is the exam id number


echo'<ol class="breadcrumb" style="margin-bottom: 5px;">
<li ><a href="create_test.php">إنشاء اختبار</a></li>
<li class="active">إضافة أسئلة</li>
<li ><a href="test_control.php?id=' .  $_SESSION['exam_idd'] . '">نشر الاختبار</a></li>
</ol>
<br>';


echo'<div id="logo">
            <h3>إضافة أسئلة الاختبار:  </h3>
            </div>';


}
else
{
	// Finish the page:
			    echo '<center><h1>قم بإضافة الأسئلة من لوحة التحكم ، عن طريق اسم الاختبار المحدد </h1>';
				echo '<a href="teacher.php"><div id="logo">
											<h2>لوحة التحكم من هنا </h2>
											<div></a><br /></center>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.

}
/*
if ($_SESSION['exam_code']) {
echo '  كود الاختبار  ' . $_SESSION['exam_code'];

}
*/






if (isset($_POST['submitted'])) { // Handle the form.

	require_once (MYSQL);

	// define the user
	$u = $_SESSION['user_id'];

	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$qn = $an1 = $an2 = $an3 = $an4 = FALSE;

	// Check for the question:
	if (!empty ($trimmed['question'] ) )
	 {

		$qn = mysqli_real_escape_string ($dbc, $trimmed['question']);
		$qn = trim($qn);
		$qn = htmlspecialchars($qn);
	} else {
			echo '<div class="alert alert-danger">الرجاء ادخل السؤال ۔۔</div>';

	}

	// Check for the answer 1:
	if (!empty ($trimmed['answer1'] ) )
	 {

		$an1 = mysqli_real_escape_string ($dbc, $trimmed['answer1']);
		$an1 = trim($an1);
		$an1 = htmlspecialchars($an1);
	} else {
			echo '<div class="alert alert-danger">الرجاء ادخل الاجابة رقم 1</div>';

	}



	// Check for the answer 2:
	if (!empty ($trimmed['answer2'] ) )
	 {

		$an2 = mysqli_real_escape_string ($dbc, $trimmed['answer2']);
		$an2 = trim($an2);
		$an2 = htmlspecialchars($an2);
	} else {
			echo '<div class="alert alert-danger">الرجاء ادخل الاجابة رقم 2</div>';

	}


	// Check for the answer 3:
	if (!empty ($trimmed['answer3'] ) )
	 {

		$an3 = mysqli_real_escape_string ($dbc, $trimmed['answer3']);
		$an3 = trim($an3);
		$an3 = htmlspecialchars($an3);
	} else {
			echo '<div class="alert alert-danger">الرجاء ادخل الاجابة رقم 3</div>';

	}


	// Check for the answer 4:
		if (!empty ($trimmed['answer4'] ) )
	 {

		$an4 = mysqli_real_escape_string ($dbc, $trimmed['answer4']);
		$an4 = trim($an4);
		$an4 = htmlspecialchars($an4);
	} else {
			echo '<div class="alert alert-danger">الرجاء ادخل الاجابة رقم 4</div>';

	}


	// description
    $d = "";

    /* new description
	$d = mysqli_real_escape_string ($dbc, $trimmed['editor1']);
	$d = htmlspecialchars_decode($d);



    // put the under code after question ادخل السوال


    	<div class="panel-group">
	 <div class="panel panel-info">
		 <div class="panel-heading">
			 <h4 class="panel-title">
				 <a data-toggle="collapse" href="#collapse1">وصف السؤال: ( لإضافة روابط ، صور ، فيديو ، نص  ) .. اضغط هنا</a>
			 </h4>
		 </div>
		 <div id="collapse1" class="panel-collapse collapse">
			 <div class="panel-body">

				 <textarea name="editor1"></textarea>
						 <script>
								 CKEDITOR.replace( 'editor1' );
						 </script>

					 </div>
			 <div class="panel-footer"></div>
		 </div>
	 </div>
 </div>


*/


	$co = $trimmed['correct_answer'];



	if ($qn && $an1 && $an2 && $an3 && $an4) { // If everything's OK...

			// Add the question to the database:
			$q = "INSERT INTO question (exam_id, user_id, question, description, type, answer1, answer2, answer3, answer4, correct_answer) VALUES ('$last_id', '$u', '$qn', '$d',  '1', '$an1', '$an2' ,'$an3', '$an4', '$co' )";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK and the question is succssefully entered.

                     $last_id = mysqli_insert_id($dbc);

			    echo '<div class="alert alert-success">تم إضافة السؤال بنجاح</div>';
				echo '<div class="alert alert-success">قم بإضافة سؤال آخر في النموذج أدناه</div>';
				echo '<br> <br>';



			} else { // If it did not run OK.
				echo '<div class="alert alert-danger">لم تتم إضافة السؤال ، فضلا حاول مرة أخرى</div>';
					}



	} else { // If one of the data tests failed.
		echo '<div class="alert alert-danger">الرجاء ادخال البيانات بالشكل الصحيح</div>';
				}

	mysqli_close($dbc);

} // End of the main Submit conditional.








?>

<br>

<div class="container-fluid">

  <form action="add_question.php" method="post" role="form">

  <div class="panel panel-default">
      <div class="panel-heading">ادخل السؤال :</div>
      <div class="panel-body">
	  <div class="form-group">
      <input type="text" name="question" class="form-control" id="text" placeholder="ادخل السؤال هنا " value="<?php if (isset($trimmed['question'])) echo $trimmed['question']; ?>">
    </div></div>
    </div>




	 <div class="panel panel-default">
      <div class="panel-heading">الاجابات:</div>
      <div class="panel-body">
	  <div class="form-group">
      <input type="text" name="answer1" class="form-control" id="text" placeholder=" الإجابة رقم 1  " value="<?php if (isset($trimmed['answer1'])) echo $trimmed['answer1']; ?>">
    </div>
	 <div class="form-group">
      <input type="text" name="answer2" class="form-control" id="text" placeholder=" الإجابة رقم 2  " value="<?php if (isset($trimmed['answer2'])) echo $trimmed['answer2']; ?>">
    </div>
	 <div class="form-group">
      <input type="text" name="answer3" class="form-control" id="text" placeholder=" الإجابة رقم 3  " value="<?php if (isset($trimmed['answer3'])) echo $trimmed['answer3']; ?>">
    </div>
	<div class="form-group">
      <input type="text" name="answer4" class="form-control" id="text" placeholder="  الإجابة رقم 4 " value="<?php if (isset($trimmed['answer4'])) echo $trimmed['answer4']; ?>">
    </div></div>
    </div>

	 <div class="panel panel-success">
      <div class="panel-heading">الإجابة الصحيحة هي الخيار رقم:</div>
      <div class="panel-body"><input type="radio" name ="correct_answer" value="1" checked > 1
     <br><input type="radio" name ="correct_answer" value="2"  > 2
     <br><input type="radio" name ="correct_answer" value="3"  > 3
     <br><input type="radio" name ="correct_answer" value="4"  > 4
	 </div>
    </div>

    <br>
	<button type="submit" name="submit" class="btn btn-primary btn-lg" >إضافة السؤال</button>
	<input type="hidden" name="submitted" value="TRUE" />

</form>
</div>









</div>
</div>



<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
