<?php

	$email = $_POST['email'];
	$uname = $_POST['name'];
	$userid = $_POST['userid'];
	$picture = $_POST['picture'];
	$city = $_POST['city'];
	$profile_url = $_POST['link'];
	$locale= $_POST['locale'];
	$sex = $_POST['gender'];

	$ip = get_client_ip();
	$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
	$citybyip= $details->city;




	$con =mysqli_connect('127.0.0.1', 'root', '', 'mysql');
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: ".mysqli_connect_error();
	}
	$sql2 = "INSERT INTO user_record (id,name,email,picture) VALUES('".$userid."','".$uname."','".$email."','".$picture."')";
	if (!mysqli_query($con,$sql2))
	{
		//die('Error: ' . mysqli_error($con));
	}
	
	$sql3 = "INSERT INTO user_profile_info (uid,name,sex,locale,profile_url,login_city) VALUES('".$userid."','".$uname."','".$sex."','".$locale."','".$profile_url."','".$city."')";

	if (!mysqli_query($con,$sql3))
        {
	//	die('Error: ' . mysqli_error($con));
        }
	
	$time = date("D M d, Y G:i");
	$sql4 = "INSERT INTO user_stat (id,username,login,city,ip) VALUES('".$userid."','".$uname."','".$time."','".$citybyip."','".$ip."')";
        if (!mysqli_query($con,$sql4))
        {
                die('Error: ' . mysqli_error($con));
        }

	function get_client_ip()
	{
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if($_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if($_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if($_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
	return $ipaddress; 
	}


?>


