<?php require_once('../Connections/sindicato.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_sindicato = new KT_connection($sindicato, $database_sindicato);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SendEmail trigger
//remove this line if you want to edit the code by hand
function Trigger_SendEmail(&$tNG) {
  $emailObj = new tNG_Email($tNG);
  $emailObj->setFrom("{KT_defaultSender}");
  $emailObj->setTo("{rs_associado.ass_email_empresa}");
  $emailObj->setCC("");
  $emailObj->setBCC("");
  $emailObj->setSubject("Confirmaçao de Cadastro de Associado");
  //WriteContent method
  $emailObj->setContent("Prezado Sr.(a) {rs_associado.ass_nome_admin_empresa},\n\nSua solicitaçao de cadastro como associado foi realizada com sucesso. Sua senha provisória para acesso a área restrita é:{ass_senha_acesso}\n\nAtenciosamente,\n\nSINDIINFO");
  $emailObj->setEncoding("ISO-8859-1");
  $emailObj->setFormat("Text");
  $emailObj->setImportance("Normal");
  return $emailObj->Execute();
}
//end Trigger_SendEmail trigger
?>
<?php require_once('../Connections/sindicato.php'); ?>
<?php


function gerador_senha($tipo="L N L N L N")
{
    $tipo = explode(' ', $tipo);
    $padrao_letras = 'a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|x|w|y|z';
    $padrao_numeros = '0|1|2|3|4|5|6|7|8|9';
    $array_letras = explode('|', $padrao_letras);
    $array_numeros = explode('|', $padrao_numeros);
    $senha = "";
    for ($i=0; $i < count($tipo); $i++)
   {
        if ($tipo[$i] == 'L')
       {
             $senha .= $array_letras[array_rand($array_letras,1)];
        }
        else
       {
           $senha .= $array_numeros[array_rand($array_numeros,1)];
       }
    }
     return $senha;
}








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

$associado_rs_associado = "-1";
if (isset($_GET['ass_id'])) {
  $associado_rs_associado = $_GET['ass_id'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE bl_associado.ass_id = %s", GetSQLValueString($associado_rs_associado, "int"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);

// Make an update transaction instance
$upd_bl_associado = new tNG_update($conn_sindicato);
$tNGs->addTransaction($upd_bl_associado);
// Register triggers
$upd_bl_associado->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_bl_associado->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_bl_associado->registerTrigger("END", "Trigger_Default_Redirect", 99, "frm_adm_cad_pendentes.php");
$upd_bl_associado->registerTrigger("AFTER", "Trigger_SendEmail", 98);
// Add columns
$upd_bl_associado->setTable("bl_associado");
$upd_bl_associado->addColumn("ass_senha_acesso", "STRING_TYPE", "POST", "ass_senha_acesso");
$upd_bl_associado->addColumn("ass_cadastro_ativo", "STRING_TYPE", "POST", "ass_cadastro_ativo");
$upd_bl_associado->addColumn("ass_pendente", "STRING_TYPE", "POST", "ass_pendente");
$upd_bl_associado->setPrimaryKey("ass_id", "NUMERIC_TYPE", "GET", "ass_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsbl_associado = $tNGs->getRecordset("bl_associado");
$row_rsbl_associado = mysql_fetch_assoc($rsbl_associado);
$totalRows_rsbl_associado = mysql_num_rows($rsbl_associado);

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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<style type="text/css">
<!--
body p {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
.outro {
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
<table width="100%" border="1">
  <tr>
    <td><p>Solicita&ccedil;&atilde;o N&deg;: <?php echo $row_rs_associado['ass_id']; ?></p>
    <p><?php echo $row_rs_associado['ass_cnpj']; ?> - <?php echo $row_rs_associado['ass_razao_social']; ?> (<?php echo $row_rs_associado['ass_nome_fantasia']; ?>)</p>
    <p>Atividade Principal: <?php echo $row_rs_associado['ass_ativ_principal']; ?> - Empresa Optante do Simples Nacional: <?php echo $row_rs_associado['ass_optante_simples']; ?></p>
    <p><?php echo $row_rs_associado['ass_logradouro']; ?>, <?php echo $row_rs_associado['ass_numero']; ?>, <?php echo $row_rs_associado['ass_complemento']; ?>, <?php echo $row_rs_associado['ass_bairro']; ?>, <?php echo $row_rs_associado['ass_municipio']; ?>-<?php echo $row_rs_associado['ass_uf']; ?>/ CEP: <?php echo $row_rs_associado['ass_cep']; ?> / Telefone: <?php echo $row_rs_associado['ass_telefone']; ?> / Fax: <?php echo $row_rs_associado['ass_fax']; ?> / E-mail: <?php echo $row_rs_associado['ass_email_empresa']; ?> / Site:<?php echo $row_rs_associado['ass_site']; ?></p>
    <p>Informa&ccedil;&otilde;es Adicionais:</p>
    <p>N&deg; de Funcion&aacute;rios: <?php echo $row_rs_associado['ass_nro_funcionarios']; ?> - Capital Social: <?php echo $row_rs_associado['ass_capital_social']; ?> - N&deg; de S&oacute;cios: <?php echo $row_rs_associado['ass_nro_socios']; ?></p>
    <p>Contato: <?php echo $row_rs_associado['ass_pessoa_contato']; ?> / E-mail: <?php echo $row_rs_associado['ass_email_pessoa_contato']; ?></p>
    <p>Administrador: <?php echo $row_rs_associado['ass_nome_admin_empresa']; ?> / E-mail: <?php echo $row_rs_associado['ass_email_admin_empresa']; ?>/ Telefone :<?php echo $row_rs_associado['ass_telefone_admin_empresa']; ?> / CI: <?php echo $row_rs_associado['ass_ci_admin_empresa']; ?> / CPF: <?php echo $row_rs_associado['ass_cpf_admin_empresa']; ?></p>
    <p>Cadastro Ativo:<?php echo $row_rs_associado['ass_cadastro_ativo']; ?></p>
    <p>Cadastro Pendente: <?php echo $row_rs_associado['ass_pendente']; ?></p></td>
  </tr>
</table>
<br/>
<form id="form1" name="form1" method="get" action="frm_adm_revisao_cadastro_associado.php">
  <label>
    <input type="submit" name="revisar" id="revisar" value="Revisar Informa&ccedil;&otilde;es" />
    <input type="hidden" name="ass_id" id="ass_id" value="<?php echo $row_rs_associado['ass_id']; ?>"/>
  </label>
</form>
<br/>
  <span class="outro">
  <?php
	echo $tNGs->getErrorMsg();
?>
  </span>
<form method="post" id="form2" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Aceitar Cadastro" /></td>
    </tr>
  </table>
  <input type="hidden" name="ass_senha_acesso" id="ass_senha_acesso" value="<?php echo gerador_senha(); ?>" />
  <input type="hidden" name="ass_cadastro_ativo" id="ass_cadastro_ativo" value="S" />
  <input type="hidden" name="ass_pendente" id="ass_pendente" value="N" />
</form>
<br/>
<div id="voltar">
  <form id="form2" name="form2" method="post" action="index.php">
    <label>
      <input name="voltar" type=image  class="KT_topnav" id="voltar2" src="../images/voltar.png" />
    </label>
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($rs_associado);
?>
