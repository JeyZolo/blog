<?php
// including the database connection file
include_once("config.php");

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	$blog = array (
				'title' => $_POST['title'],
				'content' => $_POST['content'],
				'date' => $_POST['date']				
				//'comment' => $_POST['comment']
			);
	
	// checking empty fields
	$errorMessage = '';
	foreach ($blog as $key => $value) {
		if (empty($value)) {
			$errorMessage .= $key . ' field is empty<br />';
		}
	}
			
	if ($errorMessage) {
		// print error message & link to the previous page
		echo '<span style="color:red">'.$errorMessage.'</span>';
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";	
	} else {
		$db->blog->update(
						array('_id' => new MongoId($id)),
						array('$set' => $blog)
					);
		
		//redirectig to the display page. 
		header("Location: index.php");
	}
} 
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = $db->blog->findOne(array('_id' => new MongoId($id)));

$title = $result['title'];
$content = $result['content'];
$date = $result['date'];

?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

	<title>Edit Blog</title>
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
        <h1 class="blog-title">My Blog <small>My Articles</small></h1>
</div>

	<div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item active" href="index.php">Home</a>
          <a class="blog-nav-item" href="about.php">About</a>
        </nav>
      </div>
    </div>

	<br/><br/>
	<div class="container">

	<form name="form1" method="post" action="edit.php">
	<div class="form-group">
	    <label for="exampleInputEmail1">Title</label>
	    <input type="text" name = "title" class="form-control" id="exampleInputEmail1" placeholder="Title" value="<?php echo $title;?>">
	  </div>

	  <div class="form-group">
	    <label for="exampleInputPassword1">Content</label>
	    <textarea cols="100" rows="20"  name="content" class="form-control"><?php echo $content;?></textarea>
	  </div>

	  <div class="form-group">
	    <label for="exampleInputEmail1">Date</label>
	    <input type="date" name = "date" value="07/09/2018" class="form-control" id="exampleInputEmail1" placeholder="Date" value="<?php echo $date;?>">
	  </div>
	  <div class = "container">
	  <button type="submit" name="update" " value="Update" class="btn btn-primary">Update Blog</button></div>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>

	</form>
</div>
</body>
</html>
