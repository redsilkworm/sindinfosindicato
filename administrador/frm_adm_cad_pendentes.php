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

mysql_select_db($database_sindicato, $sindicato);
$query_rs_pendentes = "SELECT * FROM bl_associado WHERE ass_cadastro_ativo = 'N' AND ass_pendente = 'S' ORDER BY ass_razao_social";
$rs_pendentes = mysql_query($query_rs_pendentes, $sindicato) or die(mysql_error());
$row_rs_pendentes = mysql_fetch_assoc($rs_pendentes);
$totalRows_rs_pendentes = mysql_num_rows($rs_pendentes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="../style/template.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.outra {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
.outra {
}
.letra {
	font-family: Arial;
	font-size: 14px;
	color: #2B617D;
}
.titles2 {
	font-family: Arial;
	font-size: 14px;
	color: #0B1862;
}
#titulos {
	color: #1A3D80;
}
#titulos {
	color: #0B1862;
}
-->
</style></head>

<body>
<div id="titulos">
Regulariza&ccedil;&atilde;o de Cadastro de Associado
</div>

<?php if ($totalRows_rs_pendentes > 0) { // Show if recordset not empty ?>
  <table width="100%" border="1">
    <tr>
      <td><strong class="letra"><span class="titles2">RAZ&Atilde;O SOCIAL</span></strong></td>
      <td><strong class="letra"><span class="titles2">CNPJ</span></strong></td>
      <td><strong class="letra"><span class="titles2">LOCALIDADE</span></strong></td>
      <td colspan="2"><strong class="letra"><span class="titles2">A&Ccedil;&Atilde;O</span></strong> </td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="outra"><?php echo $row_rs_pendentes['ass_razao_social']; ?></td>
        <td class="outra"><?php echo $row_rs_pendentes['ass_cnpj']; ?></td>
        <td><span class="outra"><?php echo $row_rs_pendentes['ass_municipio']; ?></span>-<span class="outra"><?php echo $row_rs_pendentes['ass_uf']; ?></span></td>
        <td><form id="form1" name="form1" method="get" action="frm_adm_aceitar_associado.php">
          <label>
            <input type="hidden" name="ass_id" id="ass_id" value="<?php echo $row_rs_pendentes['ass_id']; ?>" />
            <input type="submit" name="aceitar" id="aceitar" value="Aceitar" />
            </label>
        </form></td>
        <td><form id="form2" name="form2" method="post" action="frm_adm_deletar_associado.php">
          <label>
            <input type="hidden" name="associado" id="associado" value="<?php echo $row_rs_pendentes['ass_id']; ?>" />
            <input type="submit" name="deletar" id="deletar" value="Excluir" />
            </label>
        </form></td>
      </tr>
      <?php } while ($row_rs_pendentes = mysql_fetch_assoc($rs_pendentes)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
<?php if ($totalRows_rs_pendentes == 0) { // Show if recordset empty ?>
  <p class="outra">At&eacute; o momento, n&atilde;o h&aacute; Propostas de Cadastro de Associados aguardando libera&ccedil;&atilde;o.</p>
  <?php } // Show if recordset empty ?>
  
<form id="form2" name="form2" method="post" action="index.php">
 <center> <input name="voltar" type=image  class="KT_topnav" id="voltar" value="Voltar" src="../images/voltar.png" /> </center>
</form>
</body>
</html>
<?php
mysql_free_result($rs_pendentes);
?>
