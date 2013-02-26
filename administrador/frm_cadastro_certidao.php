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

$associado_rs_associado = "-1";
if (isset($_POST['associado'])) {
  $associado_rs_associado = $_POST['associado'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE bl_associado.ass_id = %s", GetSQLValueString($associado_rs_associado, "int"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO bl_certidao (cer_sindicato_codigo, ass_id, cer_data_emissao, cer_data_validade, cer_prod_unico, cer_prod_inf_adcionais) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cer_sindicato_codigo'], "int"),
                       GetSQLValueString($_POST['ass_id'], "int"),
                       GetSQLValueString($_POST['cer_data_emissao'], "date"),
                       GetSQLValueString($_POST['cer_data_validade'], "date"),
                       GetSQLValueString($_POST['cer_prod_unico'], "text"),
                       GetSQLValueString($_POST['cer_prod_inf_adcionais'], "text"));

  mysql_select_db($database_sindicato, $sindicato);
  $Result1 = mysql_query($insertSQL, $sindicato) or die(mysql_error());

  $insertGoTo = "frm_adm_resultado_cons_certidoes.php?cnpj=" . $_POST['cnpj'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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
#form1 table tr td {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
.letra {
}
-->
</style></head>

<body>
<p><span class="letra"><?php echo $_POST['sindicato'];?></span> <span class="letra"><?php echo $_POST['associado'];?></span>  - <span class="letra"><?php echo $row_rs_associado['ass_razao_social']; ?></span></p>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><span class="letra">Produto Único</span>:</td>
      <td><textarea name="cer_prod_unico" cols="50" rows="5"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Informaçoes Adicionais:</td>
      <td><textarea name="cer_prod_inf_adcionais" cols="50" rows="5"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="hidden" name="cnpj" id="cnpj" value="<?php echo $_POST['cnpj'];?>"/>        <input type="submit" value="Emitir Declara&ccedil;&atilde;o" /></td>
    </tr>
  </table>
  <input type="hidden" name="cer_sindicato_codigo" value="<?php echo $_POST['sindicato'];?>" />
  <input type="hidden" name="ass_id" value="<?php echo $_POST['associado'];?>" />
  <input type="hidden" name="cer_data_emissao" value="<?php echo date("Y-m-d");?>" />
  <input type="hidden" name="cer_data_validade" value="<?php $timestamp = strtotime("+90 days");echo date('Y-m-d', $timestamp);?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="get" action="frm_adm_resultado_cons_certidoes.php?cnpj=<?php echo $_POST['cnpj']; ?>">
  <input type="hidden" name="cnpj" id="cnpj" value="<?php echo $_POST['cnpj']; ?>"/>
  <input type="submit" name="voltar" id="voltar" value="Voltar" />
</form>
<p>&nbsp;</p>

</body>
</html>
<?php
mysql_free_result($rs_associado);
?>
