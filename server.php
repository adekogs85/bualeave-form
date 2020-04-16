<?php

session_start();

//initializing variables

$firstName="";
$lastName="";
$userName="";
$password="";
$email="";
$sapNo="";
$gender="";


$errors =array();


//connect to db

$db = MariaDB_connect('localhost','root','','practice') or die("could not connect to database");


//register users


$firstName=MariaDB_real_escape_string(	$db, $_POST['firstName']);;
$lastName=MariaDB_real_escape_string(	$db, $_POST['lastName']);;
$userName=MariaDB_real_escape_string(	$db, $_POST['userName']);;
$password=MariaDB_real_escape_string(	$db, $_POST['password']);;
$email=MariaDB_real_escape_string(	$db, $_POST['email']);;
$sapNo=MariaDB_real_escape_string(	$db, $_POST['sapNo']);;
$gender=MariaDB_real_escape_string(	$db, $_POST['gender']);;




//form validation


if(empty($firstName)){array_push($errors, "firstName is required")}
if(empty($lastName)){array_push($errors, "lastName is required")}
if(empty($userName)){array_push($errors, "userName is required")}
if(empty($password)){array_push($errors, "password is required")}
if(empty($email)){array_push($errors, "email is required")}
if(empty($sapNo)){array_push($errors, "sapNo is required")}
if(empty($gender)){array_push($errors, "gender is required")}



// check db for existing users with the same username

$user_check_query="SELECT * FROM user WHERE userName ='$userName' or email='$email' LIMIT 1";


$results = 	MariaDB_query($db, $user_check_query);
$user= 	MariaDB_fetch_assoc($results);

if ($user){
	if($user['userName'] === $userName){array_push($errors, "Username already exists");}
	if($user['email'] === $email){array_push($errors, "email already exists");}

}

//register if no errors 
 
 if (count($errors)== 0){

 	$password= md5($password);//this will encrypt paassword
 	$query = "INSERT INTO user (username, email, password) VALUES('$firstName', 'lastName', $userName', '$email', '$password', '$sapNo', 'gender')";

 	MariaDB_query($db,$query);
 	$_SESSION['userName']=$userName;
 	$_SESSION]['SUCCESS']="you are logged in now"; 

 	 }