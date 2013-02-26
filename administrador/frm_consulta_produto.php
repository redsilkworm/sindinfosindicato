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
$query_rs_associado = "SELECT * FROM bl_associado WHERE bl_associado.ass_cadastro_ativo = 'S' ORDER BY bl_associado.ass_razao_social";
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<style type="text/css">
<!--
#consulta #form2 label {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
	font-weight: bold;
}
.letra {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
	font-weight: bold;
}
-->
</style></head>

<body>
<div id="consulta">
<form id="form2" name="form2" method="get" action="frm_relacao_produto.php">
  <label>Informe o número do CNPJ (apenas números)
    <input name="cnpj" type="text" id="cnpj" size="14" maxlength="14" />
  </label>
  <label>
    <input type="submit" name="procurar" id="procurar" value="Buscar" />
  </label>
</form>
</div>
<div id="consulta_2">
<form action="frm_relacao_produto.php" method="get" name="form1" id="form1">
  <label> <span class="letra">Ou selecione um associado</span>
<select name="associado" id="associado">
  <option value="">Selecione</option>
  <?php
do {  
?>
  <option value="<?php echo $row_rs_associado['ass_id']?>"><?php echo $row_rs_associado['ass_razao_social']?></option>
  <?php
} while ($row_rs_associado = mysql_fetch_assoc($rs_associado));
  $rows = mysql_num_rows($rs_associado);
  if($rows > 0) {
      mysql_data_seek($rs_associado, 0);
	  $row_rs_associado = mysql_fetch_assoc($rs_associado);
  }
?>
</select>
  </label>
  <label>
    <input type="submit" name="buscar" id="buscar" value="Buscar" />
  </label>
</form>
</div>
<div id="voltar">
  <form id="form2" name="form2" method="post" action="index.php">
    <label>
      <input name="voltar" type=image  class="KT_topnav" id="voltar2" src="../images/voltar.png" />
    </label>
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($rs_associado);
?>
