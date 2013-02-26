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
$query_rs_cnae = "SELECT * FROM bl_cnae ORDER BY bl_cnae.cnae_classe";
$rs_cnae = mysql_query($query_rs_cnae, $sindicato) or die(mysql_error());
$row_rs_cnae = mysql_fetch_assoc($rs_cnae);
$totalRows_rs_cnae = mysql_num_rows($rs_cnae);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#form1 label {
	color: #1F497D;
}
#form2 label {
	color: #1F497D;
}
-->
</style>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <label>Código CNAE
    <select name="cnae" id="cnae">
      <?php
do {  
?>
      <option value="<?php echo $row_rs_cnae['cnae_classe']?>"<?php if (!(strcmp($row_rs_cnae['cnae_classe'], $_POST['cnae']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rs_cnae['cnae_classe']?></option>
      <?php
} while ($row_rs_cnae = mysql_fetch_assoc($rs_cnae));
  $rows = mysql_num_rows($rs_cnae);
  if($rows > 0) {
      mysql_data_seek($rs_cnae, 0);
	  $row_rs_cnae = mysql_fetch_assoc($rs_cnae);
  }
?>
    </select>
  </label>
  <label>
    <input type="text" name="cnae_desc" id="cnae_desc" value="" />
  </label>
</form>
<p>&nbsp;</p>
<form id="form2" name="form2" method="post" action="">
  <label>
    Insira o n&deg;
    CNAE: 
    <input type="text" name="nro_cnae" id="nro_cnae" />
Resultado </label>
  <label>
    <input type="text" name="resultado" id="resultado" />
  </label>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_cnae);
?>
