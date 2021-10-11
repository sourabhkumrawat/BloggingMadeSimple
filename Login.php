<?php 
  require_once("Include/DB.php");
  require_once("Include/Sessions.php");
   require_once("Include/Functions.php");
 ?>
 <?php 
if (isset($_POST["Submit"])) {

    $Connection=mysqli_connect('localhost','root','');
	$ConnectingDB=mysqli_select_db($Connection,'phpcms');

	$Username=mysqli_real_escape_string($Connection,$_POST["Username"]);
  $Password=mysqli_real_escape_string($Connection,$_POST["Password"]);
 
  if (empty($Username)||empty($Password)) {
  	$_SESSION["ErrorMessage"]="All Fields must be filled out";
  	Redirect_to("Login.php");
  	
  }
  else{
        $Found_Account=Login_Attempt($Username,$Password);
           $_SESSION["User_Id"]=$Found_Account["id"];
        $_SESSION["Username"]=$Found_Account["username"];
        if ($Found_Account) {
            $_SESSION["SuccessMessage"]="Welcome {$_SESSION['Username']}";
            Redirect_to("dashbord.php");
        }else{
            $_SESSION["ErrorMessage"]="Invalid Username/Password";
    Redirect_to("Login.php");
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
  <style type="text/css">
    body{
      background:url("images/b.jpg");
      width: relative;
      height: relative;
    }
    .lbox{
      background-color: rgba(150,150,150,0.5);
      padding: 40px;
      border: 2px #000 solid;
      border-radius: 3%;
    }
    .fieldinfo{
      color: rgb(251,174,44);
      font-family: Bitter,Georgia,"Times New Roman",Times,serif;
      font-size: 1.2em;
      opacity: 1;
    }
    #gtb a{
      font-style: none;
      color: #fff;
      font-weight: bold;
    }
    #gtb{
      margin-top: 15px;
    }

  </style>
</head>
<body>


<nav class="navbar navbar-inverse" role="navigation">
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

<div class="Line" style="height: 2px; background: #27aae1;"></div> 

<div class="container-fluid" >
	<div class="row">
		<div class="col-sm-offset-4 col-sm-4">
			<br><br><br>
    	<?php echo Message(); 
        echo SuccessMessage();
			?>
      <h1>Welcome Back!</h1>

			<div class="lbox">
				<form action="Login.php" method="post">
					<fieldset>
						<div class="form-group">
							<label for="username"><span class="fieldinfo"> Username:</span></label><br>
              <div class="input-group input-group-lg">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-envelope text-primary"></span>
                </span>
						    <input class="form-control" type="text" name="Username" id="username" placeholder="username">
              </div>
            </div>
            <div class="form-group">
              <label for="Password"><span class="fieldinfo">Password:</span></label><br>
              <div class="input-group input-group-lg">
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-lock text-primary"></span>
                </span>
                <input class="form-control" type="Password" name="Password" id="Password" placeholder="Password">
              </div>
            </div><br>
            <input class="btn btn-info btn-block" type="Submit" name="Submit" value="Login">
    			</fieldset>
    		</form>
    	</div>
	
		</div><!-- ending main arear -->
	</div><!-- ending of row -->
</div><!-- ending of container -->

	
</body>
</html> 