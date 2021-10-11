<?php 
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
  require_once("Include/Functions.php");
 ?> 
 <?php echo Confirm_Login();   ?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashbord</title>
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
				<li class="active"><a href="Dashbord.php">
          <span class="glyphicon glyphicon-th"></span>&nbsp;Dashbord</a></li>
				<li><a href="AddNewPost.php"> <span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li> 
				<li><a href="Categories.php"> <span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
				<li><a href="Admins.php"> <span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
				<li><a href="Comments.php"> 
              <span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
                <?php
                  $ConnectionDB;
                  $QueryTotal="SELECT COUNT(*) FROM comments WHERE status='OFF'";
                  $ExecuteTotal=mysqli_query($Connection,$QueryTotal);
                  $RowTotal=mysqli_fetch_array($ExecuteTotal);
                  $Total=array_shift($RowTotal);
                  if ($Total>0) {
 	              ?>
                    <span class="label pull-right label-warning"><?php  echo $Total;  ?></span>
              	 <?php } ?>                         
				    </a>
        </li>
					
  			<li><a href="Blog.php"><span class="glyphicon glyphicon-list"></span>&nbsp;Live Blog</a></li>
  			<li><a href="Logout.php"> <span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
			</ul>			
		</div>

    <div class="col-sm-10">
      <div>
        <?php 
          echo Message(); 
          echo SuccessMessage();
				?>    
      </div>

			<h1>Admin Dashbord</h1>

			<div class="table-responsive">
				<table class="table table-striped table-hover"">
					<tr>
						<th>No.</th>
						<th>Post Title</th>
						<th>Date & Time</th>
						<th>Author</th>
						<th>Category</th>
						<th>Banner</th>
						<th>Comments</th>
						<th>Action</th>
						<th>Details</th>
					</tr>
				<?php  
					$ConnectionDB;
					$ViewQuery="SELECT * FROM admin_panel ORDER BY id desc"; 
          $Execute=mysqli_query($Connection,$ViewQuery);
          $SrNo=0;
          while ($DataRows=mysqli_fetch_array($Execute)) 
          {
          	$Id=$DataRows["id"];
          	$DateTime=$DataRows["datetime"];
          	$Title=$DataRows["title"];
          	$Category=$DataRows["category"];
          	$Admin=$DataRows["author"];
          	$Image=$DataRows["image"];
          	$Post=$DataRows["post"];
          	$SrNo++;
          	?>
        	<tr>
        		<td><?php echo $SrNo; ?></td>
        		<td style="color: blue;">
              <?php
            		if (strlen($Title)>20) 
                {
            		 	$Title=substr($Title,0,25).'...';
            		} 
            		echo $Title; 
          		?>  
            </td>
        		<td>
              <?php 
            		if (strlen($DateTime)>11) 
                {
            		 	$DateTime=substr($DateTime,0,11).'..';
            		}
            		echo $DateTime; 
        		  ?>  
            </td>
        		<td>
              <?php 
                if (strlen($Admin)>11)
                {
        		 	    $Admin=substr($Admin,0,11).'..';
        		    }                
        		    echo $Admin; 
        		  ?>  
            </td>
        		<td>
              <?php 
          		  if (strlen($Category)>8) 
                {
          		 	  $Category=substr($Category,0,8).'..';
          		  }        
          		  echo $Category; 
          		?>  
            </td>
        		<td>
              <img src="Upload/<?php echo $Image; ?>" width="80px" height="40px">
            </td>
        		<td>
        			<?php
                $ConnectionDB;
                $QueryApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='ON'";
                $ExecuteApproved=mysqli_query($Connection,$QueryApproved);
                $RowApproved=mysqli_fetch_array($ExecuteApproved);
                $TotalApproved=array_shift($RowApproved);
                if ($TotalApproved>0) 
                {
	             ?>
                  <span class="label pull-right label-success">
                    <?php  echo $TotalApproved;  ?>
                  </span>
              <?php } ?>     
              <?php
                $ConnectionDB;
                $Query_unApproved="SELECT COUNT(*) FROM comments WHERE admin_panel_id='$Id' AND status='OFF'";
                $Execute_unApproved=mysqli_query($Connection,$Query_unApproved);
                $Row_unApproved=mysqli_fetch_array($Execute_unApproved);
                $Total_unApproved=array_shift($Row_unApproved);
                if ($Total_unApproved>0) 
                {
              ?>
                  <span class="label label-danger">
                    <?php  echo $Total_unApproved;  ?>
                  </span>
      	      <?php } ?>                    
        		</td>
        		<td>
              <a href="EditPost.php?Edit=<?php echo $Id ?>"><span class="btn btn-warning">Edit</span></a> 
        	    <a href="DeletePost.php?Delete=<?php echo $Id ?>"><span class="btn btn-danger">Delete</span></a> 
            </td>
        		<td>
        		  <a href="FullPost.php?id=<?php echo $Id; ?>" target=_blank><span class="btn btn-primary"> Live Preview</span></a>	
       	    </td>
        	</tr>
          <?php } ?>	
        </table>
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