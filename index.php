<?php
	require 'vendor/autoload.php';

	$client = new MongoClient("mongodb://localhost:27017");
	$blog = $client->mydbs->blog;
	$result = $blog->find(array());	

	$data = iterator_to_array($result);


?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

	<title>Home Page</title>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="blog.css" rel="stylesheet">

    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </head>

<body>
<div class="blog-header">
        <h1 class="blog-title">World Blog <small>Articles</small></h1>
</div>
<div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="add.html">New Blog</a>
          <a class="blog-nav-item" href="about.php">About</a>
        </nav>
      </div>
    </div>

<div class="container">

	<table width='80%' border=0>

	<?php 	
	foreach ($result as $res) {?>
			<br/><br/>

		<div class="blog_post">
		<?php	echo "<h2 class = 'blog-post-title'><a href=\"comment.php? id=$res[_id]\">"; ?>
		<?php 
		echo $res['title']; ?></a></h2>
		<p class="blog-post-meta"><?php echo $res['date'];?></p>
		<?php  $body = $res['content'];
			echo substr($body, 0,400) ."...";
		?>
			<br/><br/>

		<?php echo "<a href=\"edit.php?id=$res[_id]\">Edit</a> | <a href=\"delete.php?id=$res[_id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a> | <a href=\"comment.php?id=$res[_id]\">View</a>";	?>	

	<?php } ?>
	
</table>
</div>

</body>
    <footer class="blog-footer">
      <p>Blog template built for <a href="http://getbootstrap.com">Demo</a> by <a href="https://twitter.com/mdo">@Charine</a>.</p>
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>
</html>