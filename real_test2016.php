<?php 

// Include the configuration file:
require_once ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'اختبر - الاختبار الفعلي';
include ('includes/header.html');

?>

<style>
			.container {
				margin-top: 110px;
			}
			.error {
				color: #B94A48;
			}
			.form-horizontal {
				margin-bottom: 0px;
			}
			.hide{display: none;}
		</style>
		
		<?php

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['fullname']) or ($_SESSION['user_level'] != 2))  
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
	include ('includes/student_menu.php'); 

	$eid = $_SESSION['exam_id2'];
	
	
	require_once (MYSQL);
			
			

?>


<div class="container question">
			<div class="col-xs-12 col-sm-8 col-md-8 col-xs-offset-4 col-sm-offset-3 col-md-offset-3">
				<p>
					Responsive Quiz Application Using PHP, MySQL, jQuery, Ajax and Twitter Bootstrap
				</p>
				<hr>
				<form class="form-horizontal" role="form" id='login' method="post" action="result2.php">
					<?php 
					$q= "SELECT question_id, exam_id, question, answer1, answer2, answer3, answer4, correct_answer from question WHERE exam_id='$eid' ORDER BY RAND()";
					$res = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
                    $rows = mysqli_num_rows($res);
					$i=1;
                while($result=mysqli_fetch_array($res)){?>
                    
                    
                    <?php if($i==1){?>         
                    <div id='question<?php echo $i;?>' class='cont'>
                    <p class='questions' id="qname<?php echo $i;?>"> <?php echo $i?>.<?php echo $result['question'];?></p>
                    <input type="radio" value="1" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer1'];?>
                   <br/>
                    <input type="radio" value="2" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer2'];?>
                    <br/>
                    <input type="radio" value="3" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer3'];?>
                    <br/>
                    <input type="radio" value="4" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer4'];?>
                    <br/>
                    <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/>                                                                      
                    <br/>
                    <button id='<?php echo $i;?>' class='next btn btn-success' type='button'>Next</button>
                    </div>     
                      
                     <?php }elseif($i<1 || $i<$rows){?>
                     
                       <div id='question<?php echo $i;?>' class='cont'>
                    <p class='questions' id="qname<?php echo $i;?>"><?php echo $i?>.<?php echo $result['question'];?></p>
                    <input type="radio" value="1" id='rad
					
					
					
					
					
					
					
					io1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer1'];?>
                    <br/>
                    <input type="radio" value="2" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer2'];?>
                    <br/>
                    <input type="radio" value="3" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer3'];?>
                    <br/>
                    <input type="radio" value="4" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer4'];?>
                    <br/>
                    <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/>                                                                      
                    <br/>
                    <button id='<?php echo $i;?>' class='previous btn btn-success' type='button'>Previous</button>                    
                    <button id='<?php echo $i;?>' class='next btn btn-success' type='button' >Next</button>
                    </div>
                       
                       
                       
                        
                        
                   <?php }elseif($i==$rows){?>
                    <div id='question<?php echo $i;?>' class='cont'>
                    <p class='questions' id="qname<?php echo $i;?>"><?php echo $i?>.<?php echo $result['question'];?></p>
                    <input type="radio" value="1" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer1'];?>
                    <br/>
                    <input type="radio" value="2" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer2'];?>
                    <br/>
                    <input type="radio" value="3" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer3'];?>
                    <br/>
                    <input type="radio" value="4" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/><?php echo $result['answer4'];?>
                    <br/>
                    <input type="radio" checked='checked' style='display:none' value="5" id='radio1_<?php echo $result['question_id'];?>' name='<?php echo $result['question_id'];?>'/>                                                                      
                    <br/>
                    
                    <button id='<?php echo $i;?>' class='previous btn btn-success' type='button'>Previous</button>                    
                    <button id='<?php echo $i;?>' class='next btn btn-success' type='submit'>Finish</button>
                    </div>
					<?php } $i++;} ?>
					
				</form>
			</div>
		</div>
		
		


</div>
</div>
</div>
<?php // Include the HTML footer file:
include ('includes/footer.html');
?>