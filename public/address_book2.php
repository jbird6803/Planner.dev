<?php

class AddressBook {

	public $filename = '';
	public $addressBook = [];

	public function openFile() {

		$handle = fopen($this->filename, 'r');
		$addressBook = [];

		while(!feof($handle)) {
		    $row = fgetcsv($handle);

		    if (!empty($row)) {
		        $addressBook[] = $row;
		    }
		}
		fclose($handle);
		return $addressBook;
	}

	public function save_to_file() {
		
		$handle = fopen($this->filename, 'w');
		foreach ($addressBook as $row) {
			fputcsv($handle, $row);
		}
		fclose($handle);
	}

	public function removeContact() {
		unset($addressBook[$_GET['id']]);
		$handle = fopen($this->filename, 'w');
		foreach ($addressBook as $contact) {
			fputcsv($handle, $contact);
		}
		fclose($handle);
		return $addressBook;
	}
}

$list = new AddressBook();
$list->filename = './csv/address_book.csv';
$addressBook = $list->openFile();

if (!empty($_POST)) {

	if(empty($_POST['name']) || empty($_POST['address']) || empty($_POST['city']) || empty($_POST['state']) || empty($_POST['zip']) || empty($_POST['phone']) || strlen($_POST['zip']) != 5 || strlen($_POST['phone']) != 10) {

		$error = "Please input all fields correctly.";
	
	} else {
		
		if (isset($_POST['name'])) {
			$newEntry['name'] = $_POST['name'];
		}
		if (isset($_POST['address'])) {
			$newEntry['address'] = $_POST['address'];
		}
		if (isset($_POST['city'])) {
			$newEntry['city'] = $_POST['city'];
		}
		if (isset($_POST['state'])) {
			$newEntry['state'] = strtoupper($_POST['state']);
		}	
		if (isset($_POST['zip'])) {
			$newEntry['zip'] = $_POST['zip'];
		}
		if (isset($_POST['phone'])) {
			$newEntry['phone'] = $_POST['phone'];
		}
		$addressBook[] = $newEntry;
		$addressBook = $list->sanitize($addressBook);
		$list->save_to_file($addressBook);
	}
}

if(isset($_GET['id'])) {
	removeContact($addressBook, $list);
}

?>

<html>
<head>
	<title>Address Book</title>

    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<style type="text/css">
	    .no-pad-left {
	        padding-left: 0px;
	    }
	</style>

</head>
<body>

<div class="container">

	<h1 class="page-header">Contacts</h1>
	
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th>Name</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Zip</th>
				<th>Phone #</th>
			</tr>

	<!-- 		<? if (isset($error)): ?>
				<p> <?= $error ?> </p>
			<? endif; ?> -->

	        <? if (isset($error)): ?>

		        <div class="alert alert-danger alert-dismissible" role="alert">
		            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		                <p> <?= $error ?> </p>
		        </div>

	        <? endif ?>




	  		<?php foreach ($addressBook as $key => $contact): ?>
				
				<tr>
					<?php foreach ($contact as $value): ?>
						<td><?= htmlspecialchars(strip_tags($value)) ?></td>
					<?php endforeach ?>
	 				<td><a href="?id=<?=$key?>"> REMOVE </a> </td>
				</tr>	
			<?php endforeach ?>
				</tr>

		</table>
    
	<hr>
    <div class="col-md-4 no-pad-left">

	<h2 class="page-header">Input Contact Information</h2>

	<form method="POST" action="/address_book2.php" role="form" class="form">
	    <div class="form-group">
	        <label for="name">Name</label>
	        <input id="name" name="name" type="text" class="form-control" placeholder="John Doe">
	    </div>
	    <div class="form-group">
	        <label for="address">Address</label>
	        <input id="address" name="address" type="text" class="form-control" placeholder="123 Main Street">
	    </div>
	    <div class="form-group">
	        <label for="city">City</label>
	        <input id="city" name="city" type="text" class="form-control" placeholder="San Antonio">
	    </div>
	    <div>
            <label>State</label><br/>
        	<select name="state" class="form-control">
	            <option value="AL">Alabama</option>
	            <option value="AK">Alaska</option>
	            <option value="AZ">Arizona</option>
	            <option value="AR">Arkansas</option>
	            <option value="CA">California</option>
	            <option value="CO">Colorado</option>
	            <option value="CT">Conneticut</option>
	            <option value="DE">Deleware</option>
	            <option value="DC">Washington DC</option>
	            <option value="FL">Florida</option>
	            <option value="GA">Georgia</option>
	            <option value="HI">Hawaii</option>
	            <option value="ID">Idaho</option>
	            <option value="IL">Illinois</option>
	            <option value="IN">Indiana</option>
	            <option value="IA">Iowa</option>
	            <option value="KS">Kansas</option>
	            <option value="KY">Kentucky</option>
	            <option value="LA">Louisiana</option>
	            <option value="ME">Maine</option>
	            <option value="MD">Maryland</option>
	            <option value="MA">Massachusetts</option>
	            <option value="MI">Michigan</option>
	            <option value="MN">Minnesota</option>
	            <option value="MS">Mississippi</option>
	            <option value="MO">Missouri</option>
	            <option value="MT">Montana</option>
	            <option value="NE">Nebraska</option>
	            <option value="NV">Nevada</option>
	            <option value="NH">New Hampshire</option>
	            <option value="NJ">New Jersey</option>
	            <option value="NM">New Mexico</option>
	            <option value="NY">New York</option>
	            <option value="NC">North Carolina</option>
	            <option value="ND">North Dakota</option>
	            <option value="OH">Ohio</option>
	            <option value="OK">Oklahoma</option>
	            <option value="OR">Oregon</option>
	            <option value="PA">Pennsylvania</option>
	            <option value="RI">Rhode Island</option>
	            <option value="SC">South Carolina</option>
	            <option value="SD">South Dakota</option>
	            <option value="TN">Tennessee</option>
	            <option value="TX">Texas</option>
	            <option value="UT">Utah</option>
	            <option value="VT">Vermont</option>
	            <option value="VA">Virginia</option>
	            <option value="WA">Washington</option>
	            <option value="WV">West Virginia</option>
	            <option value="WI">Wisconsin</option>
	            <option value="WY">Wyoming</option>
	        </select>
	    </div>
	    <div class="form-group">
	        <label for="zip">Zip</label>
	        <input id="zip" name="zip" type="text" class="form-control" placeholder="90210">
	    </div>
	    <div class="form-group">
	        <label for="phone">Phone</label>
	        <input id="phone" name="phone" type="text" class="form-control" placeholder="2105551234">
	    </div>
	    <div>
	        <input type="submit">
	    </div>
	</form>
	</div> <!--End col-md-4


</body>
</html>