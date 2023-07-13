<?php
	if (!isset($_POST["email"]) || !isset($_POST["senha"])) {
		echo "Login inválido.";
		die();
	}
	$email = $_POST["email"];
	$senha = $_POST["senha"];

	$conn = new mysqli("localhost","root","","vc_agenda");
	if ($conn->connect_errno) {
		die($conn->connect_error);
	}

	$q = $conn->query("SELECT * FROM usuarios");
	$existe = false;

	for ($i = 0; $i < $q->num_rows; $i++) {
		$linha = $q->fetch_assoc();
		if ($linha["email"] === $email && $linha["senha"] === $senha) {
			$existe = true;
		}
	}
	if (!$existe) {
		echo "E-mail ou senha incorretos.";
		die();
	}

	//evitar a chance microscopicamente pequena de 2 tokens serem iguais
	$token_ok = false;

	while ($token_ok == false) {
		$token = substr(bin2hex(random_bytes(20)),0,20);
		$token_ok = true;
		$q_sessoes = $conn->query("SELECT * FROM sessoes");
		for ($i = 0; $i < $q_sessoes->num_rows; $i++) {
			$linha_sessoes = $q_sessoes->fetch_assoc();
			if ($linha_sessoes["token"] == $token) {
				$token_ok = false;
			}
		}
	}

	$validade = date("Y-m-d H:i:s", strtotime("+1 week"));

	if ($conn->query("INSERT INTO sessoes VALUES (NULL,'$token','$validade','$email')") === TRUE) {
		echo "Sucesso " . $token;
	} else {
		echo "Erro com o banco de dados. Tente novamente mais tarde.";
	}
?>