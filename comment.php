<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['post_comment']))
{	
	$id = $_POST['id'];
	$commts = array (
				'name' => $_POST['name'],
				'email' => $_POST['email'],
				'comment' => $_POST['comment']				
			);

	$errorMessage = '';
	foreach ($commts as $key => $value) {
		if (empty($value)) {
			$errorMessage .= $key . ' field is empty<br />';
			header('Location: comment.php?id='.$id );

		}
	}
			
	if ($errorMessage) {
		// print error message & link to the previous page
		echo '<span style="color:red">'.$errorMessage.'</span>';
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";	
	} else {
	    
	    $update_tag = array('$addToSet' => array("commenter" => array("_id" => new MongoId(), "name" => $commts['name'], "email" => $commts['email'], "comment" => $commts['comment'])));
		$status = $db->blog->update(
						array("_id" => new MongoId($id)),
						$update_tag
					);
		
		//redir"ctig to the display page. In our case, it is index.php
		print ($status);
		if ($status == TRUE) {

			header('Location: comment.php?id='.$id );
		}
	}
} // end if $_POST
?>
<?php
//getting id from url
//$id = $_GET['id'];
$id = isset($_GET['id']) ? $_GET['id'] : '';

//selecting data associated with this particular id
$result = $db->blog->findOne(array('_id' => new MongoId($id)));
$id = $result['_id'];

$title = $result['title'];
$content = $result['content'];
$date = $result['date'];
$comment = isset($result['commenter']) ?$result['commenter']: '';

?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

	<title>Comment and review Blog</title>
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
        <h1 class="blog-title">World Blog</h1>
      </div>

<div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="index.php">Home</a>
          <a class="blog-nav-item" href="about.php">About</a>
        </nav>
      </div>
    </div>

<div class="container">

	
	<br/><br/>
	
	<form >
		<div class ="form-group">
			
			
			<h2 class="blog-post-title"> <?php echo $title;?></h2>
			
			<div class="blog-post">
				<p><?php echo $content;?></p>
			</div>	
				<p class="blog-post-meta">Date : <?php echo $date;?></p>


		</div>
	</form>
<blockquote>Comments</blockquote>
<div class ="comment-area">
	<?php 
	if (is_array($comment) || is_object($comment))
	{
		foreach ($comment as $commt) {
		echo "<form>";
		echo "<div class='media'>";
		  echo "<div class='media-body'>";
		    echo "<h5 class='mt-0'>".$commt["name"]." : ".$commt["email"]."</h5>";
		    echo $commt["comment"];
		    echo"	  </div>";
		echo" </div>";
		echo" </form>";
	}
	}
?>

	<form name="form" method="post" action="comment.php">
		<input type="hidden" name="id" value=<?php echo $result['_id'];?>>

	  <div class="form-group">
	    <label for="exampleInputEmail1">Name</label>
	    <input type="text" name = "name" class="form-control" id="exampleInputEmail1" placeholder="Name">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputEmail1">Email</label>
	    <input type="text" name = "email" class="form-control" id="exampleInputEmail1" placeholder="Email">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Comment</label>
	    <textarea cols="60" rows="10" name="comment" class="form-control"></textarea>
	  </div>
	  <div class = "container">
	  <button type="submit" name="post_comment" class="btn btn-primary">Post Comment</button></div>
	</form>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</div>
</body>
</html>
