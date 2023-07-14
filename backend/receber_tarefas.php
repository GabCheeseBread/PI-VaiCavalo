<?php
	/*die('<div class="centro caixa">

		</div>');*/
	if (!isset($_POST["sessao"])) {
		die();
	}
	$sessao = $_POST["sessao"];

	$conn = new mysqli("localhost","root","","vc_agenda");
	if ($conn->connect_errno) {
		die();
	}

	$q = $conn->prepare("SELECT token, email FROM sessoes WHERE token = ?");
	$q->bind_param("s",$sessao);
	$q->execute();
	$q = $q->get_result();

	if ($q->num_rows > 0) {
		$email = $q->fetch_assoc()["email"];
		//e-mail é legitimo, logo não é necessario um prepared statement
		$q2 = $conn->query("SELECT titulo, descricao, data, prioridade, tags FROM tarefas WHERE email = '$email'");
		$tarefas = array();
		for ($i = 0; $i < $q2->num_rows; $i++) {
			array_push($tarefas,$q2->fetch_assoc());
		}
		echo json_encode($tarefas);
	}
?>