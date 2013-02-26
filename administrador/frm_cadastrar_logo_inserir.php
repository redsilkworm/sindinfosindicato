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
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE bl_associado.ass_id=%s", GetSQLValueString($associado_rs_associado, "int"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("ass_logo");
  $uploadObj->setDbFieldName("ass_logo");
  $uploadObj->setFolder("../produtos/{ass_id}/logo/");
  $uploadObj->setMaxSize(15000);
  $uploadObj->setAllowedExtensions("pdf, txt, rar, doc, jpg, bmp, gif, ico, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

// Make an update transaction instance
$upd_bl_associado = new tNG_update($conn_sindicato);
$tNGs->addTransaction($upd_bl_associado);
// Register triggers
$upd_bl_associado->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_bl_associado->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_bl_associado->registerTrigger("END", "Trigger_Default_Redirect", 99, "frm_consulta_logo.php");
$upd_bl_associado->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_bl_associado->setTable("bl_associado");
$upd_bl_associado->addColumn("ass_logo", "FILE_TYPE", "FILES", "ass_logo");
$upd_bl_associado->setPrimaryKey("ass_id", "NUMERIC_TYPE", "GET", "ass_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsbl_associado = $tNGs->getRecordset("bl_associado");
$row_rsbl_associado = mysql_fetch_assoc($rsbl_associado);
$totalRows_rsbl_associado = mysql_num_rows($rsbl_associado);
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
.letra {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
.letra {
}
#form1 .KT_tngtable tr .KT_th label {
	color: #2B617D;
}
.letra {
}
-->
</style></head>

<body>
<p class="letra">Altera&ccedil;&atilde;o de Logomarca</p>
<p align="center"><img src="../produtos/<?php echo $row_rs_associado['ass_id']; ?>/logo/<?php echo $row_rs_associado['ass_logo']; ?>" /></p>
<p align="center" class="letra">Logomarca Atual</p>
<p>&nbsp;</p>
<p class="letra">
  <?php
	echo $tNGs->getErrorMsg();
?>
</p>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="ass_logo">Logomarca:</label></td>
      <td><input type="file" name="ass_logo" id="ass_logo" size="32" />
        <?php echo $tNGs->displayFieldError("bl_associado", "ass_logo"); ?></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Salvar Altera&ccedil;&atilde;o ou Voltar" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_associado);
?>
