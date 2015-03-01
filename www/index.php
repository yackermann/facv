<?php
//first connect to the database
require_once('includes/connect.php');
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
				<div id="search">
					<form action="search_result.php" method="post" id ="searchform">
						<label>Search for an activity or click a link: <input type="text" size ="18" maxlength="30" name="search" /></label><br />
						<input type="submit" name="submit" value="Search" />
					</form>
				</div>
				<br /><a href="login.php">Admin</a>
			</ul>

			</nav>
			<div id ="content">
				<section>
					<h2>Mount Maunganui</h2>
					<p>Mauao (Mount Maunganui), famous for its great weather and popular surf and swimming beaches, is a holiday destination for overseas visitors and locals alike. Tauranga and "The Mount" offers relaxation, adventure and culture. There are activities for everyone.</p>
					<figure>
						<img src="images/views_from_mauao.jpg" alt="view from Mauao" width="200" height="133"/>
						<figcaption>Views from Mauao</figcaption>
					</figure>
					<p>The name Tauranga comes from Maori, it roughly translates to "a sheltered anchorage". Tauranga is the largest city in New Zealand with a Maori name instead of a European name.</p>
					<p>Tauranga is a port city located in the western Bay of Plenty region of the North Island of New Zealand. It has an urban population of 116,000 from the June 2008 estimate. Tauranga is the largest city and urban area in the Bay of Plenty. Nationwide, Tauranga is currently New Zealand's fifth largest urban area. It is one of New Zealand's fastest growing regions, with a 14 percent increase in population between the 2001 census and the 2006 census.</p>
					<video  width="373" height="280" controls>
								<source src="videos/surf.mp4"></source>
								<source src="videos/surf.ogv"></source>
								<source src="videos/surf.webm"></source>
					</video>		
				</section>
				<article>
					<?php include('includes/information.php'); ?>	
				</article>
			</div>
			<footer>Mount Maunganui College</footer>
		</div>
	</body>
</html>
