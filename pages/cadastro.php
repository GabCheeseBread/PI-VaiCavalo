<?php
	$msg = "";
	if (isset($_POST["senha"]) && isset($_POST["c_senha"])) {
		$senha = $_POST["senha"];
		$c_senha = $_POST["c_senha"];
		if ($senha == $c_senha) {
			echo "peido de penis";
			header("Location: ../index.html");
			die();
		} else {
			$msg = "<p style='color:red'>Erro na confirmação de senha.</p>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Agenda VaiCavalo - Cadastro</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" href="../styles.css">
	<style>
		th {
			text-align:left;
		}
	</style>
</head>
<body>
	<div class="caixa centro">
		<a href="../index.html"><img class="logo" alt="Logotipo do VaiCavalo" src="../images/cavalo.png"></a>
	</div>
	<div class="caixa centro pequena">
		<?php
			echo $msg;
		?>
		<form method="post" action="cadastro.php">
			<table cellspacing="10%" style="margin:auto">
				<tr>
					<th scope="row"><label for="email">E-mail: </label></th>
					<td><input type="email" name="email" required></td>
				</tr>
				<tr>
					<th scope="row"><label for="nome">Nome (opcional):</label></th>
					<td><input name="nome"></td>
				</tr>
				<tr>
					<th scope="row"><label for="senha">Senha: </label></th>
					<td><input type="password" name="senha" required></td>
				</tr>
				<tr>
					<th scope="row"><label for="c_senha">Confirmar senha: </label></th>
					<td><input type="password" name="c_senha" required></td>
				</tr>
			</table>
			<input type="submit" value="Criar conta" style="width:120pt;height:40pt">
		</form>
	</div>
</body>
</html>