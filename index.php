<?php require_once('Connections/conecta.php'); ?>
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

$busca_rscnpj = "-1";
if (isset($_POST['cnpj'])) {
  $busca_rscnpj = $_POST['cnpj'];
}
mysql_select_db($database_conecta, $conecta);
$query_rscnpj = sprintf("SELECT * FROM bl_associado WHERE bl_associado.ass_cnpj = $busca_rscnpj");
$rscnpj = mysql_query($query_rscnpj, $conecta) or die(mysql_error());
$row_rscnpj = mysql_fetch_assoc($rscnpj);
$totalRows_rscnpj = mysql_num_rows($rscnpj);

if (isset($_POST['cnpj'])) {
if ($totalRows_rscnpj>0) {
	echo"maior que 0";
	 $insertGoTo = "inserearquivo.php";
	 header(sprintf("Location: %s", $insertGoTo));
  }
  else {
	  echo"MENOR que 0";
	   $insertGoTo = "cadastraempresa.php";
	   header(sprintf("Location: %s", $insertGoTo));
  }
}
if (isset($_GET['cnpj'])) {
	$insertGoTo = "inserearquivo.php";
	 header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sem título</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div>
	  <form id="form1" name="form1" method="post" action="index.php">
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td scope="col">Digite o CNPJ:</td>
	        <td scope="col"><span id="sprytextfield1">
            <label>
              <input name="cnpj" type="text" id="cnpj" maxlength="14" />
            </label>
            <span class="textfieldRequiredMsg">Um valor é necessário.</span><span class="textfieldInvalidFormatMsg">Formato inválido.</span><span class="textfieldMinCharsMsg">Número mínimo de caracteres não atendidos.</span><span class="textfieldMaxCharsMsg">Número máximo de caracteres excedidos.</span></span></td>
          </tr>
	      <tr>
	        <td scope="col">&nbsp;</td>
	        <td align="right" scope="col"><label>
	          <input type="submit" name="button" id="button" value="Buscar" />
            </label></td>
          </tr>
        </table>
      </form>
    
    </div>
	<?php echo $_POST['cnpj']; ?>
<?php echo $totalRows_rscnpj; ?>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minChars:14, maxChars:14, useCharacterMasking:true, validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($rscnpj);
?>
