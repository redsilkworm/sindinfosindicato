<?php
	$arq = "..\var\www\sindicatos\produtos\28\logo28\baptismaMain.jpg";
	if (!unlink($arq))
{
  echo ("Erro ao deletar $arq");
}
else
{
  echo ("Deletado $arq com sucesso!");
}
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

$associado_rs_associado = "-1";
if (isset($_GET['ass_id'])) {
  $associado_rs_associado = $_GET['ass_id'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = sprintf("SELECT * FROM bl_associado WHERE bl_associado.ass_id=%s", GetSQLValueString($associado_rs_associado, "int"));
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
</head>

<body>
<p align="center"><img src="../produtos/<?php echo $row_rs_associado['ass_id']; ?>/logo/<?php echo $row_rs_associado['ass_logo']; ?>" width="71" height="90" />
</p>
<p align="center">logomarca Atual</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_associado);
?>
