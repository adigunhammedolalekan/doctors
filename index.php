<?php 
	
	$db = connect();
	
	function connect() {
		$uri = "mysql:host=localhost;dbname=doctors";
		try {
			$conn = new PDO($uri, 'root', '');
    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    		$db = $conn;
		} catch (Exception $e) {
			echo "Error => " . $e->getMessage();
		}
		return $db;
	}
	if (isset($_POST['submit'])) {

	
		$disease_name = $_POST['disease_name'];
		$disease_description = $_POST['disease_description'];
		$causes = $_POST['causes'];
		$syms = $_POST['syms'];

		$id = insertDisease($disease_name, $disease_description);
		if ($id != -1) {
			insertCauses($id, $causes);
			insertSyms($id, $syms);

			echo "<br> *** Data Insert Successfully. ***<br><br>";
		}
	}

	function insertDisease($name, $desc) {

		$db = connect();
		$query = "INSERT INTO diseases(disease_name, disease_description)VALUES(:name, :descr)";
		$stm = $db->prepare($query);
		$stm->bindValue(':name', $name);
		$stm->bindValue(':descr', $desc);
		$stm->execute();

		$id = $db->lastInsertId();
		return $id ? $id : -1;
	}

	function insertSyms($id, $syms) {

		$db = connect();
		for ($i=0; $i < count($syms); $i++) { 
			$next = $syms[$i];
			if (!empty($next)) {
				$query = "INSERT INTO symptoms(disease_id, symptoms)VALUES(:did, :syms)";
				$stm = $db->prepare($query);
				$stm->bindValue(':did', $id);
				$stm->bindValue(':syms', $next);
				$stm->execute();
			}
		}
	}

	function insertCauses($id, $causes) {
		$db = connect();
		for ($i=0; $i < count($causes); $i++) { 
			$next = $causes[$i];
			if (!empty($next)) {
				$query = "INSERT INTO disease_causes(disease_id, causes)VALUES(:did, :causes)";
				$stm = $db->prepare($query);
				$stm->bindValue(':did', $id);
				$stm->bindValue(':causes', $next);
				$stm->execute();
			}
		}
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="sc.js"></script>
</head>
<body>
<form action="index.php" method="POST">
	
<div class="form_container">
	<input name="disease_name" type="text" placeholder="Disease name"><br>
	<input type="disease_description" name="disease_description" placeholder="Disease Description"><br>
	<div id="causes_container">

		<label>Causes</label><br>
		<input type="text" name="causes[]">
		<br><a href="#" id="add_causes">ADD CAUSES</a><br><br>

	</div>

	<div id="syms_container">
		<label>Symptoms</label><br>
		<input type="text" name="syms[]">
		<br><a href="#" id="add_syms">ADD CAUSES</a><br><br>

	</div>

	<button name="submit">SUBMIT RECORD</button>
</div>

</form>
</body>
</html>