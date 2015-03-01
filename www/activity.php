<?php
require_once('includes/connect.php');
// this gets the theme that was passed in the URL and places it in $link
if (isset($_GET['theme'])) {
	$link = $_GET['theme'];
} else {
	$link='relax';
}

//this helps to prevent sql injection
$link=htmlspecialchars($link,ENT_QUOTES, 'UTF-8');
//prepare the navigation result set
$navigation_sql = "SELECT * FROM activities WHERE theme LIKE :theme";
$resultNavigation = $pdo -> prepare($navigation_sql);
//bind the query
$resultNavigation->bindValue(':theme','%'.$link.'%',PDO::PARAM_STR);
//execute the query
$resultNavigation -> execute();
/* check to see if the URL contains the id if not give it a default value */
if (isset($_GET['id'])) {
	$id = $_GET['id'];
} else {
	$id=4;
}
$id=htmlspecialchars($id,ENT_QUOTES, 'UTF-8');
// get the activity recordset
//$activity_sql="SELECT * from activities WHERE id=:id";
$activity_sql= "SELECT *
FROM activities
Inner Join tourguide on tourguide.id = activities.tourguide_id
WHERE activities.id =:id
";
$resultActivity = $pdo -> prepare($activity_sql);
//bind the query
$resultActivity->bindValue(':id',$id,PDO::PARAM_STR);
//execute the query
$resultActivity -> execute();
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
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js">
➥</script>
<![endif]-->
</head>
<body>
<div id ="container">
	<header></header>
	<nav>
		<ul>					
		<li><a href="index.php">home</a></li> 
	<li><a href="activity.php?theme=relax&amp;id=1">relax</a></li> 
	<li><a href="activity.php?theme=on the water&amp;id=6">on water </a></li> 
	<li><a href="activity.php?theme=in the water&amp;id=2">in water</a></li> 
	<li><a href="activity.php?theme=on land&amp;id=12">on land</a></li> 
	<li><a href="activity.php?theme=in the sky&amp;id=16">in the sky</a></li> 
	<li><a href="activity.php?theme=culture&amp;id=18">culture</a></li>

	</ul>
	</nav>

	<div id ="content">
	<nav id="activity_menu">
		<ul>
		<?php foreach($resultNavigation as $row) { ?>
		<li><a href="activity.php?id=<?php echo $row['id'];?>&amp;theme=<?php echo $row['theme'];?>">
			<?php echo $row['activity'];?></a></li> <br />
			<?php
		} 
		
	if(isset($_GET['from_search'])) { ?>
		<li><a href="javascript:history.back(-1);">Back to search results</a></li>
		<?php } ?> 
	
		</ul>
	</nav>
	<section>
		<?php 
		 foreach($resultActivity as $row) { 
		 echo '<h1>'.$row['activity'].'</h1>'.$row['description'].'<br/>'.'<br/>';
		 echo 'Your Tour Guide is: '.$row['firstname'];
				 $image_name = $row['image'];

		 } ?>
		<p><img src="images/<?php echo $image_name; ?>" alt="<?php echo $image_name;?>" /></p>

		
	</section>
	<article>
	<?php include('includes/information.php'); ?>
	</article>
	</div>
	<footer>Mount Maunganui College</footer>
</div>
</body>
</html>