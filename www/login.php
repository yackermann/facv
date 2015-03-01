<?php
	session_start();

	/*-----LOGOUT METHOD-----*/
	if(isset($_GET["u"]) && $_GET["u"]==1){
		session_destroy();
		header("Location: login.php");
	}
	/*-----REDIRECT METHOD-----*/
	if (isset($_SESSION['id'])){
	    header("Location:admin.php");
	    exit;
	}
	/*-----LOGIN METHOD-----*/
	include 'includes/connect.php'; 
	$error = "";
	if (isset($_POST['username']) && isset($_POST['password'])) {
		/*-----GETS DATA FROM DATABASE-----*/
	    $sql = "SELECT * FROM login WHERE username = :username"; //Query
	    $query = $pdo -> prepare($sql); //Prepare query
	    //Replace :username with posted username
	    $query -> bindParam(':username',$_POST['username']); 
	    $query ->execute();//Execute
	    //store retrieved row to a variable
	    $results = $query -> fetch(PDO::FETCH_ASSOC);
	    //check to see if we get a result and that it has a row
	    if($results != FALSE && $query -> rowcount() > 0 ) {
	    	if (crypt($_POST['password'], $results['password']) == $results['password']){
	    		/*-----LOGIN OK!-----*/
			 	$_SESSION['id'] = $results['id'];
			 	header("Location:admin.php");
			}else{
				/*-----WRONG PASSWORD!-----*/
			 	$error = 'Login failed, check username and password.';
			}
        }else {
        	/*-----USER HANDS PROBLEMS!!-----*/
            $error = 'Login failed, check username and password.';
        }
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link href='http://fonts.googleapis.com/css?family=Domine|Elsie|Fondamento' rel='stylesheet' type='text/css'>
		<meta charset="utf-8">
		<title>My Place - Mauao (Mount Maunganui)</title>
		<meta name="description" content="surfing, swimming, beaches, Tauranga, harbour">
		<meta name="author" content="Your Name">
		<link rel="stylesheet" href="css/style.css" media ="screen">
		<link rel="stylesheet" href="css/print.css" media ="print">
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div id="container">
			<header></header>
			<form action ="login.php" method = "POST">
				username: <input type="text" id="username" name="username" ><br />
				password: <input type ="password" id ="password" name ="password"><br />
				<input type ="submit" name = "submit" value="Login">
				<?php if(isset($error)){echo '<p><b><u>'.$error.'</u></b></p>';} ?>
			</form>
			<a href="index.php">Return to website</a>
		</div>
	</body>
</html>