<?php
                      
                        require '../../../database/dbcon.php';
                            
                            $query = "SELECT * FROM system  ";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $student = mysqli_fetch_array($query_run);
                                ?><?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        
?>
<?php
//send_mail.php


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
include '../../../database/config1.php';
if(isset($_POST['email_data']))
{
	require 'class/class.phpmailer.php';
	$output = '';
	foreach($_POST['email_data'] as $row)
	{	
		$student_id = $row["name"];
		$query1 = "SELECT * FROM students WHERE id='$student_id'";
		$query_run1 = mysqli_query($conn, $query1);
		$student1 = mysqli_fetch_array($query_run1);
		$fname = $student1['fname'];
		$lname = $student1['lname'];
		$mname = $student1['mname'];
		$app1 = $student1['applicant_id'];

		$text = "Hello! $lname, $fname $mname.";
		$app = "$app1";

		$mail = new PHPMailer;
		$mail->IsSMTP();								//Sets Mailer to send message using SMTP
		$mail->Host       = 'smtp.gmail.com'; 		//Sets the SMTP hosts of your Email hosting, this for Godaddy
		$mail->Port       = 465;								//Sets the default SMTP server port
		$mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
		$mail->Username = ($student['email_user']);					//Sets SMTP username
		$mail->Password   = ($student['email_pass']);					//Sets SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                 							//Sets connection prefix. Options are "", "ssl" or "tls"
		$mail->From = ($student['email_user']);			//Sets the From email address for the message
		$mail->FromName = ($student['email_name']);					//Sets the From name of the message
		$mail->AddAddress($row["email"]);	//Adds a "To" address
		$mail->WordWrap = 50;							//Sets word wrapping on the body of the message to a given number of characters
		$mail->IsHTML(true);							//Sets message type to HTML
		$mail->Subject = 'MCC Guidance Office Form'; //Sets the Subject of the message
		//An HTML or plain text message body

		$domain = $student['domain'];
		$step = "$domain/guidance-step/index.php?applicant_id=$app";
		$mail->Body = "<h2>$text</h2><p>Madridejos Community College accepted your pre enrollement request. Here is your applicant number</p><h3>Applicant Number: $app </h3><br>
		To procced your enrollment. Please fill-up with this form. Link below. <br>
		$step
		<br>
		<br> NOTE: Please secure a copy of your Applicant Number. Thank You.";

		$mail->AltBody = '';

		$result = $mail->Send();						//Send an Email. Return true on success or false on error

		if($result)
		{
			$output .= html_entity_decode($result);

		}

	}
	if($output)
	{
		echo 'ok';
		foreach($_POST['email_data'] as $rows){
		$email=$rows["name"];
		$code = 'Accept_form';
		$query = mysqli_query($conn, "UPDATE students SET status_type='$code' WHERE id='$email'");
		}
	}
	else
	{
		echo 'Error Sending Mail';
	}
}

	
?>