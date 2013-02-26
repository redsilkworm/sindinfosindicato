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
$formValidation->addField("ass_id", true, "numeric", "", "", "", "");
$formValidation->addField("tipo_prod_id", true, "numeric", "", "", "", "");
$formValidation->addField("prod_descricao", true, "text", "", "", "", "");
$formValidation->addField("prod_situacao", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("prod_imagem");
  $uploadObj->setDbFieldName("prod_imagem");
  $uploadObj->setFolder("{prod_id}/");
  $uploadObj->setMaxSize(1500);
  $uploadObj->setAllowedExtensions("pdf, txt, png, jpg");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger

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
$query_rs_tipo_produto = "SELECT * FROM bl_tipo_produto WHERE bl_tipo_produto.tipo_prod_ativo = 'S' ORDER BY bl_tipo_produto.tipo_prod_descricao";
$rs_tipo_produto = mysql_query($query_rs_tipo_produto, $sindicato) or die(mysql_error());
$row_rs_tipo_produto = mysql_fetch_assoc($rs_tipo_produto);
$totalRows_rs_tipo_produto = mysql_num_rows($rs_tipo_produto);

mysql_select_db($database_sindicato, $sindicato);
$query_rs_tipo_produto1 = "SELECT * FROM bl_tipo_produto WHERE bl_tipo_produto.tipo_prod_ativo = 'S' ORDER BY bl_tipo_produto.tipo_prod_descricao";
$rs_tipo_produto1 = mysql_query($query_rs_tipo_produto1, $sindicato) or die(mysql_error());
$row_rs_tipo_produto1 = mysql_fetch_assoc($rs_tipo_produto1);
$totalRows_rs_tipo_produto1 = mysql_num_rows($rs_tipo_produto1);

// Make an update transaction instance
$upd_bl_produto = new tNG_update($conn_sindicato);
$tNGs->addTransaction($upd_bl_produto);
// Register triggers
$upd_bl_produto->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_bl_produto->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_bl_produto->registerTrigger("END", "Trigger_Default_Redirect", 99, "frm_relacao_produto.php?associado={GET.associado}");
$upd_bl_produto->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_bl_produto->setTable("bl_produto");
$upd_bl_produto->addColumn("ass_id", "NUMERIC_TYPE", "POST", "ass_id");
$upd_bl_produto->addColumn("tipo_prod_id", "NUMERIC_TYPE", "POST", "tipo_prod_id");
$upd_bl_produto->addColumn("prod_descricao", "STRING_TYPE", "POST", "prod_descricao");
$upd_bl_produto->addColumn("prod_imagem", "FILE_TYPE", "FILES", "prod_imagem");
$upd_bl_produto->addColumn("prod_situacao", "STRING_TYPE", "POST", "prod_situacao");
$upd_bl_produto->setPrimaryKey("prod_id", "NUMERIC_TYPE", "GET", "produto");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsbl_produto = $tNGs->getRecordset("bl_produto");
$row_rsbl_produto = mysql_fetch_assoc($rsbl_produto);
$totalRows_rsbl_produto = mysql_num_rows($rsbl_produto);
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
.outro {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
#form1 .KT_tngtable tr .KT_th label {
	color: #2B617D;
}
-->
</style></head>

<body>
<span class="outro">
<?php
	echo $tNGs->getErrorMsg();
?>
</span>
<form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
  <table cellpadding="2" cellspacing="0" class="KT_tngtable">
    <tr>
      <td class="KT_th"><label for="tipo_prod_id">Tipo de Produto:</label></td>
      <td><select name="tipo_prod_id" id="tipo_prod_id">
        <?php 
do {  
?>
        <option value="<?php echo $row_rs_tipo_produto1['tipo_prod_id']?>"<?php if (!(strcmp($row_rs_tipo_produto1['tipo_prod_id'], $row_rsbl_produto['tipo_prod_id']))) {echo "SELECTED";} ?>><?php echo $row_rs_tipo_produto1['tipo_prod_descricao']?></option>
        <?php
} while ($row_rs_tipo_produto1 = mysql_fetch_assoc($rs_tipo_produto1));
  $rows = mysql_num_rows($rs_tipo_produto1);
  if($rows > 0) {
      mysql_data_seek($rs_tipo_produto1, 0);
	  $row_rs_tipo_produto1 = mysql_fetch_assoc($rs_tipo_produto1);
  }
?>
      </select>
        <?php echo $tNGs->displayFieldError("bl_produto", "tipo_prod_id"); ?></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="prod_descricao">Descriçao:</label></td>
      <td><input type="text" name="prod_descricao" id="prod_descricao" value="<?php echo KT_escapeAttribute($row_rsbl_produto['prod_descricao']); ?>" size="32" />
        <?php echo $tNGs->displayFieldHint("prod_descricao");?> <?php echo $tNGs->displayFieldError("bl_produto", "prod_descricao"); ?></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="prod_imagem">Imagem:</label></td>
      <td><input type="file" name="prod_imagem" id="prod_imagem" size="32" />
        <?php echo $tNGs->displayFieldError("bl_produto", "prod_imagem"); ?></td>
    </tr>
    <tr>
      <td class="KT_th"><label for="prod_situacao">Ativo:</label></td>
      <td><select name="prod_situacao" id="prod_situacao">
        <option value="S" <?php if (!(strcmp("S", KT_escapeAttribute($row_rsbl_produto['prod_situacao'])))) {echo "SELECTED";} ?>>Sim</option>
        <option value="N" <?php if (!(strcmp("N", KT_escapeAttribute($row_rsbl_produto['prod_situacao'])))) {echo "SELECTED";} ?>>Nao</option>
      </select>
        <?php echo $tNGs->displayFieldError("bl_produto", "prod_situacao"); ?></td>
    </tr>
    <tr class="KT_buttons">
      <td colspan="2"><input type="submit" name="KT_Update1" id="KT_Update1" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="ass_id" id="ass_id" value="<?php echo KT_escapeAttribute($row_rsbl_produto['ass_id']); ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_tipo_produto);

mysql_free_result($rs_tipo_produto1);
?>
