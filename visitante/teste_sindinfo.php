<?php require_once('../Connections/sindicato.php'); ?>
<?php
$fn = "teste_sindinfo.txt"; //abre o arquivo
$f_contents = file ($fn); // aramzena o conteudo do arquivo
$ultima_linha = end(file("teste_sindinfo.txt")); //echo 'conteudo ultima linha:'.$ultima_linha;
$sua_linha = $f_contents[0];//le apenas a linha de header
$empresa = substr($sua_linha,0,14); //armazena o cnpj para fazer pesquisa no banco
//print 'Header do arquivo: '.$sua_linha;
//inicia procedimento de procura
mysql_select_db($database_sindicato, $sindicato);//conexao com o banco
$query_rs_empresa = sprintf("SELECT * FROM bl_csind_empresa WHERE csind_emp_cnpj = '$empresa'");//echo $query_rs_empresa;
$rs_empresa = mysql_query($query_rs_empresa, $sindicato) or die(mysql_error());
$row_rs_empresa = mysql_fetch_assoc($rs_empresa);
$totalRows_rs_empresa = mysql_num_rows($rs_empresa);
//finaliza consulta
if ($row_rs_empresa['csind_emp_id']<> NULL)
	{
		echo 'empresa já cadastrada'; echo '<br />';
		$data = date('Y-m-d'); echo $data;
		$emp_id = $row_rs_empresa['csind_emp_id']; echo $emp_id;
		$ano = substr($sua_linha,15,4); echo $ano; echo "<br />";//armazena o ano
		$nome_arquivo = 'teste_sindinfo.txt'; echo $nome_arquivo;
		//cadastra a arquivo no banco
		mysql_select_db($database_sindicato, $sindicato);//conexao com o banco
		$sql = mysql_query("INSERT INTO bl_csind_arquivo(csind_arq_data,csind_emp_id,csind_arq_referencia,arquivo) VALUES('$data',$emp_id,$ano,'$nome_arquivo')"); //linha para cadastrar no banco de dados.
		//inicia procedimento de procura
		mysql_select_db($database_sindicato, $sindicato);//conexao com o banco
		$query_rs_arquivo = sprintf("SELECT * FROM bl_csind_arquivo WHERE csind_emp_id = '$emp_id' AND csind_arq_referencia = '$ano'");//echo $query_rs_empresa;
		$rs_arquivo = mysql_query($query_rs_arquivo, $sindicato) or die(mysql_error());
		$row_rs_arquivo = mysql_fetch_assoc($rs_arquivo);
		$totalRows_rs_arquivo = mysql_num_rows($rs_arquivo);
		//finaliza consulta		
		echo '<br />'; echo 'numero do arquivo'.$row_rs_arquivo['csind_arq_id']; echo '<br />';
//trabalhar aqui
		for ($registros = 1; $registros <= $ultima_linha; $registros++)
			{
				$arq_id = $row_rs_arquivo['csind_arq_id']; echo $arq_id; echo "<br />";
				$cbo = substr($f_contents[$registros],0,6); echo $cbo; echo "<br />";
				$admissao = substr($f_contents[$registros],13,4).'-'.substr($sua_linha,10,2).'-'.substr($sua_linha,8,2); echo $admissao; echo "<br />";
				$valor = substr($f_contents[$registros],18,7); echo $valor; echo "<br />";
				$colaborador = substr($f_contents[$registros],26); echo $colaborador; echo "<br />";
				mysql_select_db($database_sindicato, $sindicato);//conexao com o banco
				$sql = mysql_query("INSERT INTO bl_csind_contribuicao(csind_arq_id,csind_cont_cbo,csind_cont_admissao,csind_cont_valor,csind_cont_nome) VALUES($arq_id,'$cbo','$admissao',$valor,'$colaborador')"); echo $sql;//linha para cadastrar no banco de dados.
				echo $f_contents[$registros]; echo "<br />";
			}
			
		
	} 
	else
	{
		$cnpj = substr($sua_linha,0,14); echo $cnpj; echo "<br />";//armazena o cnpj para fazer pesquisa no banco
		$ano = substr($sua_linha,15,4); echo $ano; echo "<br />";//armazena o ano
		$razao_social = substr($sua_linha,20); echo $razao_social; echo "<br />";//armazena a razao social
		//cadastra a empresa no banco
		mysql_select_db($database_sindicato, $sindicato);//conexao com o banco
		$sql = mysql_query("INSERT INTO bl_csind_empresa(csind_emp_cnpj, csind_emp_razao) VALUES('$cnpj','$razao_social')"); //linha para cadastrar no banco de dados.
		if ($sql) // verificaçao para saber se foi cadastrado
		{ 
			echo "Cadastrado com sucesso!!";
		} 
		else // Caso de erro
		{ 
			echo "Falha ao cadastrar.".mysql_error();
		}
	}echo "<br />";
?>

<?php /*
$arquivo = fopen('teste_sindinfo.txt','r');
if ($arquivo == false) die('Nao foi possível abrir o arquivo.');
while(true) {
	$linha = fgets($arquivo);
	if ($linha==null) break;
	echo $linha;?><br /><?php
}
fclose($arquivo);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
</head>
<body>
</body>
</html>