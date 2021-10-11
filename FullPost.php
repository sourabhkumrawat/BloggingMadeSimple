<?php 
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
   require_once("Include/Functions.php");
 ?>
 
  <?php 
  global $ConnectingDB;
if (isset($_POST["Submit"])) {
$Name=mysqli_real_escape_string($Connection,$_POST["Name"]);
$Email=mysqli_real_escape_string($Connection,$_POST["Email"]);
$Comment=mysqli_real_escape_string($Connection,$_POST["Comment"]);

   date_default_timezone_set("Asia/Kolkata");
   $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
  $DateTime;
  $PostId=$_GET["id"];

  if (empty($Name)||empty($Email)||empty($Comment)) {
  	$_SESSION["ErrorMessage"]="All fields are required";
 
  	
  }elseif (strlen($Comment)>500) {
     $_SESSION["ErrorMessage"]="Comment should be less 500 charecters.";
  	
  }
  else{

 global $ConnectingDB;
   $PostIDFromURL=$_GET['id'];
 $Query="INSERT into comments(datetime,name,email,comment,Approvedby,status,admin_panel_id)VALUES('$DateTime','$Name','$Email','$Comment','pending','OFF','$PostIDFromURL')";
      
      
      $Execute=mysqli_query($Connection,$Query);
      
      if ($Execute) {
      	  $_SESSION["SuccessMessage"]="Comment added successfully";
  	      Redirect_to("FullPost.php?id={$PostId}");
         
      }else{
      	 $_SESSION["ErrorMessage"]="Somthing weng worng try agian";
  	       Redirect_to("FullPost.php?id={$PostId}");
      }
  }
}

  ?>
<!DOCTYPE html>
<html>
<head>
	<title>Full Blog Post</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/publicstyles.css">
	<style type="text/css">
		
		
		.FieldInfo{
			color: rgb(174,44,50);
			font-family: Bitter,Georgia."Times New Roman",Times,serif;
			font-size: 1.2em;
		}
		.CommentBlock{
			background-color: #f6f7f9;
		}
		.Comment-info{
			color: #365899;
			font-family: sans-serif;
			font-size: 1.1em;
			font-weight: bold;
			padding-top: 10px;

		}
		.Comment{
			margin-top: -2px;
            padding-bottom: 10px;
            font-size: 1.1em;
		}
    .btn-default{
      margin: 5px;
      border: 1px #17202A solid;
    }
    .panel-heading{
      color: #f5f5f5;
      background: #17202A;
    }
    .snav{
      margin-top:-17px;
      background: #ddd;
      border-bottom: #17202A 1px solid;
    }
    #heading{
      padding-right: 20px;
    }
    .imgabt{
      border: #17202A 2px Solid;
      border-radius: 50%;
    }
	</style>
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>   
      <a class="navbar-brand" href="Blog.php">
        <img style="margin-top: -8px;" src="images/Capture.PNG" width=170; height=40 >
      </a>
    </div>
    <div class="collapse navbar-collapse" id="collapse">
    <ul class="nav navbar-nav">

      <li><a href="#"><span class="glyphicon glyphicon-home"></span>&nbsp; Home</a></li>
      <li><a class="active" href="Blog.php"><span class="glyphicon glyphicon-book"></span>&nbsp; Blog</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span>&nbsp; About Us</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-briefcase"></span>&nbsp; Services</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-earphone"></span>&nbsp; Contact</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-flag"></span>&nbsp; Feature</a></li>
      
    </ul>
    <form action="Blog.php" class="navbar-form navbar-right">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search" name="Search">
        <span class="input-group-btn">
        <button type="button" class="btn btn-info" name="SearchButton"><span class="glyphicon glyphicon-search"></span></button>
        </span>
      </div>
    </form>
    </div>
  </div>
</nav>

<div class="navbar-primary snav panel-footer" role="navigation">
  <div class="container">
    <div class="collapse navbar-collapse" id="collapse">
    <ul class="nav navbar-nav">
    <span style="font-size: 20px; font-weight: bold; color: #000; padding-right: 30px;"> Categories</span>
      <?php
        global $ConnectingDB;
        $ViewQuery="SELECT * FROM category ORDER BY datetime desc";
        $Execute=mysqli_query($Connection,$ViewQuery);
        while ($DataRows=mysqli_fetch_array($Execute)) 
        {
          $id=$DataRows['id'];
          $Category=$DataRows['name'];
        ?>
          <span class="btn btn-default">
            <a href="Blog.php?Category=<?php echo $Category; ?>">
              <span id="heading">
                <?php echo $Category; ?>
              </span>
            </a>
          </span>
        <?php } ?>
    </ul>
    </div>
  </div>
</div>

