<?php
	if (!isset($_POST["sessao"])) {
		die();
	}
	$sessao = $_POST["sessao"];

	$conn = new mysqli("localhost","root","","vc_agenda");
	if ($conn->connect_errno) {
		die($conn->connect_error);
	}

	$q = $conn->prepare("SELECT token, email FROM sessoes WHERE token = ?");
	$q->bind_param("s",$sessao);
	$q->execute();
	$q = $q->get_result();

	if ($q->num_rows > 0) {
		die("Valido " . $q->fetch_assoc()["email"]);
	}
?>