<?php
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
?>

<?php
function Redirect_to($New_Location){
	header("Location:".$New_Location);
	exit;
}

function Login_Attempt($Username,$Password){
	 $Connection=mysqli_connect('localhost','root','');
	$ConnectingDB=mysqli_select_db($Connection,'phpcms');
	$Query="SELECT * FROM registraition WHERE username='$Username' AND password='$Password'";
	$Execute=mysqli_query( $Connection,$Query);
	if ($admin=mysqli_fetch_assoc($Execute)) {
		return $admin;
	}else{
		return null;
	}

}

function Login(){
	if (isset($_SESSION["User_Id"])) {
		return true;
	}
}
function Confirm_Login(){
	if (!Login()) {
		$_SESSION["ErrorMessage"]="Login Required !";
		Redirect_to("Login.php");
	}
}

?>