<div class="container">

  <div class="row"> <!--Row-->
    <div class="col-sm-8"><!--Main Blog Area-->
    	<?php echo Message(); 
        echo SuccessMessage();
		  ?>
    	<?php 
        global $ConnectingDB;
        if(isset($_GET["SearchButton"]))
        {
          $Search=$_GET["Search"];
          $ViewQuery="SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%' ";
        }
        else
        {
          $PostIDFromURL=$_GET["id"];
          $ViewQuery="SELECT * FROM admin_panel WHERE id='$PostIDFromURL' ORDER BY datetime desc"; 
        }
        $Execute=mysqli_query($Connection,$ViewQuery);
        while ($DataRows=mysqli_fetch_array($Execute))
        {
        	$PostId=$DataRows["id"];
        	$DateTime=$DataRows["datetime"];
        	$Title=$DataRows["title"];
        	$Category=$DataRows["category"];
        	$Admin=$DataRows["author"];
        	$Image=$DataRows["image"];
        	$Post=$DataRows["post"];       
  	     ?>

          <div class="caption">
            <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
            <p class="description">Category:<?php echo htmlentities($Category); ?> Published on <?php echo htmlentities($DateTime); ?> </p>
          </div>
          <div class="blogpost thumbnail">
  		      <img class="img-responsive img-rounded"  src="Upload/<?php echo $Image; ?>">
            <div style=" height: 20px;"></div>
            <div class="caption">
    		      <p class="post"><?php echo nl2br($Post); ?></p>
            </div>
  	      </div>	
        <?php } ?><br><br>
        <span class="FieldInfo">Comments</span><br><br>
        <?php 
        $ConnectingDB;
        $PostIdForComment=$_GET['id'];
        $ExtractingCommentQuery="SELECT * FROM comments WHERE admin_panel_id='$PostIdForComment' AND status='ON'";
        $Execute=mysqli_query($Connection,$ExtractingCommentQuery);
        while ($DataRows=mysqli_fetch_array($Execute)) 
        {
        	$CommentDate=$DataRows["datetime"];
        	$CommenterName=$DataRows["name"];
        	$Comments=$DataRows["comment"];
         ?>
          <div class="CommentBlock">
	            <img class="pull-left" src="images/comment.png" width=70px; height=70px;>
	            <p style="margin-left: 90px;" class="Comment-info"><?php echo $CommenterName;  ?></p>
     	      <p style="margin-left: 90px;" class="description"><?php echo $CommentDate;  ?></p>
     	      <p style="margin-left: 90px;" class="Comment" ><?php echo nl2br($Comments);  ?></p>
          </div>
          <hr>
        <?php } ?>

        <span class="FieldInfo ">Share your thoughts about this post</span><br><br>
        <div>
  				<form action="FullPost.php?id=<?php echo $PostId; ?>" method="post" enctype="multipart/form-data">
  					<fieldset>
  						<div class="form-group">
  							<label for="Name" class="FieldInfo">Name:</label><br>
  							<input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
              </div>
              <div class="form-group">
  							<label for="Email" class="FieldInfo">Email:</label><br>
  							<input class="form-control" type="Email" name="Email" id="Email" placeholder="Email">
              </div>
              <div class="form-group">
                 <label for="commentarea" class="FieldInfo">Comment:</label>
                 <textarea class="form-control" name="Comment" id="commentarea"></textarea>
              </div>                  
              <br>
              <input class="btn btn-primary btn-" type="Submit" name="Submit" value="Submit">
  					</fieldset>
					  <br>    					
  				</form>
  			</div>
    </div><!--Main blog area end-->
    <div class="col-sm-offset-1 col-sm-3"><!--Side area-->
  		<h2>About me</h2>

      <img class="img-responsive imageicon imgabt" src="images/comment.png">

      <p>Add-ons are small apps you can add to Firefox that do lots of things — from managing to-do lists, to downloading videos, to changing the look of your browser.Add-ons are small apps you can add to Firefox that do lots of things — from managing to-do lists, to downloading videos, to changing the look of your browser.Add-ons are small apps you can add to Firefox that do lots of things — from managing to-do lists, to downloading videos, to changing the look of your browser.</p>



      <div class="panel panel-primary">
        <div class="panel-heading">
          <h2 class="panel-title">Recent Post</h2>
        </div>
        <div class="panel-body background">
          <?php  
            $ConnectingDB;
            $ViewQuery="SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
            $Execute=mysqli_query($Connection,$ViewQuery);
            while ($DataRows=mysqli_fetch_array($Execute)) 
            {
              $Id=$DataRows["id"];
              $Title=$DataRows["title"];
              $DateTime=$DataRows["datetime"];
              $Image=$DataRows["image"];
              if (strlen($DateTime)>11) 
              {
                $DateTime=substr($DateTime,0,11);
              }
          ?>
              <div>
                <img class="pull-left" style="margin-top: 10px; margin-left: 10px;" src="Upload/<?php echo htmlentities($Image); ?>" width=70; height=70;>
                <a href="FullPost.php?id=<?php echo $Id; ?>">
                <p id="heading" style="margin-left: 90px;"><?php echo htmlentities($Title); ?></p>
                </a>
                <p class="description" style="margin-left: 90px;"><?php echo htmlentities($DateTime); ?></p>
                <hr>
              </div>
            <?php } ?>
        </div>
        <div class="panel-footer">
            
        </div>
      </div>
        
    </div><!--Side area end-->
    	
  </div><!--Row end-->		
		
</div>
	
</div>


  <div style="height: 250px; background: #555;"></div>
  <div id="Footer">
    <p>copyright @ 2018-2019 Contineous</p>
    <a style="color: white; text-decoration: none; cursor: pointer; font-weight: bold; " href="#">By Sourabh Kumrawat</a>
  </div>



</body>
</html>