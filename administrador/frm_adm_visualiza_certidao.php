<?php require_once('../Connections/sindicato.php'); ?>
<?php require_once('../includes/common/KT_common.php');?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_sindicato, $sindicato);
$query_rs_entidade = "SELECT * FROM bl_entidade";
$rs_entidade = mysql_query($query_rs_entidade, $sindicato) or die(mysql_error());
$row_rs_entidade = mysql_fetch_assoc($rs_entidade);
$totalRows_rs_entidade = mysql_num_rows($rs_entidade);

$certidao_rs_certidao = "-1";
if (isset($_GET['certidao'])) {
  $certidao_rs_certidao = $_GET['certidao'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_certidao = sprintf("SELECT    bl_associado.*,       bl_certidao.*,    YEAR(cer_data_validade),    MONTH(cer_data_validade),    DAY(cer_data_validade) FROM    bl_certidao INNER JOIN bl_associado ON bl_associado.ass_id = bl_certidao.ass_id WHERE    bl_certidao.cer_id = %s", GetSQLValueString($certidao_rs_certidao, "int"));
$rs_certidao = mysql_query($query_rs_certidao, $sindicato) or die(mysql_error());
$row_rs_certidao = mysql_fetch_assoc($rs_certidao);
$totalRows_rs_certidao = mysql_num_rows($rs_certidao);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body p {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
body p {
	color: #000;
}
-->
</style></head>

<body>
<p align="center"><strong>DECLARA&Ccedil;&Atilde;O DE EXCLUSIVIDADE E SEM SIMILARIDADE</strong></p>
<p align="center"><strong><?php echo $row_rs_certidao['cer_sindicato_codigo']; ?><?php printf("%04d",$row_rs_certidao['YEAR(cer_data_validade)']); ?><?php printf("%02d",$row_rs_certidao['MONTH(cer_data_validade)']); ?><?php printf("%02d",$row_rs_certidao['DAY(cer_data_validade)']); ?><?php printf("%04d",$row_rs_certidao['cer_id']); ?></strong></p>
<p>&nbsp;</p>
<p align="justify"><strong><?php echo $row_rs_entidade['ent_sigla']; ?> - <?php echo $row_rs_entidade['ent_razao_social']; ?></strong>, com sede na <?php echo $row_rs_entidade['ent_logradouro']; ?>, <?php echo $row_rs_entidade['ent_numero']; ?>, <?php echo $row_rs_entidade['ent_complemento']; ?>, Bairro <?php echo $row_rs_entidade['ent_bairro']; ?>, <?php echo $row_rs_entidade['ent_municipio']; ?>-<?php echo $row_rs_entidade['ent_uf']; ?>, declara para efeitos de comprova&ccedil;&atilde;o junto aos &oacute;rg&atilde;os governamentais, empresas p&uacute;blicas, privadas e de economia mista, que a empresa <strong><?php echo $row_rs_certidao['ass_razao_social']; ?></strong>, com sede na <?php echo $row_rs_certidao['ass_logradouro']; ?>, <?php echo $row_rs_certidao['ass_numero']; ?>, <?php echo $row_rs_certidao['ass_complemento']; ?>,  <?php echo $row_rs_certidao['ass_bairro']; ?>, <?php echo $row_rs_certidao['ass_municipio']; ?>-<?php echo $row_rs_certidao['ass_uf']; ?>, inscrita no CNPJ sob o n&deg;. <?php echo $row_rs_certidao['ass_cnpj']; ?>, &eacute; a desenvolvedora e &uacute;nica detentora dos direitos patrimoniais com exclusividade e sem similaridade, al&eacute;m de &uacute;nica empresa autorizada e capacitada a prover licen&ccedil;as de uso, suporte t&eacute;cnico e manuten&ccedil;&atilde;o do <strong><?php echo $row_rs_certidao['cer_prod_unico']; ?></strong><?php if ($row_rs_certidao['cer_prod_inf_adcionais'] <> NULL) {echo ", que &eacute; parte integrante do(a) ";}?><strong><?php echo $row_rs_certidao['cer_prod_inf_adcionais']; ?></strong>, conforme documenta&ccedil;&atilde;o apresentada e mantida nos arquivos do <?php echo $row_rs_entidade['ent_razao_social']; ?> - <?php echo $row_rs_entidade['ent_sigla']; ?>.</p>
<p>&nbsp;</p>
<p align="justify">De acordo com o <strong>Artigo 25 da Lei 8.666, de 21/06/93</strong>, o <?php echo $row_rs_entidade['ent_sigla']; ?> tem compet&ecirc;ncia para emiss&atilde;o deste tipo de declara&ccedil;&atilde;o, sendo a mesma v&aacute;lida para todo territ&oacute;rio nacional.</p>
<p align="justify">Declara&ccedil;&atilde;o v&aacute;lida at&eacute;: <?php echo KT_FormatDate($row_rs_certidao['cer_data_validade']); ?>.</p>
<p><?php echo $row_rs_certidao['ass_municipio']; ?>-<?php echo $row_rs_certidao['ass_uf']; ?>, <?php setlocale(LC_TIME, 'pt_BR.iso-8859-2');echo strftime("%A, %d de %B de %Y", strtotime($row_rs_certidao['cer_data_emissao'])); ?>.</p>






<p>&nbsp;</p>
<p align="center"><strong><?php echo $row_rs_entidade['ent_nome_presidente']; ?></strong></p>
<p align="center">Presidente</p>

</body>
</html>
<?php
mysql_free_result($rs_entidade);

mysql_free_result($rs_certidao);
?>
