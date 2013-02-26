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
  $insertSQL = sprintf("INSERT INTO bl_socios (ass_id, soc_nome, soc_telefone, soc_email, soc_ativo) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['ass_id'], "int"),
                       GetSQLValueString($_POST['soc_nome'], "text"),
                       GetSQLValueString($_POST['soc_telefone'], "text"),
                       GetSQLValueString($_POST['soc_email'], "text"),
                       GetSQLValueString($_POST['soc_ativo'], "text"));

  mysql_select_db($database_sindicato, $sindicato);
  $Result1 = mysql_query($insertSQL, $sindicato) or die(mysql_error());

  $insertGoTo = "frm_update_cadastro_socios.php?associado=" . $row_rs_associado['ass_cnpj'] . "&nro_socios=" . $row_rs_associado['ass_nro_socios'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$associado_rs_associado = "Nenhum";
if (isset($_GET['associado'])) {
  $associado_rs_associado = $_GET['associado'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = sprintf("SELECT    * FROM    bl_associado WHERE    ass_cnpj = %s", GetSQLValueString($associado_rs_associado, "text"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);

$associado_rs_socios = "Nenhum";
if (isset($_GET['associado'])) {
  $associado_rs_socios = $_GET['associado'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_socios = sprintf("SELECT bl_socios.*,    bl_associado.* FROM bl_socios INNER JOIN bl_associado ON bl_associado.ass_id = bl_socios.ass_id WHERE bl_associado.ass_cnpj = %s ORDER BY bl_socios.soc_nome", GetSQLValueString($associado_rs_socios, "text"));
$rs_socios = mysql_query($query_rs_socios, $sindicato) or die(mysql_error());
$row_rs_socios = mysql_fetch_assoc($rs_socios);
$totalRows_rs_socios = mysql_num_rows($rs_socios);
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
.titulos2 {
	color: #1F497D;
}
.titulos2 strong {
	font-family: Arial;
	color: #0B1862;
}
.letra {
	color: #1F497D;
}
.letra {
	font-family: "Arial Black", Gadget, sans-serif;
}
.text {
	color: #1F497D;
}
.text2 {
	font-family: Arial;
	color: #1F497D;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<p align="center" class="titulos2"><strong>Revis&atilde;o de Cadastro de S&oacute;cios</strong></p>
<p>&nbsp;</p>
<p></p>

<?php if ($totalRows_rs_associado > 0) { // Show if recordset not empty ?>
  <p class="text2"><?php echo $row_rs_associado['ass_cnpj']; ?> - <?php echo $row_rs_associado['ass_razao_social']; ?></p>
  <p class="text2">N&uacute;mero de S&oacute;cios: <?php echo $row_rs_associado['ass_nro_socios']; ?></p>
<?php } // Show if recordset not empty ?>
<p>&nbsp;</p>


<?php if ($totalRows_rs_socios < $row_rs_associado['ass_nro_socios']) { // mostra formulario se nro socios cadastrados for menor que o declardo no formulário anterior ?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nome:</td>
      <td><input type="text" name="soc_nome" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefone:</td>
      <td><input name="soc_telefone" id="soc_telefone" value="" size="32" wdg:subtype="MaskedInput" wdg:mask="(99)9999-9999" wdg:restricttomask="yes" wdg:type="widget" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">E-mail:</td>
      <td>
      <input type="text" name="soc_email" value="" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">E-mail inválido</span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Cadastrar s&oacute;cio" /></td>
    </tr>
  </table>
  <input type="hidden" name="ass_id" value="<?php echo $row_rs_associado['ass_id']; ?>" />
  <input type="hidden" name="soc_ativo" value="S" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<?php } // termino da condicao menor ou igual ?>



<?php if ($totalRows_rs_socios > 0) { // Show if recordset not empty ?>
  <p align="center"><strong>Rela&ccedil;&atilde;o de S&oacute;cios Cadastrados</strong></p>
  <table width="100%" border="1">
    <tr>
      <td>Nome</td>
      <td>Telefone</td>
      <td>A&ccedil;&atilde;o</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rs_socios['soc_nome']; ?></td>
        <td><?php echo $row_rs_socios['soc_telefone']; ?></td>
        <td><form id="form2" name="form2" method="post" action="frm_update_deleta_socio.php?socio=<?php echo $row_rs_socios['soc_id']; ?>">
          <label>
            <input type="submit" name="delete" id="delete" value="Excluir" />
          </label>
        </form></td>
      </tr>
      <?php } while ($row_rs_socios = mysql_fetch_assoc($rs_socios)); ?>
  </table>
  <br/>
  <form id="form3" name="form3" method="post" action="frm_adm_update_confirma_cadastro_associado.php?proposta=<?php echo $row_rs_associado['ass_id']; ?>">
    <label>
      <center><input type="submit" name="finalizar" id="finalizar" value="Finalizar altera&ccedil;&atilde;o de s&oacute;cios" /></center>
    </label>
  </form>
  <p>&nbsp;</p>
  <?php } // Show if recordset not empty ?>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rs_associado);

mysql_free_result($rs_socios);
?>
