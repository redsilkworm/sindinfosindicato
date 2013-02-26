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


$nro_certidao_rs_certidao = "-1";
if (isset($_GET['certidao'])) {
  $nro_certidao_rs_certidao = $_GET['certidao'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_certidao = sprintf("SELECT bl_certidao . * , YEAR( cer_data_validade ) , MONTH( cer_data_validade ) , DAY( cer_data_validade ) , bl_associado . * FROM bl_certidao INNER JOIN bl_associado ON bl_associado.ass_id = bl_certidao.ass_id WHERE bl_certidao.cer_id = %s", GetSQLValueString($nro_certidao_rs_certidao, "int"));
$rs_certidao = mysql_query($query_rs_certidao, $sindicato) or die(mysql_error());
$row_rs_certidao = mysql_fetch_assoc($rs_certidao);
$totalRows_rs_certidao = mysql_num_rows($rs_certidao);
if ((isset($_GET['certidao'])) && ($_GET['certidao'] != "")) {
  $deleteSQL = sprintf("DELETE FROM bl_certidao WHERE cer_id=%s",
                       GetSQLValueString($_GET['certidao'], "int"));

  mysql_select_db($database_sindicato, $sindicato);
  $Result1 = mysql_query($deleteSQL, $sindicato) or die(mysql_error());

  $deleteGoTo = "frm_adm_resultado_cons_certidoes.php?cnpj=" . $row_rs_certidao['ass_cnpj'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
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
-->
</style></head>

<body>
<span class="letra"><?php echo $_GET['certidao'];?></span> - 
<span class="letra"><?php echo $row_rs_certidao['cer_data_emissao']; ?></span>
</body>
</html>
<?php
mysql_free_result($rs_certidao);
?>
