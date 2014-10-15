<<!DOCTYPE html>

<?php
if ($_GET) {
	var_dump($_GET);
}
if ($_POST) {
	var_dump($_POST);
}
?>

<html>
<head>
	<title>TODO List Template</title>
</head>
<body>

	<h2>TODO List</h2>

	<ul>
		<li>one</li>
		<li>two</li>
		<li>three</li>
	</ul>

	<h2>Enter item</h2>
	<form method="POST" action="/todo_list.html">
		<label for="newitem">New Item</label>
		<input type="text" id="newitem" name="newitem" placeholder="Enter Item">
		<input type="submit" value="Add">
	</form>
</body>
</html>