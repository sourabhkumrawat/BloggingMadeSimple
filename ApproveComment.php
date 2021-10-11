<?php 
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
   require_once("Include/Functions.php");
 ?>
  <?php echo Confirm_Login();   ?>
<?php
if (isset($_GET["id"])) {
   $IdFromURL=$_GET["id"];
   $Admin=$_SESSION["Username"];
   $ConnectingDB;
   $Query="UPDATE comments SET status ='ON',Approvedby='$Admin' WHERE id='$IdFromURL'";
   $Execute=mysqli_query($Connection,$Query);
   if ($Execute) {
      $_SESSION["SuccessMessage"]="Comment Approved Successfull";
      Redirect_to("Comments.php");

   }else{
   	$_SESSION["ErrorMessage"]="Something went Wrong.";
   	 Redirect_to("Comments.php");
   }

}
?>