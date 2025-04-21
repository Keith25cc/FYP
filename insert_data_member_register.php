<?php
	//take the database connection codes to here from connect_database.php
	include("connect_database.php");

		//query of insert data
		$insert_sql="INSERT INTO member_info (first_name, last_name, gender, email, nric, username, phone_number, account_balance, password)
		
		VALUES
		
		('$_POST[register_member_first_name]','$_POST[register_member_last_name]','$_POST[register_member_gender]','$_POST[register_member_email]',
		'$_POST[register_member_nric]','$_POST[register_member_username]','$_POST[register_member_phone_number]',
		'$_POST[register_member_account_balance]','$_POST[register_member_password]')";

	//find repeated phone number
	$register_member_phone_number = $_POST['register_member_phone_number'];

	$phone_number_sql = mysqli_query($conn, 
	"SELECT phone_number
	FROM member_info
	WHERE phone_number = '$register_member_phone_number'");

	//find repeated email
	$register_member_email = $_POST['register_member_email'];

	$email_sql = mysqli_query($conn, 
	"SELECT email
	FROM member_info
	WHERE email = '$register_member_email'");

	//find repeated username
	$register_member_username = $_POST['register_member_username'];

	$username_sql = mysqli_query($conn, 
	"SELECT username
	FROM member_info
	WHERE username = '$register_member_username'");
	
	if (mysqli_num_rows($phone_number_sql) > 0) {
		echo
		'<script>
			alert("Phone Number Exists, Please Enter Another Phone Number.");
			history.go(-1);
		</script>';
		die();
	}
	else if (mysqli_num_rows($email_sql) > 0) {
		echo
		'<script>
			alert("Email Exists, Please Enter Another Email.");
			history.go(-1);
		</script>';
		die();
	}
	else if (mysqli_num_rows($username_sql) > 0) {
		echo
		'<script>
			alert("Username Exists, Please Enter Another Username.");
			history.go(-1);
		</script>';
		die();
	}
	else {
		mysqli_query($conn,$insert_sql);
		echo
		'<script>
			alert("Register Successfully!");
			window.location.href = "member_login.php";
		</script>';
	}
	
	//close database connection
	mysqli_close($conn);
?>