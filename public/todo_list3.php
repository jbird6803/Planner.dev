<?php

class TodoList {

    public $filename = '';

    public $items = array ();

    public function writeList() 
    {

        $handle = fopen($this->filename, 'w+');
        //  Implode the entire array into one string, 
        // with newlines in between each item.
        $string = implode("\n", $this->items);
        fwrite($handle, $string);
        fclose($handle);
    }

	public function readList()
	{

	    $contentArray = array();

	    if (filesize($this->filename) > 0) {
	    	//$filesize = filesize($this->filename);
	    	$handle = fopen($this->filename, 'r');
	    	$contents = trim(fread($handle, filesize($this->filename)));
	    	$contentArray = explode("\n", $contents);
	    	fclose($handle);
	    	return $contentArray;
    
	    }    
	}

	public function sanitize ($array) 
	{

		foreach ($array as $key => $value) 
		{
			$array[$key]=htmlspecialchars(strip_tags($value));
		}
		return $array;
	}

}

$list = new TodoList();
$list->filename = './uploads/list.txt';
$todo_array = $list->readList();
//$list->items = $todo_array;
// $list->writeList($todo_array);

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	unset($todo_array[$id]);
	$list->items = $todo_array;
	$list->writeList($todo_array);
}

if (isset ($_POST['newitem'])) {
	$todo_array[] = $_POST['newitem'];
	$todo_array = $list->sanitize($todo_array);
	$list->items = $todo_array;
	$list->writeList($todo_array);
}

?>

<html>
	<head>
		<title>TODO List</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="/css/todo.css">
		<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
	</head>

<body>
	<div class="row">
	  <div class="col-xs-6 col-md-4"></div>
	  <div class="col-xs-6 col-md-4">
		<h3>TODO List</h3>

		<ul>
			
			<? foreach ($todo_array as $key => $value): ?>
	    		<li>
	    			<button type="button" class="btn btn-default btn-xs">
	    				 
	    					<a href="?id=<?= $key; ?>"><span class="glyphicon glyphicon-remove"></span></button></a>&nbsp;<?= htmlspecialchars(strip_tags($value)); ?>
	    		</li>
			<? endforeach; ?>
			
		</ul>

		<hr>

			<h3>Add New Item to Todo List</h3>

			<form method="POST" action="todo_list.php">

				<label for="newitem">&lt;Add This Item&gt;</label>
				<input type="text" id="newitem" name="newitem" placeholder="enter item here"></input>
				<input type="submit" value="add">

				<p>
				<label for="adding new item to the beginning of the list">
				<input type="checkbox" id="adding to beginning" name="adding to beginning" value="yes"></input>
				<label for="adding to beginning">Add new item to beginning of list.</label>
				</label>
				</p>

			</form>
		
			<form method="POST" enctype="multipart/form-data" action="/todo_list.php">
				<h3>Upload File</h3>
				<?php

				    // Check if we saved a file
				    if (isset($savedFilename)) {
				        // If we did, show a link to the uploaded file
				        echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";

				    } 

				    if (isset($error)) {
				    	echo "<p> $error </p>";
				    }

				?>
		        <p>
		            <label for="file1">File to upload: </label>
		            <input 
		            <input type="file" id="file1" name="file1">
		        </p>

		        <p>
		            <input type="submit" value="Upload">
		        </p>

	    	</form>
	    </div>
	  <div class="col-xs-6 col-md-4"></div>
	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>



