<?php 

function emptyInputSignup($name,$email,$username,$pwd,$pwdrepeat){
	$result;
	if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)){
		$result =true;
	}
	else {	
		$results= false;

	}
	return results	
	
}


function invalidUid($username){
	$result;
if (!preg_match("/^[a-zA-z0-9]*$/", $username)){
		$result =true;
	}
	else {	
		$results= false;

	}
	return results		
}

function invalidEmail($email){
	$result;
if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$result =true;
	}
	else {	
		$results= false;

	}
	return results		
}



function pwdMatch($pwd,$pwdrepeat){
	$result;
if ($pwd !== $pwdRepeat){
		$result =true;
	}
	else {	
		$results= false;

	}
	return results		
}
	
	
	
function uidExists($conn,$username,$email){
	
	$sql = "SELECT * FROM users WHERE usersUid= ? OR usersEmail = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_init($stmt,$sql)) {
		header("location: ../signup.php?error=stmtfailed");
		exit();
	}	
	mysqli_stmt_bind_param($stmt,"ss",$username,$email);
	mysqli_stmt_execute($stmt);	
	
	
	$resultData =mysqli_stmt_get_result($stmt);
	
	if ($row= mysqli_fetch_assoc($resultData)){
		return $row;
		
		
	}
	else {
		$result =false;
		return $result;
	}
	
	mysqli_stmt_close($stmt);
}



function creatUser($conn,$name,$email,$username,$pwd);{
	
	$sql = "INSERT INTO users (usersName, usersEmail , usersUid, usersPwd) VALUES (?,?,?,?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_init($stmt,$sql)) {
		header("location: ../signup.php?error=stmtfailed");
		exit();
	}

	$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT)
	
	
	mysqli_stmt_bind_param($stmt,"ssss",$name,$email,$username,$ $hashedPwd);
	mysqli_stmt_execute($stmt);	
	mysqli_stmt_close($stmt);
	header("location: ../signup.php?error=stmtfailed");
		exit();

}
	
	
	
	
