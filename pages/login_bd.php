<?php
	if (!isset($_POST["email"]) || !isset($_POST["senha"])) {
		die("Login inválido.");
	}
	$email = $_POST["email"];
	$senha = $_POST["senha"];

	$conn = new mysqli("localhost","root","","vc_agenda");
	if ($conn->connect_errno) {
		echo "Erro com o banco de dados. Tente novamente mais tarde.";
		die($conn->connect_error);
	}

	$q = $conn->prepare("SELECT email, senha FROM usuarios WHERE email = ?");
	$q->bind_param("s",$email);
	$q->execute();
	$q = $q->get_result();

	$existe = false;

	for ($i = 0; $i < $q->num_rows; $i++) {
		$linha = $q->fetch_assoc();
		if ($linha["email"] === $email && $linha["senha"] === $senha) {
			$existe = true;
			break;
		}
	}
	if (!$existe) {
		die("E-mail ou senha incorretos.");
	}

	//evitar a chance microscopicamente pequena de 2 tokens serem iguais
	$token_ok = false;

	while ($token_ok == false) {
		$token = substr(bin2hex(random_bytes(20)),0,20);
		$token_ok = true;
		//esse não precisa de um prepared statement pois é sempre aleatório
		$q_sessoes = $conn->prepare("SELECT token FROM sessoes WHERE token = '$token'");
		if ($q_sessoes->num_rows > 0) {
			$token_ok = false;
			break;
		}
	}

	$validade = date("Y-m-d", strtotime("+1 week"));

	$q2 = $conn->prepare("INSERT INTO sessoes VALUES (NULL,?,?,?)");
	$q2->bind_param("sss",$token,$validade,$email);

	if ($q2->execute() === TRUE) {
		echo "Sucesso " . $token;
	} else {
		echo "Erro com o banco de dados. Tente novamente mais tarde.";
	}
?>