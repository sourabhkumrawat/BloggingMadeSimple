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


$Title=mysqli_real_escape_string($Connection,$_POST["Title"]);
	$Category=mysqli_real_escape_string($Connection,$_POST["Category"]);
  $Post=mysqli_real_escape_string($Connection,$_POST["Post"]);

   date_default_timezone_set("Asia/Kolkata");
   $CurrentTime=time();
  /*$DateTime=strftime("%Y-%m-%d %H:%M:%S",$CurrentTime);*/
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
  $DateTime;
$Admin=$_SESSION["Username"];
$Image=$_FILES["Image"]["name"];
$Target="Upload/".basename($_FILES["Image"]["name"]);
  if (empty($Title)) 
  {
  	$_SESSION["ErrorMessage"]="Title can not be empty";
  	Redirect_to("AddNewPost.php");
  }
  elseif (strlen($Title)<5) 
  {
    $_SESSION["ErrorMessage"]="Title Should be at-least 5 Characters";
  	Redirect_to("AddNewPost.php");
  }
  else
  {
    $Connection=mysqli_connect('localhost','root','');
  	$ConnectingDB=mysqli_select_db($Connection,'phpcms');

    $Query="INSERT INTO admin_panel(datetime,title,category,author,image,post)VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
    $Execute=mysqli_query($Connection,$Query);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if ($Execute) 
    {
      	 $_SESSION["SuccessMessage"]="post added successfully";
  	     Redirect_to("AddNewPost.php");  
    }
    else
    {
      	 $_SESSION["ErrorMessage"]="Somthing weng worng try agian";
  	      Redirect_to("AddNewPost.php");
    }

  }


}

  ?>

<!DOCTYPE html>
<html>
<head>
	<title>AddNewPost</title>
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
					<li ><a href="Dashbord.php">
                    <span class="glyphicon glyphicon-th"></span>&nbsp;Dashbord</a></li>
					<li class="active"><a href="AddNewPost.php"> <span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li> 
					<li ><a href="Categories.php"> <span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
					<li><a href="Admins.php"> <span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
					<li><a href="Comments.php"> <span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
					<li><a href="Blog.php"><span class="glyphicon glyphicon-list"></span>&nbsp;Live Blog</a></li>
					<li><a href="Logout.php"> <span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
					

				</ul>			
			</div>
			<!-- end side areaa -->

			<div class="col-sm-10">
				<h1>Add New Post</h1>
    			<?php echo Message(); 
              echo SuccessMessage();
				 ?>


    			<div>
    				<form action="AddNewPost.php" method="post" enctype="multipart/form-data">
    					<fieldset>
    						<div class="form-group">
                  <div class="col-sm-2" id="padding20">
    							   <label for="title">Title:</label>
                  </div>
                  <div class="col-sm-10" id="padding20">
    							   <input class="form-control" type="text" name="Title" id="title" placeholder="Title">
                  </div>
                </div>
                            
                <div class="form-group">
                  <div class="col-sm-2" id="padding20">
                    <label for="categoryselect">Category:</label> 
                  </div>
                  <div class="col-sm-10"  id="padding20">
                   <select class="form-control" id="categoryselect" name="Category">
                    <?php 
                      global $ConnectingDB;
                      $ViewQuery="SELECT * FROM category ORDER BY datetime desc";
                      $Execute=mysqli_query($Connection,$ViewQuery);
                      while ($DataRows=mysqli_fetch_array($Execute)) {      
                        $Id=$DataRows["id"];            
                        $CategoryName=$DataRows["name"];
                   ?> 
                        <option><?php echo $CategoryName; ?></option>
                    <?php } ?>
                   </select>
                    </div>
                  </div>

                  <div class="form-group">
                  <div class="col-sm-2" id="padding20">
                    <label for="imageselect">Select Image:</label>
                  </div>
                  <div class="col-sm-10" id="padding20">
                    <input type="File" class="form-control" name="Image" id="imageselect">
                  </div>
                  </div>
                  <div class="form-group">
                  <div class="col-sm-2" id="padding20">
                    <label for="postarea">Post:</label>
                  </div>
                  <div class="col-sm-2" id="padding20" >
                    <textarea class="form-control" name="Post" id="postarea"></textarea>
                  </div>
                  </div>
                  <br>
                    <div class="col-sm-offset-2 col-sm-10" id="padding20">
                      <input class="btn btn-success btn-block" type="Submit" name="Submit" value="Add New Post">
                    </div>
    					</fieldset>
						<br>    					



    				</form>
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