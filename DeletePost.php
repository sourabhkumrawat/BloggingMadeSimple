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
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
  $DateTime;
$Admin="Nandkishor Dhangar";
$Image=$_FILES["Image"]["name"];
$Target="Upload/".basename($_FILES["Image"]["name"]);
 

  global $ConnectingDB;
  $DeleteFromURl=$_GET['Delete'];
  $Query="DELETE FROM admin_panel WHERE id='$DeleteFromURl'";
      
      $Execute=mysqli_query($Connection,$Query);
      move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
      if ($Execute) {
      	  $_SESSION["SuccessMessage"]="post Deleted successfully";
  	      Redirect_to("dashbord.php");
         
      }else{
      	 $_SESSION["ErrorMessage"]="Somthing weng worng try agian";
  	      Redirect_to("dashbord.php");
         
      }

  


}

  ?>

<!DOCTYPE html>
<html>
<head>
	<title>Delete Post</title>
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
					<li ><a href="#"> <span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
					<li><a href="#"> <span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
					<li><a href="#"> <span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-list"></span>&nbsp;Live Blog</a></li>
					<li><a href="#"> <span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
					

				</ul>			
			</div>
			<!-- end side areaa -->

			<div class="col-sm-10">
        <?php echo Message(); 
          echo SuccessMessage();
        ?>

				<h1>Delete Post</h1>
    		<div>
          <?php
            $ConnectingDB;
            $SearchQueryParameter=$_GET['Delete']; 
            $Query="SELECT * FROM admin_panel WHERE id='$SearchQueryParameter'";
            $ExecuteQuery=mysqli_query($Connection,$Query);
            while ($DataRows=mysqli_fetch_array($ExecuteQuery)) 
            {
              $TitleToBeUpdated=$DataRows['title'];
              $CategoryToBeUpdated=$DataRows['category'];
              $ImageToBeUpdated=$DataRows['image'];
              $PostToBeUpdated=$DataRows['post'];
            }
          ?>
          <form action="DeletePost.php?Delete=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
    				<fieldset>

    					<div class="form-group">
                <div class="col-sm-2">
      						<label disabled for="title">Title:</label><br>
                </div>
                <div class="col-sm-10">
      						<input disabled class="form-control" type="text" name="Title" value="<?php echo $TitleToBeUpdated; ?>" id="title" placeholder="Title">
                </div><br>
              </div><br>
                            
              <div class="form-group">
                <div class="col-sm-2">
                  <span style="font-weight: bold;">Category: </span>
                </div>
                <div class="col-sm-10">
                  <input disabled class="form-control" id="categoryselect" name="Category" value="<?php echo $CategoryToBeUpdated; ?>">
                </div><br>
              </div><br>

              <div class="form-group">
                <div class="col-sm-2">
                  <span style="font-weight: bold;">Thumbnail: </span>
                </div>
                <div class="col-sm-10">
                  <img src="Upload/<?php echo  $ImageToBeUpdated; ?>" width=200px; height=100px;><br>
                </div><br>
              </div><br>

              <div class="form-group">
                <div class="col-sm-2" id="padding20">
                  <label for="postarea">Post:</label>
                </div>
                <div class="col-sm-10" id="padding20">
                  <textarea disabled class="form-control" name="Post" id="postarea"><?php echo $PostToBeUpdated; ?></textarea>
                </div><br>
              </div><br>
              <br>
              <div class="col-sm-offset-2 col-sm-10" id="padding20">
              <input class="btn btn-danger btn-block" type="Submit" name="Submit" value="Delete Post">

    				</fieldset>
						<br>    					
    			</form>
    		</div>

			</div>
		</div>
	</div>


  <div style="height: 250px; background: #27aae1;"></div>
  <div id="Footer">
    <p>copyright @ 2018-2019 Contineous</p>
    <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold; " href="#">By Sourabh Kumrawat</a>
  </div>

</body>
</html> 