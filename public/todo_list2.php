<?php

class TodoList {

    public $filename = '';
    public $items = [];
    
    public function __construct ($filename = './uploads/list.txt') {
        $this->filename = $filename;
    }

    public function sanitize (){
        foreach ($this->items as $key => $value) {
            $this->items[$key] = htmlspecialchars(strip_tags($value));
        }
        
    }

    public function writeList() {

        $handle = fopen($this->filename, 'w');
        $string = implode("\n", $this->items);
        fwrite($handle, $string);
        fclose($handle);
    }

    public function readList() {

        $filename = $this->filename;

        if (filesize($filename) > 0) {
            $filesize = filesize($filename);
        }

        else {
            $filesize = 100;
        }

            $handle = fopen($this->filename, 'r');
            $contents = trim(fread($handle, $filesize));
            $contentArray = explode("\n", $contents);
            fclose($handle);
            return $contentArray;
    }


}

$list = new TodoList();
$list->items = $list->readList();


if (isset($_GET['id'])) {
    unset($list->items[$_GET['id']]);
    $list->items = array_values($list->items);
    $list->sanitize();
    $list->writeList();
}

if (isset ($_POST['newitem'])) {
    $itemToAdd = $_POST['newitem'];
    $list->items[] = $itemToAdd;
    $list->sanitize();
    $list->writeList();
}

if (count($_FILES) > 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {

    $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';

    $filename = basename($_FILES['file1']['name']);

    $savedFilename = $uploadDir . $filename;

    move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);

    if ($_FILES['file1']['type'] == 'text/plain') {

        $list2 = new TodoList("./uploads/" . $filename);
        $list2->items = $list2->readList();
        $list2->sanitize();
        $list->items = array_merge($list->items, $list2->items);
        $list->sanitize();
        $list->writeList();
    }
}

?>

<html>
    <head>
        <title>TODO List</title>
        <link rel="stylesheet" href="/css/todo_list.css">
    </head>

<body>
    <div class="row">
        <h1>TODO List</h1>

        <ul>
            
            <? foreach ($list->items as $key => $value): ?>
                <li>
                    <button type="button">
                         
                    <a href="?id=<?= $key ?>"><?=$value?></a>
                    </button>
                </li>
            <? endforeach; ?>
            
        </ul>

            <h1>Add New Item</h1>

            <form method="POST" action="/todo_list2.php">

                <label for="newitem">--Add This Item--</label>
                <input type="text" id="newitem" name="newitem"></input>
                <input type="submit" value="add">
                

            </form>

            </form>
        
            <form method="POST" enctype="multipart/form-data" action="/todo_list2.php">
                <h3>Upload File</h3>
                <?php
                    if (isset($savedFilename)) {
                        echo "<p>Download File <a href='/uploads/{$filename}'>here</a>.</p>";
                    } 

                    if (isset($error)) {
                        echo "<p> $error </p>";
                    }
                ?>
                <p>
                    <label for="file1">File: </label>
                    <input type="file" id="file1" name="file1">
                </p>

                <p>
                    <input type="submit" value="Upload">
                </p>

            </form>
    </div>
</body>
</html>



