<!DOCTYPE html>

<?php
	
function openFile($filename = './data/list.txt') {

	// if (filesize($filename) > 0) {
	// 	$filesize = $filesize($filename);
	
	// } else {
	// 	$filesize = '100';
	// }
	
	$handle = fopen($filename, 'r');
	$items = [];

    
    $contents = trim(fread($handle, filesize($filename)));
    fclose($handle);
    $items = explode("\n", $contents);
    // array_push($items, $newitem);
    // print_r($newitem);
    return $items;
}

function save_to_file($todo_array, $filename = './data/list.txt') {

	// foreach ($todo_array as $key => $value) {
	// 	$todo_array[$key] = htmlspecialchars(strip_tags($value));
	// }

	$handle = fopen($filename, 'w+');
	foreach ($todo_array as $value) {
		fwrite($handle, $value . "\n");
	}
	fclose($handle);
}

function removeContact($todo_array, $filename = './data/list.txt') {
	$id = $_GET['id'];
	unset($todo_array[$_GET['id']]);
	$handle = fopen($filename, 'w+');
	foreach ($todo_array as $item) {
		$todo_array = fgets($handle, $item);
	}
	fclose($handle);
	return $todo_array;
	// save_to_file($addressBook);

	// header("Location: ./csv/address_book.csv");
}

$todo_array = openFile();
	
if(count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
	
	$uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

	$filename = basename($_FILES['file1']['name']);

	$savedFilename = $uploadDir . $filename;

	move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

	if($_FILES['file1']['type'] == 'text/plain') {
		$newArray = openFile($savedFilename);
		$todo_array = array_merge($todo_array, $newArray);
		save_to_file($todo_array);
	}

}

if(isset($_GET['id'])) {
	$id = $_GET['id'];
	unset($todo_array[$id]);
	save_to_file($todo_array);
}

if(isset($_POST['newitem'])) {
	array_push($todo_array, $_POST['newitem']);
	save_to_file($todo_array);
}

if(isset($savedFilename)) {
		echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
	}

?>

<html>
<head>
	<title>TODO List Template</title>
	<link rel="stylesheet" type="text/css" href="/css/site.css">
</head>
<body>

	<h2>TODO List</h2>
	<div class="centered">
		<ul>

			<? foreach ($todo_array as $key => $value): ?>
				<li>
					<?= htmlspecialchars(strip_tags($value)) ?>
					<a style="color: white" href="?id=<?=$key?>"> COMPLETED </a> 
				</li>
			<? endforeach ?>
		</ul>
	</div>

	<h2>Enter item</h2>
	<form method="POST" action="/todo_list.php">
		<label for="newitem" id="labelhead">New Item</label>
		<p>
			<input type="text" id="newitem" name="newitem" placeholder="Enter Item">
		</p>
		<button type="submit"> Add </button>
	</form>

	<h2>Upload File</h2>

    <form method="POST" enctype="multipart/form-data" action="/todo_list.php">
        <p>
            <label for="file1">File to upload: </label>
            <input type="file" id="file1" name="file1">
        </p>
        <p>
            <input type="submit" value="Upload">
        </p>
    </form>
</body>
</html>