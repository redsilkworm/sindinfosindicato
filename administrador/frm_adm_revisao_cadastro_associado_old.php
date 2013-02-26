<?php require_once('../Connections/sindicato.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

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
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE ass_id =%s", GetSQLValueString($associado_rs_associado, "int"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);

$nro_associado_rs_socios = "-1";
if (isset($_GET['ass_id'])) {
  $nro_associado_rs_socios = $_GET['ass_id'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_socios = sprintf("SELECT * FROM bl_socios WHERE ass_id =%s ORDER BY bl_socios.soc_nome ASC", GetSQLValueString($nro_associado_rs_socios, "int"));
$rs_socios = mysql_query($query_rs_socios, $sindicato) or die(mysql_error());
$row_rs_socios = mysql_fetch_assoc($rs_socios);
$totalRows_rs_socios = mysql_num_rows($rs_socios);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE bl_associado SET ass_razao_social=%s, ass_nome_fantasia=%s, ass_cnpj=%s, ass_logradouro=%s, ass_numero=%s, ass_complemento=%s, ass_bairro=%s, ass_municipio=%s, ass_uf=%s, ass_cep=%s, ass_telefone=%s, ass_fax=%s, ass_email_empresa=%s, ass_site=%s, ass_nro_funcionarios=%s, ass_capital_social=%s, ass_optante_simples=%s, ass_nro_socios=%s, ass_ativ_principal=%s, ass_pessoa_contato=%s, ass_email_pessoa_contato=%s, ass_nome_admin_empresa=%s, ass_email_admin_empresa=%s, ass_ci_admin_empresa=%s, ass_cpf_admin_empresa=%s, ass_telefone_admin_empresa=%s WHERE ass_id=%s",
                       GetSQLValueString($_POST['ass_razao_social'], "text"),
                       GetSQLValueString($_POST['ass_nome_fantasia'], "text"),
                       GetSQLValueString($_POST['ass_cnpj'], "text"),
                       GetSQLValueString($_POST['ass_logradouro'], "text"),
                       GetSQLValueString($_POST['ass_numero'], "int"),
                       GetSQLValueString($_POST['ass_complemento'], "text"),
                       GetSQLValueString($_POST['ass_bairro'], "text"),
                       GetSQLValueString($_POST['ass_municipio'], "text"),
                       GetSQLValueString($_POST['ass_uf'], "text"),
                       GetSQLValueString($_POST['ass_cep'], "text"),
                       GetSQLValueString($_POST['ass_telefone'], "text"),
                       GetSQLValueString($_POST['ass_fax'], "text"),
                       GetSQLValueString($_POST['ass_email_empresa'], "text"),
                       GetSQLValueString($_POST['ass_site'], "text"),
                       GetSQLValueString($_POST['ass_nro_funcionarios'], "int"),
                       GetSQLValueString($_POST['ass_capital_social'], "double"),
                       GetSQLValueString($_POST['ass_optante_simples'], "text"),
                       GetSQLValueString($_POST['ass_nro_socios'], "int"),
                       GetSQLValueString($_POST['ass_ativ_principal'], "text"),
                       GetSQLValueString($_POST['ass_pessoa_contato'], "text"),
                       GetSQLValueString($_POST['ass_email_pessoa_contato'], "text"),
                       GetSQLValueString($_POST['ass_nome_admin_empresa'], "text"),
                       GetSQLValueString($_POST['ass_email_admin_empresa'], "text"),
                       GetSQLValueString($_POST['ass_ci_admin_empresa'], "int"),
                       GetSQLValueString($_POST['ass_cpf_admin_empresa'], "text"),
                       GetSQLValueString($_POST['ass_telefone_admin_empresa'], "text"),
                       GetSQLValueString($_POST['ass_id'], "int"));

  mysql_select_db($database_sindicato, $sindicato);
  $Result1 = mysql_query($updateSQL, $sindicato) or die(mysql_error());

  $updateGoTo = "frm_adm_confirma_cadastro_associado.php?proposta=" . $row_rs_associado['ass_id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/MaskedInput.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<style type="text/css">
<!--
.letra {
	color: #1F497D;
}
.letra {
	color: #1F497D;
}
.letra {
	color: #1F497D;
}
.letra {
	color: #1F497D;
}
.title2 {
	color: #1A3D80;
	font-family: Arial;
}
.title2 {
	color: #1A3D80;
}
.title2 {
	color: #1A3D80;
}
.title2 {
	color: #1A3D80;
}
.titulo {
	color: #1A3D80;
	font-weight: bold;
	font-size: 14px;
}
.titulo strong {
	font-family: Arial;
	font-size: 16px;
	color: #0B1862;
}
.title2 {
	font-family: Arial;
}
.title2 strong {
	color: #0B1862;
}
.letra {
	color: #1F497D;
}
.letra {
	color: #1F497D;
}
.letra {
	color: #1F497D;
}
.letra {
	color: #1F497D;
}
.letra {
	color: #1F497D;
}
-->
</style>
</head>

<body>
<p class="letra"><?php echo $row_rs_associado['ass_cnpj']; ?>-<?php echo $row_rs_associado['ass_razao_social']; ?></p>
<p align="center" class="titulo"><strong>Rela&ccedil;&atilde;o de S&oacute;cio16</strong></p>
<p align="center" class="titulo">&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td class="title2">Nome</td>
    <td class="title2">Telefone</td>
    <td class="title2">Email</td>
    <td class="title2">A&ccedil;&atilde;o</td>
  </tr>
  <?php do { ?>
    <tr>
      <td class="letra"><?php echo $row_rs_socios['soc_nome']; ?></td>
      <td class="letra"><?php echo $row_rs_socios['soc_telefone']; ?></td>
      <td class="letra"><?php echo $row_rs_socios['soc_email']; ?></td>
      <td><form id="form2" name="form2" method="post" action="frm_adm_revisao_cadastro_socios.php">
        <label>
          <input type="hidden" name="socio" id="socio" value="<?php echo $row_rs_socios['soc_id']; ?>" />
          <input type="hidden" name="ass_id" value="<?php echo $row_rs_socios['ass_id']; ?>" />
          <input type="submit" name="alterar" id="alterar" value="Alterar" />
        </label>
      </form></td>
    </tr>
    <?php } while ($row_rs_socios = mysql_fetch_assoc($rs_socios)); ?>
</table>
<p>&nbsp;</p>
<p align="center" class="title2"><strong>Informa&ccedil;&otilde;es Cadastrais</strong></p>
<table align="center">
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Razao Social:</td>
    <td><input type="text" name="ass_razao_social" value="<?php echo htmlentities($row_rs_associado['ass_razao_social'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Nome de Fantasia:</td>
    <td><input type="text" name="ass_nome_fantasia" value="<?php echo htmlentities($row_rs_associado['ass_nome_fantasia'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td nowrap="nowrap" align="right"><span class="letra">CNPJ</span>:</td>
    <td><span id="sprytextfield1">
      <input type="text" name="ass_cnpj" value="<?php echo htmlentities($row_rs_associado['ass_cnpj'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" />
    <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">CNPJ inv&aacute;lido.</span></span></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Logradouro:</td>
    <td><input type="text" name="ass_logradouro" value="<?php echo htmlentities($row_rs_associado['ass_logradouro'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Número:</td>
    <td><input type="text" name="ass_numero" value="<?php echo htmlentities($row_rs_associado['ass_numero'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Complemento:</td>
    <td><input type="text" name="ass_complemento" value="<?php echo htmlentities($row_rs_associado['ass_complemento'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Bairro:</td>
    <td><input type="text" name="ass_bairro" value="<?php echo htmlentities($row_rs_associado['ass_bairro'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Município:</td>
    <td><input type="text" name="ass_municipio" value="<?php echo htmlentities($row_rs_associado['ass_municipio'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">UF:</td>
    <td><input type="text" name="ass_uf" value="<?php echo htmlentities($row_rs_associado['ass_uf'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">CEP:</td>
    <td><input name="ass_cep" id="ass_cep" value="<?php echo htmlentities($row_rs_associado['ass_cep'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" wdg:subtype="MaskedInput" wdg:mask="99.999-999" wdg:restricttomask="yes" wdg:type="widget" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Telefone:</td>
    <td><input name="ass_telefone" id="ass_telefone" value="<?php echo htmlentities($row_rs_associado['ass_telefone'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Fax:</td>
    <td><input name="ass_fax" id="ass_fax" value="<?php echo htmlentities($row_rs_associado['ass_fax'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">E-mail:</td>
    <td><span id="sprytextfield2">
      <input type="text" name="ass_email_empresa" value="<?php echo htmlentities($row_rs_associado['ass_email_empresa'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido</span></span></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Site:</td>
    <td><input type="text" name="ass_site" value="<?php echo htmlentities($row_rs_associado['ass_site'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Número de Funcionários:</td>
    <td><input type="text" name="ass_nro_funcionarios" value="<?php echo htmlentities($row_rs_associado['ass_nro_funcionarios'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Capital Social:</td>
    <td><input type="text" name="ass_capital_social" value="<?php echo htmlentities($row_rs_associado['ass_capital_social'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Empresa Optante do Simples Nacional:</td>
    <td><input type="text" name="ass_optante_simples" value="<?php echo htmlentities($row_rs_associado['ass_optante_simples'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Número de Sócios:</td>
    <td><input type="text" name="ass_nro_socios" value="<?php echo htmlentities($row_rs_associado['ass_nro_socios'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Atividade Principal:</td>
    <td><input type="text" name="ass_ativ_principal" value="<?php echo htmlentities($row_rs_associado['ass_ativ_principal'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Nome Pessoa para Contato:</td>
    <td><input type="text" name="ass_pessoa_contato" value="<?php echo htmlentities($row_rs_associado['ass_pessoa_contato'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">E-mail Pessoa para Contato:</td>
    <td><span id="sprytextfield3">
      <input type="text" name="ass_email_pessoa_contato" value="<?php echo htmlentities($row_rs_associado['ass_email_pessoa_contato'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido</span></span></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Nome do Administrador da Empresa:</td>
    <td><input type="text" name="ass_nome_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_nome_admin_empresa'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">E-mail do Administrador da Empresa:</td>
    <td><span id="sprytextfield4">
      <input type="text" name="ass_email_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_email_admin_empresa'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido</span></span></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">CI do Administrador da Empresa:</td>
    <td><input type="text" name="ass_ci_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_ci_admin_empresa'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">CPF do Administrador da Empresa:</td>
    <td><input type="text" name="ass_cpf_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_cpf_admin_empresa'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" /></td>
  </tr>
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="letra">Telefone do Administrador da Empresa:</td>
    <td><input name="ass_telefone_admin_empresa" id="ass_telefone_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_telefone_admin_empresa'], ENT_COMPAT, 'iso-8859-2'); ?>" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
  </tr>
  <tr valign="baseline">
    <td nowrap="nowrap" align="right">&nbsp;</td>
    <td><input type="submit" value="Salvar Altera&ccedil;&otilde;es" /></td>
  </tr>
</table>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="ass_id" value="<?php echo $row_rs_associado['ass_id']; ?>" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "custom", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs_associado);

mysql_free_result($rs_socios);
?>
