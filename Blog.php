<?php 
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
   require_once("Include/Functions.php");
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Blog</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
  <!-- <link rel="stylesheet" type="text/css" href="css/nightmode.css"> -->
	<link rel="stylesheet" type="text/css" href="css/publicstyles.css">
	<style type="text/css">
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
	<div class="blog-header">
		<h1>The complete Responsive CMS Blog</h1>
		<p class="lead">No network connection now, you will not be able </p>
  </div>
    
  <div class="row"> 
    <div class="col-sm-8">
    	<?php 
        global $ConnectingDB;
        if(isset($_GET["SearchButton"]))
        {
        	$Search=$_GET["Search"];
          $ViewQuery="SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR post LIKE '%$Search%' ORDER BY id desc ";
        }
        elseif (isset($_GET["Category"])) 
        {
    	     $Category=$_GET["Category"];
    	     $ViewQuery="SELECT * FROM admin_panel WHERE category='$Category' ORDER BY id desc";
        }
        // Query when pagination is active i.e. blog.php?page=1
        elseif (isset($_GET["Page"])) 
        {      
          $Page=$_GET["Page"];
          if ($Page<=0) 
          {
           	$ShowPostFrom=0;
          }
          else
          {
            $ShowPostFrom=($Page*3)-3;
          }
    	    $ViewQuery="SELECT * FROM admin_panel ORDER BY id desc LIMIT $ShowPostFrom,3"; 
        } 
        else
        {
          $ViewQuery="SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,3"; }
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
          	<div class="blogpost thumbnail">
    		      <img class="img-responsive img-rounded"  src="Upload/<?php echo $Image; ?>">
    	        <div class="caption">
    		      <h1 id="heading"><?php echo htmlentities($Title); ?></h1>
    		      <p class="description">Category:<?php echo htmlentities($Category); ?> Published on <?php echo htmlentities($DateTime); ?> 
              <?php
                $ConnectionDB;
                $QueryApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$PostId' AND status='ON'";
                $ExecuteApproved=mysqli_query($Connection,$QueryApproved);
                $RowApproved=mysqli_fetch_array($ExecuteApproved);
                $TotalApproved=array_shift($RowApproved);
                if ($TotalApproved>0) 
                {
                ?>
                  <span class="badge pull-right ">
                    Comments: <?php  echo $TotalApproved;  ?>
      	          </span>
      	      <?php } ?>     
    		      </p>
    		      <p class="post">
                <?php 
                  if(strlen($Post)>200)
                  {
                    $Post=substr($Post,0,200).'...';
                  }
      		        echo $Post; 
                ?>  
              </p>
    	      </div>
    	      <a href="FullPost.php?id=<?php echo $PostId; ?>"><span class="btn btn-info">Read More &rsaquo; &rsaquo;</span></a>	
    	    </div>	
          <?php } ?>
        
        <div > 
         	<ul class="pagination pull-left pagination-lg">		
                <?php
                  if (isset($Page)) 
                  {
             	      if ($Page>1) 
                    {
             	  ?>
       	  	 <li><a href="Blog.php?Page=<?php echo $Page-1; ?>">&laquo;</a></li>
     	          <?php 
                    } 
                  } 
                ?>		
                <?php 
                  global $ConnectingDB;
                  $QueryPagination="SELECT COUNT(*) FROM admin_panel";
                  $ExecutePagination=mysqli_query($Connection,$QueryPagination);
                  $RowPagination=mysqli_fetch_array($ExecutePagination);
                  $TotalPosts=array_shift($RowPagination);
                  $PostPerPage=$TotalPosts/3;
                  $PostPerPage=ceil($PostPerPage);
                  for ($i=1; $i <=$PostPerPage ; $i++) 
                  { 
                	   if(isset($Page))
                     {
                        if ($i==$Page) 
                        {
                ?>
              <li class="active"><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php   
                        } 
                        else
                        { 
                ?>
              <li><a href="Blog.php?Page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php   
                        } 
                     } 
                  }
                ?>

                <?php
                  if (isset($Page)) 
                  {
               	    if (($Page+1) <= $PostPerPage) 
                    {
               	?>
         	    <li><a href="Blog.php?Page=<?php echo $Page+1; ?>">&raquo;</a></li>
               <?php 
                    }
                 }
                ?> 		
          </ul>
        </div>


    		
    	</div><!--Main blog area end-->
    	<div class="col-sm-offset-1 col-sm-3"><!--Side area-->
    		<h2>About me</h2>
    		<img class="img-responsive imageicon imgabt" src="images/comment.png">
    		<p>No network connection now, you will not be able to synchronize data or replace the wallpaper, if you clear your browser cache then wallpaper and icons will not be usedNo network connection now, you will not be able to synchronize data or replace the wallpaper, if you clear your browser cache then wallpaper and icons will not be used</p>

    		<div class="panel panel-primary">
    			<div class="panel-heading">
    				<h2 class="panel-title">Recent Post</h2>
    			</div>
    			<div class="panel-body background">
    				
    				<?php  

                    $ConnectingDB;
                    $ViewQuery="SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5";
                    $Execute=mysqli_query($Connection,$ViewQuery);
                    while ($DataRows=mysqli_fetch_array($Execute)) {
                    	$Id=$DataRows["id"];
                    	$Title=$DataRows["title"];
                    	$DateTime=$DataRows["datetime"];
                    	$Image=$DataRows["image"];
                    	if (strlen($DateTime)>11) {
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