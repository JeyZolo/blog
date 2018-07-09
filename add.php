<html>
<head>
	<title>Add Blog</title>
</head>

<body>
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit'])) {	
	$blog = array (
				'title' => $_POST['title'],
				'content' => $_POST['content'],
				'date' => $_POST['date']
				//'commend' => $_POST['comment']

			);
		
	// checking empty fields
	$errorMessage = '';
	foreach ($blog as $key => $value) {
		if (empty($value)) {
			$errorMessage .= $key . ' field is empty<br />';
			header('Location: index.php');

		}
	}
	
	if ($errorMessage) {
		// print error message & link to the previous page
		echo '<span style="color:red">'.$errorMessage.'</span>';
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";	
	} else {
		//insert data to database table/collection named 'blogs'
		$db->blog->insert($blog);
		
	
		header('Location: index.php');

	}
}
?>
</body>
</html>
