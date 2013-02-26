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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE bl_associado SET ass_razao_social=%s, ass_nome_fantasia=%s, ass_cnpj=%s, ass_logradouro=%s, ass_numero=%s, ass_complemento=%s, ass_bairro=%s, ass_municipio=%s, ass_uf=%s, ass_cep=%s, ass_telefone=%s, ass_fax=%s, ass_email_empresa=%s, ass_site=%s, ass_nro_funcionarios=%s, ass_capital_social=%s, ass_optante_simples=%s, ass_nro_socios=%s, ass_ativ_principal=%s, ass_pessoa_contato=%s, ass_email_pessoa_contato=%s, ass_nome_admin_empresa=%s, ass_email_admin_empresa=%s, ass_ci_admin_empresa=%s, ass_cpf_admin_empresa=%s, ass_telefone_admin_empresa=%s, ass_senha_acesso=%s, ass_cadastro_ativo=%s, ass_pendente=%s WHERE ass_id=%s",
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
                       GetSQLValueString($_POST['ass_senha_acesso'], "text"),
                       GetSQLValueString($_POST['ass_cadastro_ativo'], "text"),
                       GetSQLValueString($_POST['ass_pendente'], "text"),
                       GetSQLValueString($_POST['ass_id'], "int"));

  mysql_select_db($database_sindicato, $sindicato);
  $Result1 = mysql_query($updateSQL, $sindicato) or die(mysql_error());

  $updateGoTo = "frm_update_cadastro_socios.php?associado=" . $_POST['ass_cnpj'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$associado_rs_associado = "Nenhum";
if (isset($_GET['cnpj'])) {
  $associado_rs_associado = $_GET['cnpj'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE bl_associado.ass_cnpj = %s", GetSQLValueString($associado_rs_associado, "text"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);

$nro_cnpj_rs_socios = "Nenhum";
if (isset($_GET['cnpj'])) {
  $nro_cnpj_rs_socios = $_GET['cnpj'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_socios = sprintf("SELECT bl_socios . * , bl_associado . * FROM bl_socios INNER JOIN bl_associado ON bl_associado.ass_id = bl_socios.ass_id WHERE bl_associado.ass_cnpj =%s ORDER BY bl_socios.soc_nome ASC", GetSQLValueString($nro_cnpj_rs_socios, "text"));
$rs_socios = mysql_query($query_rs_socios, $sindicato) or die(mysql_error());
$row_rs_socios = mysql_fetch_assoc($rs_socios);
$totalRows_rs_socios = mysql_num_rows($rs_socios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://ns.adobe.com/addt">
<head>
<link rel="stylesheet" href="../style/template.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
.letra {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
.title2 {
	font-family: Arial;
	font-size: 14px;
	color: #003;
}
.title2 {
}
.title2 {
}
.title3 {
	font-family: Arial;
	font-size: 13px;
	color: #003;
}
.title3 {
}
.title3 {
}
.letra {
}
.letra {
}
.letra {
}
#titulos {
	color: #1F497D;
}
-->
</style></head>
<body>
<div id="titulos">
  Atualiza&ccedil;&atilde;o de Cadastro do Associado
</div>
  <br/>
<?php if ($totalRows_rs_associado > 0) { // Show if recordset not empty ?>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<div id="table">
  <table width="638" align="left" cellpadding="2" cellspacing="0" class="KT_topnav" id="button2">
<td width="97" align="right">Razao Social:</td>
<td width="205" ><input type="text" name="ass_razao_social" value="<?php echo htmlentities($row_rs_associado['ass_razao_social'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
              <td width="87" " align="right">Nome de Fantasia:</td>
              <td width="231" valign="baseline"><input type="text" name="ass_nome_fantasia" value="<?php echo htmlentities($row_rs_associado['ass_nome_fantasia'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" >CNPJ:</td>
              <td><input type="text" name="ass_cnpj" value="<?php echo htmlentities($row_rs_associado['ass_cnpj'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
              <td align="right" valign="baseline" >Logradouro:</td>
              <td valign="baseline"><input type="text" name="ass_logradouro" value="<?php echo htmlentities($row_rs_associado['ass_logradouro'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" >Número:</td>
              <td><input type="text" name="ass_numero" value="<?php echo htmlentities($row_rs_associado['ass_numero'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
              <td align="right" valign="baseline">Complemento:</td>
              <td valign="baseline"><input type="text" name="ass_complemento" value="<?php echo htmlentities($row_rs_associado['ass_complemento'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">Bairro:</td>
              <td><input type="text" name="ass_bairro" value="<?php echo htmlentities($row_rs_associado['ass_bairro'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
              <td align="right" valign="baseline" >Município:</td>
              <td valign="baseline"><input type="text" name="ass_municipio" value="<?php echo htmlentities($row_rs_associado['ass_municipio'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">UF:</td>
              <td><input type="text" name="ass_uf" value="<?php echo htmlentities($row_rs_associado['ass_uf'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
              <td align="right" valign="baseline" >CEP:</td>
              <td valign="baseline"><input name="ass_cep" id="ass_cep" value="<?php echo htmlentities($row_rs_associado['ass_cep'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" wdg:subtype="MaskedInput" wdg:mask="99.999-999" wdg:restricttomask="yes" wdg:type="widget" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" >Telefone:</td>
              <td><input name="ass_telefone" id="ass_telefone" value="<?php echo htmlentities($row_rs_associado['ass_telefone'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
              <td align="right" valign="baseline">Fax:</td>
              <td valign="baseline"><input name="ass_fax" id="ass_fax" value="<?php echo htmlentities($row_rs_associado['ass_fax'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">E-mail da Empresa:</td>
<td><span id="sprytextfield1">
              <input type="text" name="ass_email_empresa" value="<?php echo htmlentities($row_rs_associado['ass_email_empresa'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
              <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido.</span></span></td>
              <td align="right" valign="baseline" >Site:</td>
              <td valign="baseline"><input type="text" name="ass_site" value="<?php echo htmlentities($row_rs_associado['ass_site'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">N&ordm; de Funcionários:</td>
              <td><input type="text" name="ass_nro_funcionarios" value="<?php echo htmlentities($row_rs_associado['ass_nro_funcionarios'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
              <td align="right" valign="baseline" >Capital Social:</td>
              <td valign="baseline"><input type="text" name="ass_capital_social" value="<?php echo htmlentities($row_rs_associado['ass_capital_social'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" > Optante do Simples Nacional:</td>
              <td><select name="ass_optante_simples">
                <option value="S" <?php if (!(strcmp("S", htmlentities($row_rs_associado['ass_optante_simples'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>>Sim</option>
                <option value="N" <?php if (!(strcmp("N", htmlentities($row_rs_associado['ass_optante_simples'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>>Nao</option>
              </select></td>
              <td align="right">Número de Sócios:</td>
              <td valign="baseline"><input type="text" name="ass_nro_socios" value="<?php echo htmlentities($row_rs_associado['ass_nro_socios'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">Atividade Principal:</td>
              <td><input type="text" name="ass_ativ_principal" value="<?php echo htmlentities($row_rs_associado['ass_ativ_principal'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
              <td align="right" >Pessoa para Contato:</td>
              <td valign="baseline"><input type="text" name="ass_pessoa_contato" value="<?php echo htmlentities($row_rs_associado['ass_pessoa_contato'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" >E-mail da Pessoa para Contato:</td>
<td><span id="sprytextfield2">
            <input type="text" name="ass_email_pessoa_contato" value="<?php echo htmlentities($row_rs_associado['ass_email_pessoa_contato'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
                <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido<br />
              </span></span></td>
              <td align="right" >Nome do Administrador:</td>
              <td valign="baseline"><input type="text" name="ass_nome_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_nome_admin_empresa'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">E-mail do Administrador: </td>
<td><span id="sprytextfield3">
              <input type="text" name="ass_email_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_email_admin_empresa'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
              <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inv&aacute;lido</span></span></td>
              <td align="right" valign="baseline">CI do Administrador:</td>
              <td valign="baseline"><input type="text" name="ass_ci_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_ci_admin_empresa'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td align="right">CPF do Administrador:</td>
<td><span id="sprytextfield4">
              <input type="text" name="ass_cpf_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_cpf_admin_empresa'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
              <span class="textfieldInvalidFormatMsg">CPF inv&aacute;lido.</span></span></td>
              <td align="right">Telefone do Administrador:</td>
              <td valign="baseline"><input name="ass_telefone_admin_empresa" id="ass_telefone_admin_empresa" value="<?php echo htmlentities($row_rs_associado['ass_telefone_admin_empresa'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
            </tr>
            <tr valign="baseline">
              <td height="30" align="right">Cadastro Ativo:</td>
              <td><input type="text" name="ass_cadastro_ativo" value="<?php echo htmlentities($row_rs_associado['ass_cadastro_ativo'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
              <td align="right" valign="baseline" >Cadastro
               Pendente:</td>
              <td valign="baseline"><input type="text" name="ass_pendente" value="<?php echo htmlentities($row_rs_associado['ass_pendente'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
            </tr>
            <tr align="right"><td colspan="4"><center><input type="submit" value="Salvar Altera&ccedil;&otilde;es" /></center></td>
      </table>
    </div>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="ass_id" value="<?php echo $row_rs_associado['ass_id']; ?>" />
  </form>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rs_associado == 0) { // Show if recordset empty ?>
  <p class="letra">Nenhum registro encontrado. Por favor, verifique as informa&ccedil;&otilde;es e tente novamente.</p>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rs_socios > 0) { // Show if recordset not empty ?>
  <p class="title2"><strong>Rela&ccedil;&atilde;o de S&oacute;cios</strong></p>
  <center><table width="591" border="1">
    <tr>
      <td width="188"><strong class="title3">Nome</strong></td>
      <td width="188"><strong class="title3">Telefone</strong></td>
      <td width="169"><strong class="title3">E-mail</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="letra"><?php echo $row_rs_socios['soc_nome']; ?></td>
        <td class="letra"><?php echo $row_rs_socios['soc_telefone']; ?></td>
        <td class="letra"><?php echo $row_rs_socios['soc_email']; ?></td>
      </tr>
      <?php } while ($row_rs_socios = mysql_fetch_assoc($rs_socios)); ?>
  </table>
  </center>
  <br/>
  <?php } // Show if recordset not empty ?>
  <div id="voltar">
<form id="form2" name="form2" method="post" action="frm_cons_cnp_atualiza_cad_associado.php">
  <center><input name="voltar" type=image  class="KT_topnav" id="voltar2" value="Voltar" src="../images/voltar.png" />
  </center>
</form>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "social_security_number", {validateOn:["change"], isRequired:false});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs_associado);

mysql_free_result($rs_socios);
?>
