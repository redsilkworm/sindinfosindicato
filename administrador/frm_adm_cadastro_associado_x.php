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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO bl_associado (ass_razao_social, ass_nome_fantasia, ass_cnpj, ass_logradouro, ass_numero, ass_complemento, ass_bairro, ass_municipio, ass_uf, ass_cep, ass_telefone, ass_fax, ass_email_empresa, ass_site, ass_nro_funcionarios, ass_capital_social, ass_optante_simples, ass_nro_socios, ass_ativ_principal, ass_pessoa_contato, ass_email_pessoa_contato, ass_nome_admin_empresa, ass_email_admin_empresa, ass_ci_admin_empresa, ass_cpf_admin_empresa, ass_telefone_admin_empresa, ass_cadastro_ativo, ass_pendente) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
                       GetSQLValueString($_POST['ass_cadastro_ativo'], "text"),
                       GetSQLValueString($_POST['ass_pendente'], "text"));

  mysql_select_db($database_sindicato, $sindicato);
  $Result1 = mysql_query($insertSQL, $sindicato) or die(mysql_error());

  $insertGoTo = "frm_adm_cadastro_socios.php?associado=" . $_POST['ass_cnpj'] . "&nro_socios=" . $_POST['ass_nro_socios'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_sindicato, $sindicato);
$query_rs_municipio = "SELECT * FROM bl_municipio ORDER BY mun_nome";
$rs_municipio = mysql_query($query_rs_municipio, $sindicato) or die(mysql_error());
$row_rs_municipio = mysql_fetch_assoc($rs_municipio);
$totalRows_rs_municipio = mysql_num_rows($rs_municipio);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/MaskedInput.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.title2 {
	font-family: Arial;
	font-size: 14px;
	color: #003;
}
#form1 table tr td {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
.title2 strong {
	color: #1A3D80;
}
.title2 strong {
	color: #0B1862;
}
-->
</style></head>

<body>
<p align="center" class="title2"><strong>Proposta de Cadastro de Associado</strong></p>
<p align="center" class="title2"><strong>Etapa 1/2 - Informa&ccedil;&otilde;es da Empresa</strong></p>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td height="28" align="right" nowrap="nowrap">Razao Social:</td>
      <td><input type="text" name="ass_razao_social" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome de Fantasia:</td>
      <td><input type="text" name="ass_nome_fantasia" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CNPJ:</td>
      <td><span id="sprytextfield5">
      <input type="text" name="ass_cnpj" value="" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Logradouro:</td>
      <td><input type="text" name="ass_logradouro" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Número:</td>
      <td><input type="text" name="ass_numero" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Complemento:</td>
      <td><input type="text" name="ass_complemento" value="sem complemento" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Bairro:</td>
      <td><input type="text" name="ass_bairro" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Município:</td>
      <td><select name="municipio" id="municipio">
        <option value="">Todos</option>
        <?php
do {  
?>
        <option value="<?php echo $row_rs_municipio['mun_nome']?>"><?php echo $row_rs_municipio['mun_nome']?></option>
        <?php
} while ($row_rs_municipio = mysql_fetch_assoc($rs_municipio));
  $rows = mysql_num_rows($rs_municipio);
  if($rows > 0) {
      mysql_data_seek($rs_municipio, 0);
	  $row_rs_municipio = mysql_fetch_assoc($rs_municipio);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">UF:</td>
      <td><input type="text" name="ass_uf" value="ES" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CEP:</td>
      <td><input name="ass_cep" id="ass_cep" value="" size="32" wdg:subtype="MaskedInput" wdg:mask="99.999-999" wdg:restricttomask="yes" wdg:type="widget" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefone:</td>
      <td><input name="ass_telefone" id="ass_telefone" value="" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fax:</td>
      <td><input name="ass_fax" id="ass_fax" value="" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">E-mail da Empresa:</td>
      <td><span id="sprytextfield1">
      <input type="text" name="ass_email_empresa" value="" size="32" />
      <span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Site:</td>
      <td>
      <input type="text" name="ass_site" value="" size="32" />
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Número de Funcionários:</td>
      <td><input type="text" name="ass_nro_funcionarios" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Capital Social:</td>
      <td><input type="text" name="ass_capital_social" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Empresa Optante do Simples Nacional:</td>
      <td><select name="ass_optante_simples">
        <option value="S" <?php if (!(strcmp("S", ""))) {echo "SELECTED";} ?>>Sim</option>
        <option value="N" <?php if (!(strcmp("N", ""))) {echo "SELECTED";} ?>>Nao</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Número de Sócios:</td>
      <td><input type="text" name="ass_nro_socios" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Atividade Principal:</td>
      <td><input type="text" name="ass_ativ_principal" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome Pessoa para Contato:</td>
      <td><input type="text" name="ass_pessoa_contato" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">E-mail Pessoa para Contato:</td>
      <td><span id="sprytextfield3">
      <input type="text" name="ass_email_pessoa_contato" value="" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome do Administrador da Empresa:</td>
      <td><input type="text" name="ass_nome_admin_empresa" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">E-mail do Administrador da Empresa:</td>
      <td><span id="sprytextfield4">
      <input type="text" name="ass_email_admin_empresa" value="" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido.</span></span></td>
      
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CI do Administrador da Empresa:</td>
      <td><input type="text" name="ass_ci_admin_empresa" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CPF do Administrador da Empresa:</td>
      <td><span id="sprytextfield6">
      <input type="text" name="ass_cpf_admin_empresa" value="" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefone do Administrador da Empresa:</td>
      <td><input name="ass_telefone_admin_empresa" id="ass_telefone_admin_empresa" value="" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Enviar informa&ccedil;&otilde;es" /></td>
    </tr>
  </table>
  <input type="hidden" name="ass_cadastro_ativo" value="N" />
  <input type="hidden" name="ass_pendente" value="S" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "url", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "email", {validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {validateOn:["change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "custom", {validateOn:["change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "social_security_number", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs_municipio);
?>
