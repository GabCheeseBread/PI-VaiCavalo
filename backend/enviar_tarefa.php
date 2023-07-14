<?php
	if (!isset($_POST["token"]) || !isset($_POST["titulo"])) {
		die();
	}

	$conn = new mysqli("localhost","root","","vc_agenda");
	if ($conn->connect_errno) {
		die("Erro com o banco de dados. Tente novamente mais tarde.");
	}
	
	$token = $_POST["token"];

	//por usar um token aleatório, não precisa de prepared statement
	$q = $conn->query("SELECT email FROM sessoes WHERE token = '$token'");
	if ($q->num_rows <= 0) {
		die();
	}

	$email = $q->fetch_assoc()["email"];

	$titulo = $_POST["titulo"];
	$descricao = $_POST["descricao"];
	$prioridade = $_POST["prioridade"];
	$data = $_POST["data"];
	$tags = $_POST["tags"];

	$conn = new mysqli("localhost","root","","vc_agenda");
	if ($conn->connect_errno) {
		echo "Erro com o banco de dados. Tente novamente mais tarde.";
		die($conn->connect_error);
	}

	$q2 = $conn->prepare("INSERT INTO tarefas VALUES (NULL,?,?,?,?,?,?)");
	$q2->bind_param("ssssis",$email,$titulo,$descricao,$data,$prioridade,$tags);
	
	if ($q2->execute() === true) {
		die("Sucesso");
	}
?>