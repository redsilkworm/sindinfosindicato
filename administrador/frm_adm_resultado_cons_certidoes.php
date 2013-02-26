<?php require_once('../Connections/sindicato.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');
?>
<?PHP require_once('../includes/common/KT_common.php');?>
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

$nro_cnpj_rs_associado = "Nenhum";
if (isset($_GET['cnpj'])) {
  $nro_cnpj_rs_associado = $_GET['cnpj'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE bl_associado.ass_cnpj = %s", GetSQLValueString($nro_cnpj_rs_associado, "text"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);

$associado_rs_certidao = "NEnhum";
if (isset($_GET['cnpj'])) {
  $associado_rs_certidao = $_GET['cnpj'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_certidao = sprintf("SELECT bl_certidao.*,       YEAR(cer_data_validade),    MONTH(cer_data_validade),    DAY(cer_data_validade), bl_associado.* FROM bl_certidao INNER JOIN bl_associado ON bl_associado.ass_id = bl_certidao.ass_id WHERE bl_associado.ass_cnpj = %s ORDER BY bl_certidao.cer_data_Validade DESC", GetSQLValueString($associado_rs_certidao, "text"));
$rs_certidao = mysql_query($query_rs_certidao, $sindicato) or die(mysql_error());
$row_rs_certidao = mysql_fetch_assoc($rs_certidao);
$totalRows_rs_certidao = mysql_num_rows($rs_certidao);

mysql_select_db($database_sindicato, $sindicato);
$query_rs_entidade = "SELECT * FROM bl_entidade";
$rs_entidade = mysql_query($query_rs_entidade, $sindicato) or die(mysql_error());
$row_rs_entidade = mysql_fetch_assoc($rs_entidade);
$totalRows_rs_entidade = mysql_num_rows($rs_entidade);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<style type="text/css">
<!--
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
.title2 {
	font-family: Arial;
	font-size: 14px;
	color: #003;
}
.title2 {
}
.title2 {
}
.title2 {
}
.title2 {
	color: #0B1862;
}
.letra {
}
-->
</style></head>
<body>
<?php if ($totalRows_rs_certidao > 0) { // Show if recordset not empty ?>
  <p><span class="letra"><?php echo $_GET['cnpj'];?></span>
  - <span class="letra"><?php echo $row_rs_certidao['ass_razao_social']; ?></span></p>
  <table width="100%" border="1">
    <tr>
      <td><strong class="title2">N&deg;Declara&ccedil;&atilde;o</strong></td>
      <td><strong class="title2">Data Validade</strong></td>
      <td><strong class="title2">Data Emiss&atilde;o</strong></td>
      <td><strong class="title2">Produto &Uacute;nico</strong></td>
      <td><strong class="title2">Açao</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="frm_adm_visualiza_certidao.php?certidao=<?php echo $row_rs_certidao['cer_id']; ?>"><?php printf("%02d",$row_rs_certidao['cer_sindicato_codigo']); ?><?php printf("%04d",$row_rs_certidao['YEAR(cer_data_validade)']); ?><?php printf("%02d",$row_rs_certidao['MONTH(cer_data_validade)']); ?><?php printf("%02d",$row_rs_certidao['DAY(cer_data_validade)']); ?><?php printf("%04d",$row_rs_certidao['cer_id']); ?></a></td>
        <td class="letra"><?php echo KT_FormatDate($row_rs_certidao['cer_data_validade']); ?></td>
        <td class="letra"><?php echo KT_FormatDate($row_rs_certidao['cer_data_emissao']); ?></td>
        <td class="letra"><?php echo $row_rs_certidao['cer_prod_unico']; ?></td>
        <td><form id="form2" name="form2" method="post" action="frm_adm_delete_certidao.php?certidao=<?php echo $row_rs_certidao['cer_id']; ?>">
          <label>
            <input type="submit" name="deletar" id="deletar" value="Excluir" />
          </label>
        </form></td>
      </tr>
      <?php } while ($row_rs_certidao = mysql_fetch_assoc($rs_certidao)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rs_certidao == 0) { // Show if recordset empty ?>
  <table width="100%" border="1">
    <tr>
      <td><p class="letra">Nenhum registro encontrado. Por favor, verifique as informa&ccedil;&otilde;es e tente novamente.</p></td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>

<?php if ($totalRows_rs_associado > 0) { // Show if recordset not empty ?>
  <form id="form3" name="form3" method="post" action="frm_cadastro_certidao.php">
    <label>
      <input type="hidden" name="associado" id="associado" value="<?php echo $row_rs_associado['ass_id']; ?>"/>
      <input type="hidden" name="sindicato" id="sindicato" value="<?php echo $row_rs_entidade['ent_codigo_findes']; ?>"/>
      <input type="hidden" name="cnpj" id="cnpj" value="<?php echo $row_rs_associado['ass_cnpj']; ?>"/>
      <br />
      <input type="submit" name="nova_certidao" id="nova_certidao" value="Emitir Certid&atilde;o" />
    </label>
  </form>
<?php } // Show if recordset not empty ?>
  <br/>
<div id="voltar">
  <form id="form2" name="form2" method="post" action="index.php">
    <label>
      <center><input name="voltar" type=image  class="KT_topnav" id="voltar2" src="../images/voltar.png" /></center>
    </label>
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($rs_certidao);

mysql_free_result($rs_entidade);

mysql_free_result($rs_associado);
?>
