<?php require_once('../Connections/sindicato.php'); ?>
<?php
	function mostra_cnpj($cnpj)
	{
			$texto = substr($cnpj,0,2) . "." . substr($cnpj,2,3) . "." . substr($cnpj,5,3) . "/" . substr($cnpj,8,4) . "-" . substr($cnpj,12,2);
			echo $texto;
	}
?>
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
$formValidation->addField("tipo_prod_id", true, "numeric", "", "", "", "");
$formValidation->addField("prod_descricao", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger
//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
  $uploadObj = new tNG_FileUpload($tNG);
  $uploadObj->setFormFieldName("prod_imagem");
  $uploadObj->setDbFieldName("prod_imagem");
  $uploadObj->setFolder("../produtos/{ass_id}/produto/");
  $uploadObj->setMaxSize(15000);
  $uploadObj->setAllowedExtensions("pdf, txt, rar, doc, jpg, bmp, gif, ico, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_FileUpload trigger
?>
<?php require_once('../Connections/sindicato.php'); ?>
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
$assoc_rs_associado = "-1";
if (isset($_GET['associado'])) {
  $assoc_rs_associado = $_GET['associado'];
}
$n_cnpj_rs_associado = "Nenhum";
if (isset($_GET['cnpj'])) {
  $n_cnpj_rs_associado = $_GET['cnpj'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE ass_id = %s OR ass_cnpj = %s", GetSQLValueString($assoc_rs_associado, "int"),GetSQLValueString($n_cnpj_rs_associado, "text"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);
mysql_select_db($database_sindicato, $sindicato);
$query_rs_tipo_produto = "SELECT * FROM bl_tipo_produto WHERE bl_tipo_produto.tipo_prod_ativo = 'S' ORDER BY bl_tipo_produto.tipo_prod_descricao";
$rs_tipo_produto = mysql_query($query_rs_tipo_produto, $sindicato) or die(mysql_error());
$row_rs_tipo_produto = mysql_fetch_assoc($rs_tipo_produto);
$totalRows_rs_tipo_produto = mysql_num_rows($rs_tipo_produto);
$associado_rs_produtos = "-1";
if (isset($_GET['associado'])) {
  $associado_rs_produtos = $_GET['associado'];
}
$nro_cnpj_rs_produtos = "Nenhum";
if (isset($_GET['cnpj'])) {
  $nro_cnpj_rs_produtos = $_GET['cnpj'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_produtos = sprintf("SELECT bl_produto . * , bl_associado . * , bl_tipo_produto . * FROM bl_produto INNER JOIN bl_associado ON bl_associado.ass_id = bl_produto.ass_id INNER JOIN bl_tipo_produto ON bl_tipo_produto.tipo_prod_id = bl_produto.tipo_prod_id WHERE bl_produto.ass_id =%s OR bl_associado.ass_cnpj =%s ORDER BY bl_associado.ass_id, bl_tipo_produto.tipo_prod_descricao, bl_produto.prod_descricao", GetSQLValueString($associado_rs_produtos, "int"),GetSQLValueString($nro_cnpj_rs_produtos, "text"));
$rs_produtos = mysql_query($query_rs_produtos, $sindicato) or die(mysql_error());
$row_rs_produtos = mysql_fetch_assoc($rs_produtos);
$totalRows_rs_produtos = mysql_num_rows($rs_produtos);
mysql_select_db($database_sindicato, $sindicato);
$query_rs_tipo_produto2 = "SELECT * FROM bl_tipo_produto ORDER BY bl_tipo_produto.tipo_prod_descricao";
$rs_tipo_produto2 = mysql_query($query_rs_tipo_produto2, $sindicato) or die(mysql_error());
$row_rs_tipo_produto2 = mysql_fetch_assoc($rs_tipo_produto2);
$totalRows_rs_tipo_produto2 = mysql_num_rows($rs_tipo_produto2);
// Make an insert transaction instance
$ins_bl_produto = new tNG_insert($conn_sindicato);
$tNGs->addTransaction($ins_bl_produto);
// Register triggers
$ins_bl_produto->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_bl_produto->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_bl_produto->registerTrigger("END", "Trigger_Default_Redirect", 99, "frm_relacao_produto.php?associado={rs_associado.ass_id}");
$ins_bl_produto->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_bl_produto->setTable("bl_produto");
$ins_bl_produto->addColumn("ass_id", "NUMERIC_TYPE", "POST", "ass_id", "{rs_associado.ass_id}");
$ins_bl_produto->addColumn("tipo_prod_id", "NUMERIC_TYPE", "POST", "tipo_prod_id");
$ins_bl_produto->addColumn("prod_descricao", "STRING_TYPE", "POST", "prod_descricao");
$ins_bl_produto->addColumn("prod_imagem", "FILE_TYPE", "FILES", "prod_imagem");
$ins_bl_produto->addColumn("prod_situacao", "STRING_TYPE", "POST", "prod_situacao", "S");
$ins_bl_produto->setPrimaryKey("prod_id", "NUMERIC_TYPE");
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
.title2 {
	font-family: Arial;
	font-size: 14px;
	color: #003;
}
.title2 strong {
	font-weight: bold;
	color: #0B1862;
}
.title2 {
	font-weight: bold;
}
.title2 {
	color: #0B1862;
}
.letra {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
  color: #1F497D;
	width: 100px;
}

-->
</style></head>
<body>
<p align="center" class="title2"><strong>Cadastro de Produtos</strong></p>
<?php if ($totalRows_rs_associado > 0) { // Show if recordset not empty ?>
  <p><div class="letra" id="cor"><?php mostra_cnpj($row_rs_associado['ass_cnpj']); ?></div>
  <span class="letra"><?php echo $row_rs_associado['ass_razao_social']; ?></span></p>
  <p class="letra">
    <?php
	echo $tNGs->getErrorMsg();
?>
  </p>
  <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
    <table cellpadding="2" cellspacing="0" class="KT_tngtable">
      <tr>
        <td class="KT_th"><label for="tipo_prod_id">Tipo de Produto:</label></td>
        <td><select name="tipo_prod_id" id="tipo_prod_id">
          <?php 
do {  
?>
          <option value="<?php echo $row_rs_tipo_produto['tipo_prod_id']?>"<?php if (!(strcmp($row_rs_tipo_produto['tipo_prod_id'], $row_rsbl_produto['tipo_prod_id']))) {echo "SELECTED";} ?>><?php echo $row_rs_tipo_produto['tipo_prod_descricao']?></option>
          <?php
} while ($row_rs_tipo_produto = mysql_fetch_assoc($rs_tipo_produto));
  $rows = mysql_num_rows($rs_tipo_produto);
  if($rows > 0) {
      mysql_data_seek($rs_tipo_produto, 0);
	  $row_rs_tipo_produto = mysql_fetch_assoc($rs_tipo_produto);
  }
?>
          </select>
          <?php echo $tNGs->displayFieldError("bl_produto", "tipo_prod_id"); ?></td>
      </tr>
      <tr>
        <td class="KT_th"><label for="prod_descricao">Descriçao do Produto:</label></td>
        <td><input type="text" name="prod_descricao" id="prod_descricao" value="<?php echo KT_escapeAttribute($row_rsbl_produto['prod_descricao']); ?>" size="32" />
          <?php echo $tNGs->displayFieldHint("prod_descricao");?> <?php echo $tNGs->displayFieldError("bl_produto", "prod_descricao"); ?></td>
      </tr>
      <tr>
        <td class="KT_th"><label for="prod_imagem">Prod_imagem:</label></td>
        <td><input type="file" name="prod_imagem" id="prod_imagem" size="32" />
          <?php echo $tNGs->displayFieldError("bl_produto", "prod_imagem"); ?></td>
      </tr>
      <tr class="KT_buttons">
        <td colspan="2"><input type="submit" name="KT_Insert1" id="KT_Insert1" value="Inserir Produto" /></td>
      </tr>
    </table>
    <input type="hidden" name="ass_id" id="ass_id" value="<?php echo KT_escapeAttribute($row_rsbl_produto['ass_id']); ?>" />
    <input type="hidden" name="prod_situacao" id="prod_situacao" value="<?php echo KT_escapeAttribute($row_rsbl_produto['prod_situacao']); ?>" />
    <input type="hidden" name="associado" id="associado" value="<?php echo $row_rs_associado['ass_id']; ?>" />
  </form>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_rs_associado == 0) { // Show if recordset empty ?>
  <p class="letra">Por favor, selecione um associado.</p>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rs_produtos > 0) { // Show if recordset not empty ?>
  <table width="100%" border="1">
    <tr>
      <td class="title2">TIPO DE PRODUTO</td>
      <td class="title2">DESCRI&Ccedil;&Atilde;O</td>
      <td class="title2">IMAGEM</td>
      <td class="title2">A&Ccedil;&Atilde;O</td>
    </tr>
    <?php do { ?>
      <tr>
        <td height="112" class="letra"><?php echo $row_rs_produtos['tipo_prod_descricao']; ?></td>
        <td><a href="frm_adm_altera_produto.php?produto=<?php echo $row_rs_produtos['prod_id']; ?>&amp;associado=<?php echo $row_rs_produtos['ass_id']; ?>" class="letra"><?php echo $row_rs_produtos['prod_descricao']; ?></a></td>
        <td align="center"><img src="../produtos/<?php echo $row_rs_produtos['ass_id']; ?>/produto/<?php echo $row_rs_produtos['prod_imagem']; ?>" />          </p></td>
        <td><a href="frm_relacao_produto_deletar.php?prod_id=<?php echo $row_rs_produtos['prod_id']; ?>">Excluir registro</a></td>
      </tr>
      <?php } while ($row_rs_produtos = mysql_fetch_assoc($rs_produtos)); ?>
  </table>
<?php } // Show if recordset not empty ?>
    <?php if (($totalRows_rs_produtos == 0) and ($totalRows_rs_associado > 0)) { // Show if recordset empty ?>
<span class="letra">At&eacute; o momento n&atilde;o  h&aacute; produto cadastrado para esse associado.
  <?php } // Show if recordset empty ?>
</span><br/>
<br/>
  <form id="form2" name="form2" method="post" action="frm_consulta_produto.php 
">
    <label>
     <center> <input name="voltar" type=image  class="KT_topnav" id="voltar2" src="../images/voltar.png" /> </center>
    </label>
  </form>
</body>
</html>
<?php
mysql_free_result($rs_produtos);
mysql_free_result($rs_tipo_produto2);
mysql_free_result($rs_associado);
mysql_free_result($rs_tipo_produto);
mysql_free_result($rs_produtos);
?>