<?php
	if (!isset($_POST["email"]) || !isset($_POST["nome"]) || !isset($_POST["senha"]) || !isset($_POST["c_senha"])) {
		echo "Erro no envio de credenciais.";
		die();
	}
	$email = $_POST["email"];
	$nome = $_POST["nome"];
	$senha = $_POST["senha"];
	$c_senha = $_POST["c_senha"];
	if ($senha != $c_senha) {
		echo "Erro na confirmação de senha.";
		die();
	}

	$conn = new mysqli("localhost","root","","vc_agenda");
	if ($conn->connect_errno) {
		die($conn->connect_error);
	}

	$q = $conn->query("SELECT * FROM usuarios");

	for ($i = 0; $i < $q->num_rows; $i++) {
		$linha = $q->fetch_assoc();
		if ($linha["email"] == $email) {
			echo "Uma conta com este e-mail já existe!";
			die();
		}
	}

	//admito que não sei se esse === TRUE é necessário
	if ($conn->query("INSERT INTO usuarios VALUES (NULL,'$email','$nome','$senha')") === TRUE) {
		echo "Sucesso";
	} else {
		echo "Erro com o banco de dados. Tente novamente mais tarde.";
	}
?>