<?php

//CONSTANTES - dados de conexão
define('HOSTNAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '123456');
define('DATABASE', 'maestro');
define('PORT', '3306');

//VARIÁVEIS GLOBAIS

$link = '';

principal();

function principal(){

	$conectou = conexao();

	if($conectou){
		while(true){
			menu();
		}
	} else {
		echo "ERRO: Falha ao conectar no BD.";
	}
}

function menu(){
	echo "MENU\n";
	echo "1. Veiculos\n";
	echo "2. Clientes\n";
	echo "3. Contratos\n";
	echo "0. Sair\n";


	$opcao = readline("Informe a opção selecionada: \n");
	switch($opcao){
		

		/* case 1: { 
			listar();
 		}      Mesma função  */


		case 1:{veiculos(); break; }
		case 2:{clientes(); break;}
		case 3:{contratos(); break;}
		case 0: {sair(); break;}
		default:{
			echo "Informe opção válida!";
		}
	}
}


function veiculos(){
	echo "VEICULOS\n";
	echo "1. Listar\n";
	echo "2. Novo\n";
	echo "3. Editar\n";
	echo "4. Apagar\n";
	echo "5. Pesquisar\n";
	echo "0. Sair\n";


	$opcao = readline("Informe a opção selecionada: \n");
	switch($opcao){
		

		/* case 1: { 
			listar();
 		}      Mesma função  */


		case 1:{listar_veiculos(); break; }
		case 2:{novo_veiculos(); break;}
		case 3:{editar_veiculos(); break;}
		case 4:{apagar_veiculos(); break;}
		case 5: {pesquisar_veiculos(); break;}
		case 0: {sair(); break;}
		default:{
			echo "Informe opção válida!";
		}
	}
}



function clientes(){
	echo "CLIENTES\n";
	echo "1. Listar\n";
	echo "2. Novo\n";
	echo "3. Editar\n";
	echo "4. Apagar\n";
	echo "5. Pesquisar\n";
	echo "0. Sair\n";


	$opcao = readline("Informe a opção selecionada: \n");
	switch($opcao){
		

		/* case 1: { 
			listar();
 		}      Mesma função  */


		case 1:{listar_clientes(); break; }
		case 2:{novo_clientes(); break;}
		case 3:{editar_clientes(); break;}
		case 4:{apagar_clientes(); break;}
		case 5: {pesquisar_clientes(); break;}
		case 0: {sair(); break;}
		default:{
			echo "Informe opção válida!";
		}
	}
}


function contratos(){
	echo "CONTRATOS\n";
	echo "1. Listar\n";
	echo "2. Novo\n";
	echo "3. Pesquisar\n";
	echo "0. Sair\n";


	$opcao = readline("Informe a opção selecionada: \n");
	switch($opcao){
		

		/* case 1: { 
			listar();
 		}      Mesma função  */


		case 1:{listar_contratos(); break; }
		case 2:{novo_contratos(); break;}
		case 3: {pesquisar_contratos(); break;}
		case 0: {sair(); break;}
		default:{
			echo "Informe opção válida!";
		}
	}
}




function listar_veiculos(){

	global $link; 
	
	$sql = "select * from veiculos;";

	$resultado = mysqli_query($link, $sql);

	echo str_pad('-', 36, '-', STR_PAD_RIGHT) . "\n";

	echo str_pad('ID', 3, ' ', STR_PAD_RIGHT) . '|' . str_pad('MODELO', 20, ' ', STR_PAD_RIGHT) . '|' . str_pad('ANO', 10, ' ', STR_PAD_RIGHT) . '|' . str_pad('VALOR DE COMPRA', 10, ' ', STR_PAD_RIGHT) . '|' . str_pad('VALOR DE VENDA', 10, ' ', STR_PAD_RIGHT) . "|\n";

	while($linha = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
		echo str_pad((string)$linha['id'], 3, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['modelo'], 20, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['ano'], 10, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['venda'], 10, ' ', STR_PAD_LEFT) . '|' . str_pad((string)$linha['compra'], 10, ' ', STR_PAD_LEFT) . "|\n";
	} 	
	echo str_pad('-', 36, '-', STR_PAD_RIGHT) . "\n";
	
}

function editar_veiculos(){

	global $link;

	$id = readline("Informe o ID para edição: ");

	$sql = "select * from veiculos where id = '$id' LIMIT 1;";

	$retorno = mysqli_query($link, $sql);

	$linha = mysqli_fetch_row($retorno);

	print_r($linha);

	echo "\nAtualize os dados \n";
	echo "MODELO: " . $linha[1] . "\n";
	$modelo = readline("Informe o modelo do veículo: ");	
	if($modelo == ''){
		$modelo = $linha[1];
	}

	echo 'ANO: ' . $linha[2] . "\n";
	$ano = readline("Informe o ano do veículo: ");	
	if($ano == ''){
		$ano = $linha[2];
	}

	echo 'VALOR DE COMPRA: ' . $linha[3] . "\n";
	$valor_compra = readline("Informe o preço do veículo: ");	
	if($valor_compra == ''){
		$valor_compra = $linha[3];
	}

	echo 'VALOR DE VENDA: ' . $linha[4] . "\n";
	$valor_venda = readline("Informe o preço do veículo: ");	
	if($valor_venda == ''){
		$valor_venda = $linha[4];
	}

	$sql = "update veiculos set modelo = '$modelo', ano = '$ano', compra = '$valor_compra', venda = '$valor_venda' where id = '$id';";

	$resultado = mysqli_query($link, $sql);
	if ($resultado){
		echo "\n Dados Alterados do ID: $id \n";
	} else {
		echo "\n Nenhum dado alterado do ID: $id \n";
		
	}

}

function novo_veiculos(){

	global $link;

	$modelo = readline("Informe o modelo do veículo: \n");
	$ano = readline("Informe o ano do veículo: \n");
	$valor_compra = readline("Informe o valor de compra do veículo: \n");
	$valor_venda = readline("Informe o valor de venda do veículo: \n");

	$sql = "insert into veiculos(`modelo`, `ano`, `compra`, `venda`) values('$modelo', '$ano', '$compra', '$venda');";
	
	$result = mysqli_query($link, $sql);
	
	if($result){
		$id = mysqli_insert_id($link);
		echo "\nCriado o registro $id\n";
	}else{
		echo "\nFalha ao inserir na tabela!\n";
	}
}


function apagar_veiculos(){

	global $link;

	$id = readline("Informe o ID para apagar: ");

	$sql = "select * from veiculos where id = '$id' LIMIT 1;";

	$retorno = mysqli_query($link, $sql);

	if($retorno){
		$sql = "delete from veiculos where id = '$id';";	
		$resultado = mysqli_query($link, $sql);
		if($resultado){
			echo "\n Id excluído. \n";		
		}else{ 
			echo "\n ERRO: Falha ao excluir. \n";
		}
	}else{
		echo "\n Não localizado. \n";	
	} 	
}

function pesquisar_veiculos(){

	global $link;

	$modelo = readline ("Insira um modelo para pesquisar: ");
	
	$sql = "select * from veiculos where modelo like '%$modelo%'";

	$resultado = mysqli_query($link, $sql);

	if($resultado){

		if ($resultado->num_rows>0){

			echo str_pad('ID', 3, ' ', STR_PAD_RIGHT) . '|' . str_pad('MODELO', 20, ' ', STR_PAD_RIGHT) . '|' . str_pad('ANO', 10, ' ', STR_PAD_RIGHT) . '|' . str_pad('VALOR DE COMPRA', 10, ' ', STR_PAD_RIGHT) . '|' . str_pad('VALOR DE VENDA', 10, ' ', STR_PAD_RIGHT) . "|\n";

	while($linha = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
		echo str_pad((string)$linha['id'], 3, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['modelo'], 20, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['ano'], 10, ' ', STR_PAD_LEFT) . '|' . str_pad((string)$linha['venda'], 10, ' ', STR_PAD_LEFT) . '|' . str_pad((string)$linha['compra'], 10, ' ', STR_PAD_LEFT) . "\n";

			} 	
		} else {
		echo "\n Nenhum resultado encontrado com o termo: $modelo . \n";
		}
	} else {
		echo "\n ERRO: Falha na execução. \n";
	}
}




function listar_clientes(){

	global $link; 
	
	$sql = "select * from clientes;";

	$resultado = mysqli_query($link, $sql);

	echo str_pad('-', 36, '-', STR_PAD_RIGHT) . "\n";

	echo str_pad('ID', 3, ' ', STR_PAD_RIGHT) . '|' . str_pad('NOME', 20, ' ', STR_PAD_RIGHT) . '|' . str_pad('CPF', 10, ' ', STR_PAD_RIGHT) . '|' . str_pad('DATA DE NASCIMENTO', 10, ' ', STR_PAD_RIGHT) . "|\n";

	while($linha = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
		echo str_pad((string)$linha['id'], 3, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['nome'], 20, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['cpf'], 10, ' ', STR_PAD_LEFT) . '|' . str_pad((string)$linha['nascimento'], 10, ' ', STR_PAD_LEFT) . "\n";

	} 	
	
	echo str_pad('-', 36, '-', STR_PAD_RIGHT) . "\n";
	
}



function editar_clientes(){

	global $link;

	$id = readline("Informe o ID para edição: ");

	$sql = "select * from clientes where id = '$id' LIMIT 1;";

	$retorno = mysqli_query($link, $sql);

	$linha = mysqli_fetch_row($retorno);

	print_r($linha);

	echo "\nAtualize os dados \n";
	echo "NOME: " . $linha[1] . "\n";
	$nome = readline("Informe o nome do cliente: ");	
	if($nome == ''){
		$nome = $linha[1];
	}

	echo 'CPF: ' . $linha[2] . "\n";
	$cpf = readline("Informe o cpf do cliente: ");	
	if($cpf == ''){
		$cpf = $linha[2];
	}
	
	echo 'NASCIMENTO: ' . $linha[3] . "\n";
	$nascimento = readline("Informe a data de nascimento do cliente: ");	
	if($nascimento == ''){
		$nascimento = $linha[3];
	}

	$sql = "update clientes set nome = '$nome', cpf = '$cpf', nascimento = '$nascimento' where id = '$id';";

	$resultado = mysqli_query($link, $sql);
	if ($resultado){
		echo "\n Dados Alterados do ID: $id \n";
	} else {
		echo "\n Nenhum dado alterado do ID: $id \n";
		
	}

}

function novo_clientes(){

	global $link;

	$nome = readline("Informe o nome do cliente: \n");
	$cpf = readline("Informe o cpf do cliente: \n");
	$nascimento = readline("Informe a data de nascimento do cliente: \n");

	$sql = "insert into clientes(`nome`, `cpf`, `nascimento`) values ('$nome', '$cpf', '$nascimento')";
	
	$result = mysqli_query($link, $sql);
	
	if($result){
		$id = mysqli_insert_id($link);
		echo "\nCriado o registro $id\n";
	} else {
		echo "\nFalha ao inserir na tabela!\n";
	}
}


function apagar_clientes(){

	global $link;

	$id = readline("Informe o ID para apagar: ");

	$sql = "select * from clientes where id = '$id' LIMIT 1;";

	$retorno = mysqli_query($link, $sql);

	if($retorno){
		$sql = "delete from clientes where id = '$id';";	
		$resultado = mysqli_query($link, $sql);
		if($resultado){
			echo "\n Id excluído. \n";		
		}else{ 
			echo "\n ERRO: Falha ao excluir. \n";
		}
	}else{
		echo "\n Não localizado. \n";	
	} 	
}

function pesquisar_clientes(){

	global $link;

	$nome = readline ("Insira um nome para pesquisar: ");
	
	$sql = "select * from clientes where nome like '%$nome%'";

	$resultado = mysqli_query($link, $sql);

	if($resultado){

		if ($resultado->num_rows>0){

			echo str_pad('ID', 3, ' ', STR_PAD_RIGHT) . '|' . str_pad('NOME', 20, ' ', STR_PAD_RIGHT) . "|" . str_pad('CPF', 10, ' ', STR_PAD_RIGHT) . str_pad('DATA DE NASCIMENTO', 10, ' ', STR_PAD_RIGHT) . "|\n";

			while($linha = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
			echo str_pad((string)$linha['id'], 3, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['nome'], 20, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['cpf'], 10, ' ', STR_PAD_LEFT) . str_pad((string)$linha['nascimento'], 10, ' ', STR_PAD_LEFT) ."|\n";

			} 	
		} else {
		echo "\n Nenhum resultado encontrado com o termo: $nome . \n";
		}
	} else {
		echo "\n ERRO: Falha na execução. \n";
	}
}


function listar_contratos(){

	global $link; 
	
	$sql = "select * from contratos;";

	$resultado = mysqli_query($link, $sql);

	echo str_pad('-', 36, '-', STR_PAD_RIGHT) . "\n";

	echo str_pad('ID', 3, ' ', STR_PAD_RIGHT) . '|' . str_pad('NOME DO CLIENTE', 40, ' ', STR_PAD_RIGHT) . str_pad('MODELO DO VEÍCULO', 40, ' ', STR_PAD_RIGHT) . "|\n";

	while($linha = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
		echo str_pad((string)$linha['id'], 3, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['id_cliente'], 50, ' ', STR_PAD_RIGHT) . str_pad((string)$linha['id_veiculo'], 50, ' ', STR_PAD_RIGHT) . "\n";

	} 	
	
	echo str_pad('-', 36, '-', STR_PAD_RIGHT) . "\n";
	
}

function novo_contratos(){

	global $link;

	$id_cliente = readline("Informe o ID do cliente: \n");
	$id_veiculo = readline("Informe o ID do veículo: \n");
	$descricao = readline("Iforme a descrição do contrato: \n");

	$veiculos_contrato = "select modelo from veiculos where modelo = '$id_veiculo';";
	$clientes_contrato = "select nome from clientes where nome = '$id_cliente';";

	$sql = "insert into contratos(`id_cliente`, `id_veiculo`, `descricao`)values('$clientes_contrato', '$veiculos_contrato', '$descricao')";
	
	$result = mysqli_query($link, $veiculos_contrato, $clientes_contrato, $descrição);
	
	if($result){
	$id = mysqli_insert_id($link);
	echo "\nCriado o registro $id\n";
	}else{
		echo "\nFalha ao inserir na tabela!\n";
	}
}

function pesquisar_contratos(){

	global $link;

	$id = readline ("Insira um ID: ");
	
	$sql = "select * from contratos where id = '$id';";

	$resultado = mysqli_query($link, $sql);

	if($resultado){

		if ($resultado->num_rows>0){

			echo str_pad('ID', 3, ' ', STR_PAD_RIGHT) . '|' . str_pad('NOME DO CLIENTE', 50, ' ', STR_PAD_RIGHT) . str_pad('MODELO DO VEÍCULO', 50, ' ', STR_PAD_RIGHT) . str_pad('DESCRIÇÃO', 50, ' ', STR_PAD_RIGHT) . "|\n";

			while($linha = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){
			echo str_pad((string)$linha['id'], 3, ' ', STR_PAD_RIGHT) . '|' . str_pad((string)$linha['id_cliente'], 50, ' ', STR_PAD_RIGHT) . str_pad((string)$linha['id_veiculo'], 50, ' ', STR_PAD_RIGHT) . str_pad((string)$linha['descricao'], 50, ' ', STR_PAD_RIGHT) . "\n";

			} 	
		} else {
		echo "\n Nenhum resultado encontrado com o termo: $id . \n";
		}
	} else {
		echo "\n ERRO: Falha na execução. \n";
	}
}







function sair(){

	echo "\nSaindo do sistema\n";
	exit();

}

function conexao(){

	global $link;
	$link = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE, PORT);

	if($link){
		return true;
	}else{
		return false;	
	}
}