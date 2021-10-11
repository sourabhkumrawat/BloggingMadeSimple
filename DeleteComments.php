<?php 
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
   require_once("Include/Functions.php");
 ?>
  <?php echo Confirm_Login();   ?>
<?php
if (isset($_GET["id"])) {
   $IdFromURL=$_GET["id"];
   $ConnectingDB;
   $Query="DELETE FROM comments WHERE id='$IdFromURL'";
   $Execute=mysqli_query($Connection,$Query);
   if ($Execute) {
      $_SESSION["SuccessMessage"]="Comment deleted Successfull";
      Redirect_to("Comments.php");

   }else{
   	$_SESSION["ErrorMessage"]="Something went Wrong.";
   	 Redirect_to("Comments.php");
   }

}
?>