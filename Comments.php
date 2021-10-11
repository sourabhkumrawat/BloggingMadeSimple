<?php 
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
  require_once("Include/Functions.php");
 ?>
  <?php echo Confirm_Login();   ?>
<!DOCTYPE html>
<html>
<head>
	<title>Manege Comments</title>
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
					<li><a href="AddNewPost.php"> <span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Post</a></li> 
					<li><a href="Categories.php"> <span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
					<li><a href="Admins.php"> <span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
					<li class="active"><a href="Comments.php"> <span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
					<li><a href="Blog.php"><span class="glyphicon glyphicon-list"></span>&nbsp;Live Blog</a></li>
					<li><a href="Logout.php"> <span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
					

				</ul>			
			</div>
			<!-- end side areaa -->



			<div class="col-sm-10">

                <div><?php echo Message(); 
                      echo SuccessMessage();
				 ?></div>

				<h2>Un-Approved Comments</h2>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
						<th>No.</th>
						<th>Name</th>
						<th>Date</th>
						<th>Comment</th>
					
						<th>Approve</th>
						<th>Delete Comment</th>
						<th>Details</th>
					</tr>	
   					<?php 
                    $ConnectingDB;
                      $Admin=$_SESSION["Username"];
                    $Query="SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                    $Execute=mysqli_query($Connection,$Query);
                    $SrNo=0;
                    while($DataRows=mysqli_fetch_array($Execute)) {
                    	$CommentId=$DataRows['id'];
                    	$DateTimeofComment=$DataRows['datetime'];
                    	$PersonName=$DataRows['name'];
                    	$PersonComment=$DataRows['comment'];
                    
                    	$CommentedPostId=$DataRows['admin_panel_id'];
                    	$SrNo++;
                   ?> 	

                <tr>
                	<td><?php echo htmlentities($SrNo); ?></td>
                	<td><?php echo htmlentities($PersonName); ?></td>
                	<td><?php echo htmlentities($DateTimeofComment); ?></td>
                	<td><?php echo htmlentities($PersonComment); ?></td>
                	
                	<td><a href="ApproveComment.php?id=<?php echo $CommentId; ?>"><span class="btn btn-success">Approved</spBlog/td>
                	<td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                	<td><a href="FullPost.php?id=<?php echo $CommentedPostId; ?>"><span class="btn btn-primary">Live Preview</span></a></td>
                	
                </tr>
             <?php } ?>

   				

					</table>
				</div>	



				<h2>Approved Comments</h2>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
						<th>No.</th>
						<th>Name</th>
						<th>Date</th>
						<th>Comment</th>
						<th>Approve by</th>
						<th>Revert Approve</th>
						<th>Delete Comment</th>
						<th>Details</th>
					</tr>	
   					<?php 
                    $ConnectingDB;
                    $Admin="Nandkishor Dhangar";
                    $Query="SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                    $Execute=mysqli_query($Connection,$Query);
                    $SrNo=0;
                    while($DataRows=mysqli_fetch_array($Execute)) {
                    	$CommentId=$DataRows['id'];
                    	$DateTimeofComment=$DataRows['datetime'];
                    	$PersonName=$DataRows['name'];
                    	$PersonComment=$DataRows['comment']; 
                    		$ApprovedBy=$DataRows['Approvedby'];                   
                    	$CommentedPostId=$DataRows['admin_panel_id'];
                    	$SrNo++;
                   ?> 
                <tr>
                	<td><?php echo htmlentities($SrNo); ?></td>
                	<td><?php echo htmlentities($PersonName); ?></td>
                	<td><?php echo htmlentities($DateTimeofComment); ?></td>
                	<td><?php echo htmlentities($PersonComment); ?></td>
                	
                <td><?php echo htmlentities($ApprovedBy); ?></td>
                	<td><a href="DisApproveComment.php?id=<?php echo $CommentId; ?>"><span class="btn btn-warning">Dis-Approved</span></a></td>
                	<td><a href="DeleteComments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
                	<td>
                		<a href="FullPost.php?id=<?php echo $CommentedPostId; ?>"><span class="btn btn-primary">Live Preview</span></a>
                	</td>
                	
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