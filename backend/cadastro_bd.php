<?php
	if (!isset($_POST["email"]) || !isset($_POST["nome"]) || !isset($_POST["senha"]) || !isset($_POST["c_senha"])) {
		die("Erro no envio de credenciais.");
	}
	$email = $_POST["email"];
	$nome = $_POST["nome"];
	$senha = $_POST["senha"];
	$c_senha = $_POST["c_senha"];
	if ($senha != $c_senha) {
		die("Erro na confirmação de senha.");
	}

	$conn = new mysqli("localhost","root","","vc_agenda");
	if ($conn->connect_errno) {
		die("Erro com o banco de dados. Tente novamente mais tarde.");
	}

	$q = $conn->prepare("SELECT email FROM usuarios WHERE email = ?");
	$q->bind_param("s",$email);
	$q->execute();
	$q = $q->get_result();

	if ($q->num_rows > 0) {
		die("Uma conta com este e-mail já existe!");
	}

	$q2 = $conn->prepare("INSERT INTO usuarios VALUES (NULL,?,?,?)");
	$q2->bind_param("sss",$email,$nome,$senha);

	//admito que não sei se esse === true é necessário
	if ($q2->execute() === true) {
		echo "Sucesso";
	} else {
		echo "Erro com o banco de dados. Tente novamente mais tarde.";
	}
?>