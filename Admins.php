<?php 
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
   require_once("Include/Functions.php");
 ?>
  <?php echo Confirm_Login();   ?>
 <?php 
if (isset($_POST["Submit"])) {

    $Connection=mysqli_connect('localhost','root','');
	$ConnectingDB=mysqli_select_db($Connection,'phpcms');

	$Username=mysqli_real_escape_string($Connection,$_POST["Username"]);
  $Password=mysqli_real_escape_string($Connection,$_POST["Password"]);
  $ConfirmPassword=mysqli_real_escape_string($Connection,$_POST["ConfirmPassword"]);
   date_default_timezone_set("Asia/Kolkata");
   $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
  $DateTime;
$Admin="Sourabh";
  if (empty($Username)||empty($Password)||empty($ConfirmPassword)) {
  	$_SESSION["ErrorMessage"]="All Fields must be filled out";
  	Redirect_to("Categories.php");
  	
  }elseif (strlen($Password)<4) {
     $_SESSION["ErrorMessage"]="Atleast 4 characters are required for password";
  	Redirect_to("Admins.php");
  }elseif ($Password!==$ConfirmPassword) {
         $_SESSION["ErrorMessage"]="Password / ConfirmPassword does not match";
    Redirect_to("Admins.php");
  }
  else{

  $Connection=mysqli_connect('localhost','root','');
	$ConnectingDB=mysqli_select_db($Connection,'phpcms');
      
      $Query="INSERT INTO registraition(datetime,username,password,addedby)VALUES('$DateTime','$Username','$Password','$Admin')";
      $Execute=mysqli_query($Connection,$Query);
      if ($Execute) {
      	  $_SESSION["SuccessMessage"]="Admin added successfully";
  	      Redirect_to("Admins.php");
         
      }else{
      	 $_SESSION["ErrorMessage"]="New admin failed to add";
  	      Redirect_to("Admins.php");
         
      }

  }


}

  ?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/adminstyles.css">
</head>
<body>

<nav class=" navbar-inverse" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>   
      <a class="navbar-brand" href="Blog.php">
        <img style="margin-top: -12px;" src="images/Capture.png" width=180; height=40 >
      </a>
    </div>
    <div class="collapse navbar-collapse" id="collapse">
      <span class="navbar-form navbar-right">
        <a href="Blog.php"><button class="btn btn-default">Go to Blog</button></a> 
      </span>
    </div>
  </div>
</nav>
<hr style="margin: 0;">
  

	<div class="container-fluid" >
		<div class="row">

			<div class="col-sm-2">
					<br><br>
				<ul id="Side_Menu" class="nav nav-pills nav-stacked">
					<li ><a href="Dashbord.php"><span class="glyphicon glyphicon-th"></span>&nbsp;Dashbord</a></li>
					<li><a href="AddNewPost.php"> <span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li> 
					<li ><a href="Categories.php"> <span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
					<li class="active"><a href="Admins.php"> <span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
					<li><a href="Comments.php"> <span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
					<li><a href="Blog.php"><span class="glyphicon glyphicon-list"></span>&nbsp;Live Blog</a></li>
					<li><a href="Logout.php"> <span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
					

				</ul>			
			</div>
			<!-- end side areaa -->

			<div class="col-sm-10">
				<h1>Manage Admin Access</h1>
    			<?php echo Message(); 
                      echo SuccessMessage();
				 ?>


    			<div>
    				<form action="Admins.php" method="post">
    					<fieldset>
    						<div class="form-group">
                <div class="col-sm-2" id="padding20">
    							<label for="username">Username:</label><br>
                  </div>
                  <div class="col-sm-10" id="padding20">
    							<input class="form-control" type="text" name="Username" id="username" placeholder="username">
                </div>
                </div>
                  
                    <div class="form-group">
                  <div class="col-sm-2" id="padding20">
                  <label for="Password">Password:</label><br>
                  </div>
                  <div class="col-sm-10" id="padding20">
                  <input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
                </div></div>
                  
                    <div class="form-group">
                    <div class="col-sm-2" id="padding20">
                  <label for="categoryname">Confirm Password:</label><br>
                  </div>
                  <div class="col-sm-10" id="padding20">
                  <input class="form-control" type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Re type same password">
                  </div>
                </div>
                  <br>
                  <div class="col-sm-offset-2 col-sm-10" id="padding20">
                 <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Admin">
                 </div>
                 <br><br>
    					</fieldset>
					    					



    				</form>
    			</div>

          <br>
          <br>
    			<div class="table-responsive">
    				<table class="table table-striped table-hover">
    					<tr>
    						<th>Sr No.</th>
    						<th>Date Time</th>
    						<th> Admin Name</th>
    						<th>Added by</th>
                <th>Action</th>
    					</tr>
    				<?php 
    				 global $ConnectingDB;
    				$ViewQuery="SELECT * FROM registraition ORDER BY id desc";
    				$Execute=mysqli_query($Connection,$ViewQuery);
                     
                    $SrNo=0;

    				while ($DataRows=mysqli_fetch_array($Execute)) {
    					
    					$Id=$DataRows["id"];
    					$DateTime=$DataRows["datetime"];
    					$Username=$DataRows["username"];
    					$Admin=$DataRows["addedby"];
    					$SrNo++;

    				?>
    				<tr>
    					<td><?php echo $SrNo;  ?></td>
    					<td><?php echo $DateTime;  ?></td>
    					<td><?php echo $Username;  ?></td>
    					<td><?php echo $Admin;  ?></td>
              <td><a href="AdminDelete.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a></td>
    				</tr>

    				
    			<?php } ?>	
    					
    				</table>
    			</div>

				
			</div><!-- ending main arear -->
			
		</div><!-- ending of row -->
		
	</div><!-- ending of container -->


  <div style="height: 250px; background: #27aae1;"></div>
  <div id="Footer">
    <p>copyright @ 2018-2019 Contineous</p>
    <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold; " href="#">By Sourabh Kumrawat</a>
  </div>

</body>
</html> 