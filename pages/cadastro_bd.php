<?php
	if (!isset($_POST["email"]) || !isset($_POST["nome"]) || !isset($_POST["senha"]) || !isset($_POST["c_senha"])) {
		echo "Erro no envio de credenciais.";
		return;
	}
	$email = $_POST["email"];
	$nome = $_POST["nome"];
	$senha = $_POST["senha"];
	$c_senha = $_POST["c_senha"];
	if ($senha != $c_senha) {
		echo "Erro na confirmação de senha.";
		return;
	}
	echo "Sucesso!";
?>