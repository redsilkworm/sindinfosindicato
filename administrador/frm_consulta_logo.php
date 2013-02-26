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
$clausula = $_POST['texto'];
$criterio = $_POST['opcoes'];
	if ($criterio == "Nenhum")
		{$condicao="";
		}
	elseif($criterio == "ass_cnpj")
		{$condicao = "WHERE ass_cnpj = $clausula";
		}
	elseif($criterio == "ass_razao")
		{$condicao = "WHERE ass_razao_social LIKE '%$clausula%'";
		}
	

mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = "SELECT * FROM bl_associado $condicao ORDER BY bl_associado.ass_razao_social";
$rs_associado = mysql_query($query_rs_associado, $sindicato) or die(mysql_error());
$row_rs_associado = mysql_fetch_assoc($rs_associado);
$totalRows_rs_associado = mysql_num_rows($rs_associado);mysql_select_db($database_sindicato, $sindicato);
$query_rs_associado = "SELECT * FROM bl_associado $condicao ORDER BY bl_associado.ass_razao_social";
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
.title2 {
	font-family: Arial;
	font-size: 14px;
	color: #003;
	font-weight: bold;
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
	font-weight: bold;
}
.letra {
}
.letra {
}
.outra {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
}
-->
</style></head>

<body>
<h3 class="title2">Cadastro de Logomarcas</h3>
<div id="consulta" style="float:left;">
<form id="form1" name="form1" method="post" action="">
  <label><span class="letra">Informe a op&ccedil;&atilde;o de busca:</span>
<select name="opcoes" id="opcoes">
  <option value="Nenhum">Todos</option>
  <option value="ass_cnpj">CNPJ</option>
  <option value="ass_razao">Raz&atilde;o Social</option>
</select>
  </label>
  <label>
    <input type="text" name="texto" id="texto" />
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
<p>&nbsp;</p>
<?php if ($totalRows_rs_associado == 0) { // Show if recordset empty ?>
  <p class="outra">Nenhum registro encontrado. Por favor verifique as informa&ccedil;&otilde;es e tente novamente.</p>
  <?php } // Show if recordset empty ?>
<?php if ($totalRows_rs_associado > 0) { // Show if recordset not empty ?>
  <table width="100%" border="1">
    <tr>
      <td width="50%"><strong class="title2">ASSOCIADA</strong></td>
      <td width="38%"><strong class="title2">LOGO</strong></td>
      <td colspan="2" align="center"><strong class="title2">A&Ccedil;&Atilde;O</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td height="174" class="letra"><?php echo $row_rs_associado['ass_razao_social']; ?></td>
        <td align="center"><p><img src="../produtos/<?php echo $row_rs_associado['ass_id']; ?>/logo/<?php echo $row_rs_associado['ass_logo']; ?>" />
          </p>
          <p class="letra">
            <?php if ($row_rs_associado['ass_logo'] == NULL){echo "Nenhuma";} else {echo $row_rs_associado['ass_logo'];} ?>
        </p></td>
        <td width="6%"><a href="frm_cadastrar_logo_inserir.php?ass_id=<?php echo $row_rs_associado['ass_id']; ?>">
          <?php if ($row_rs_associado['ass_logo'] == NULL){echo "Incluir";} else {echo "Editar";} ?>
        </a></td>
        <td width="6%">
          <?php if ($row_rs_associado['ass_logo'] == NULL){echo "Nenhuma";} else {?><a href="frm_cadastrar_logo_deletar.php?ass_id=<?php echo $row_rs_associado['ass_id']; ?>">Excluir</a><?php } ?>
        </td>
      </tr>
      <?php } while ($row_rs_associado = mysql_fetch_assoc($rs_associado)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rs_associado);
?>
