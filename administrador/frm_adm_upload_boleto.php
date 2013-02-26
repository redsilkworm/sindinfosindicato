<?php require_once('../Connections/sindicato.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

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

$associado_rs_associado = "Nenhum";
if (isset($_GET['cnpj'])) {
  $associado_rs_associado = $_GET['cnpj'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE bl_associado.ass_cnpj = %s", GetSQLValueString($associado_rs_associado, "text"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);

$nro_cnpj_rs_boleto = "Nenhum";
if (isset($_GET['cnpj'])) {
  $nro_cnpj_rs_boleto = $_GET['cnpj'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_boleto = sprintf("SELECT bl_boleto . * , bl_associado . * FROM bl_boleto INNER JOIN bl_associado ON bl_associado.ass_id = bl_boleto.ass_id WHERE bl_associado.ass_cnpj = %s ORDER BY bl_boleto.bol_id DESC", GetSQLValueString($nro_cnpj_rs_boleto, "text"));
$rs_boleto = mysql_query($query_rs_boleto, $sindicato) or die(mysql_error());
$row_rs_boleto = mysql_fetch_assoc($rs_boleto);
$totalRows_rs_boleto = mysql_num_rows($rs_boleto);


// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_sindicato = new KT_connection($sindicato, $database_sindicato);

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("bol_titulo", true, "text", "", "", "", "");
$formValidation->addField("bol_endereco", true, "", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("bol_endereco");
  $uploadObj->setDbFieldName("bol_endereco");
  $uploadObj->setFolder("../boletos/{ass_id}/");
  $uploadObj->setMaxSize(15000);
  $uploadObj->setAllowedExtensions("pdf, txt, rar, doc");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger


// Make an insert transaction instance
$ins_bl_boleto = new tNG_insert($conn_sindicato);
$tNGs->addTransaction($ins_bl_boleto);
// Register triggers
$ins_bl_boleto->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_bl_boleto->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_bl_boleto->registerTrigger("END", "Trigger_Default_Redirect", 99, "frm_adm_upload_boleto.php?cnpj={POST.cnpj}");
$ins_bl_boleto->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_bl_boleto->setTable("bl_boleto");
$ins_bl_boleto->addColumn("bol_titulo", "STRING_TYPE", "POST", "bol_titulo");
$ins_bl_boleto->addColumn("ass_id", "NUMERIC_TYPE", "POST", "ass_id", "{rs_associado.ass_id}");
$ins_bl_boleto->addColumn("bol_endereco", "FILE_TYPE", "FILES", "bol_endereco");
$ins_bl_boleto->addColumn("contar", "NUMERIC_TYPE", "POST", "contar", "0");
$ins_bl_boleto->setPrimaryKey("bol_id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsbl_boleto = $tNGs->getRecordset("bl_boleto");
$row_rsbl_boleto = mysql_fetch_assoc($rsbl_boleto);
$totalRows_rsbl_boleto = mysql_num_rows($rsbl_boleto);
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
.title2 {
	font-family: Arial;
	font-size: 14px;
	color: #003;
}
.title2 strong {
	font-weight: bold;
	color: #0B1862;
	font-size: 14px;
}
.title2 {
}
.title2 {
}
.title2 {
	color: #0B1862;
}
.letra {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
.letra {
}
.letra {
}
.letra {
}
.letra {
}
#form1 .KT_tngtable tr .KT_th label {
	color: #2B617D;
}
-->
</style></head>

<body>
<p align="center" class="title2"><strong>Postagem de Arquivos para download</strong></p>
<p>&nbsp;</p>
<?php if ($totalRows_rs_boleto > 0) { // Show if recordset not empty ?>
  <p><span class="letra"><?php echo $row_rs_associado['ass_cnpj']; ?></span> - <span class="letra"><?php echo $row_rs_associado['ass_razao_social']; ?></span></p>
  <table width="100%" border="1">
    <tr>
      <td><strong class="title2">T&iacute;tulo</strong></td>
      <td><strong class="title2">Arquivo para Download</strong></td>
      <td><strong class="title2">A&ccedil;&atilde;o</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="letra"><?php echo $row_rs_boleto['bol_titulo']; ?></td>
        <td class="letra"><?php echo $row_rs_boleto['bol_endereco']; ?></td>
        <td><form id="form2" name="form2" method="get" action="frm_deleta_arquivo.php">
          <label>
            <input type="hidden" name="bol_id" id="bol_id" value="<?php echo $row_rs_boleto['bol_id']; ?>" />
            <input type="hidden" name="cnpj" id="cnpj" value="<?php echo $row_rs_associado['ass_cnpj']; ?>"/>
            <input type="submit" name="deletar" id="deletar" value="Excluir" />
          </label>
        </form></td>
      </tr>
      <?php } while ($row_rs_boleto = mysql_fetch_assoc($rs_boleto)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_rs_associado > 0) { // Show if recordset not empty ?>
  <span class="letra">
  <?php
	echo $tNGs->getErrorMsg();
?>
  </span>
  <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
    <table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td class="KT_th"><label for="bol_titulo">Título do Arquivo:</label></td>
        <td><input type="text" name="bol_titulo" id="bol_titulo" value="<?php echo KT_escapeAttribute($row_rsbl_boleto['bol_titulo']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("bol_titulo");?> <?php echo $tNGs->displayFieldError("bl_boleto", "bol_titulo"); ?></td>
      </tr>
      <tr>
        <td class="KT_th"><label for="bol_endereco">Arquivo para Upload:</label></td>
        <td><input type="file" name="bol_endereco" id="bol_endereco" size="32" />
          <?php echo $tNGs->displayFieldError("bl_boleto", "bol_endereco"); ?></td>
      </tr>
      <tr class="KT_buttons">
        <td colspan="2"><input name="cnpj" type="hidden" id="cnpj" value="<?php echo $_GET['cnpj']; ?>" />
          <input type="submit" name="KT_Insert1" id="KT_Insert1" value="Inserir Arquivo" /></td>
      </tr>
    </table>
    <input type="hidden" name="ass_id" id="ass_id" value="<?php echo KT_escapeAttribute($row_rsbl_boleto['ass_id']); ?>" />
    <input type="hidden" name="contar" id="contar" value="<?php echo KT_escapeAttribute($row_rsbl_boleto['contar']); ?>" />
  </form>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_rs_associado == 0) { // Show if recordset empty ?>
  <p>Nenhum registro encontrado. Por favor, verifique as inorma&ccedil;&otilde;es e tente novamente.</p>
  <?php } // Show if recordset empty ?>
 <br/>
 <div id="voltar">
  <form id="form2" name="form2" method="post" action="index.php">
    <label>
     <center> <input name="voltar" type=image  class="KT_topnav" id="voltar2" src="../images/voltar.png" /></center>
    </label>
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($rs_associado);

mysql_free_result($rs_boleto);
?>
