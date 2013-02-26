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

$proposta_rs_proposta = "-1";
if (isset($_GET['proposta'])) {
  $proposta_rs_proposta = $_GET['proposta'];
}
mysql_select_db($database_sindicato, $sindicato);
$query_rs_proposta = sprintf("SELECT    bl_socios.*,    bl_associado.* FROM    bl_socios INNER JOIN bl_associado ON bl_associado.ass_id = bl_socios.ass_id WHERE    bl_associado.ass_id = %s ORDER BY    bl_socios.soc_nome", GetSQLValueString($proposta_rs_proposta, "int"));
$rs_proposta = mysql_query($query_rs_proposta, $sindicato) or die(mysql_error());
$row_rs_proposta = mysql_fetch_assoc($rs_proposta);
$totalRows_rs_proposta = mysql_num_rows($rs_proposta);

$proposta = $row_rs_proposta['ass_id'];
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
	color: #000;
}
-->
</style></head>

<body>
<table border="1">
  <tr>
    <td><p class="letra"><span class="letra">N&deg; da Proposta: <?php echo $row_rs_proposta['ass_id']; ?></span></p>
    <p class="letra"><span class="letra">CNPJ: <?php echo $row_rs_proposta['ass_cnpj']; ?> -  <?php echo $row_rs_proposta['ass_razao_social']; ?>(<?php echo $row_rs_proposta['ass_nome_fantasia']; ?>)</span></p>
    <p class="letra"><span class="letra">Atividade Principal: <?php echo $row_rs_proposta['ass_ativ_principal']; ?> - Empresa Optante do Simples Nacional: <?php echo $row_rs_proposta['ass_optante_simples']; ?></span></p>
    <p class="letra"><span class="letra">Endere&ccedil;o: <?php echo $row_rs_proposta['ass_logradouro']; ?>, n&ordm;. <?php echo $row_rs_proposta['ass_numero']; ?>, <?php echo $row_rs_proposta['ass_complemento']; ?>, <?php echo $row_rs_proposta['ass_bairro']; ?>, <?php echo $row_rs_proposta['ass_municipio']; ?>-<?php echo $row_rs_proposta['ass_uf']; ?>, CEP: <?php echo $row_rs_proposta['ass_cep']; ?></span></p>
    <p class="letra"><span class="letra">Telefone: <?php echo $row_rs_proposta['ass_telefone']; ?> / Fax: <?php echo $row_rs_proposta['ass_fax']; ?> / E-mail: <?php echo $row_rs_proposta['ass_email_empresa']; ?> /  Site: <?php echo $row_rs_proposta['ass_site']; ?> </span></p>
    <p class="letra"><span class="letra">Capital Social: R$<?php echo $row_rs_proposta['ass_capital_social']; ?> </span></p>
    <p class="letra"><span class="letra"> N&uacute;mero de Funcion&aacute;rios: <?php echo $row_rs_proposta['ass_nro_funcionarios']; ?></span></p>
    <p class="letra"><span class="letra">Contato: <?php echo $row_rs_proposta['ass_pessoa_contato']; ?>/<?php echo $row_rs_proposta['ass_email_pessoa_contato']; ?></span></p>
    <p class="letra"><span class="letra">Administrador: <?php echo $row_rs_proposta['ass_nome_admin_empresa']; ?> CI: <?php echo $row_rs_proposta['ass_ci_admin_empresa']; ?> CPF: <?php echo $row_rs_proposta['ass_cpf_admin_empresa']; ?></span></p>
    <p class="letra"><span class="letra">Telefone: <?php echo $row_rs_proposta['ass_telefone_admin_empresa']; ?> E-mail: <?php echo $row_rs_proposta['ass_email_admin_empresa']; ?></span></p>
    <p class="letra"><span class="letra">N&uacute;mero de S&oacute;cios: <?php echo $row_rs_proposta['ass_nro_socios']; ?></span></p>
    <span class="letra">
    <?php do { ?>
    </MM:DECORATION></MM_REPEATEDREGION>
    </span>
    <MM_REPEATEDREGION SOURCE="@@rs@@"><MM:DECORATION OUTLINE="Repetir" OUTLINEID=1>
      <p class="letra"><span class="letra"><?php echo $row_rs_proposta['soc_nome']; ?>: <?php echo $row_rs_proposta['soc_telefone']; ?>/<?php echo $row_rs_proposta['soc_email']; ?></span></p>
      <span class="letra">
      <?php } while ($row_rs_proposta = mysql_fetch_assoc($rs_proposta)); ?>
    </span></td>
  </tr>
</table>
<br/>
<form id="form1" name="form1" method="get" action="frm_adm_revisao_cadastro_associado.php">
  <input type="hidden" name="ass_id" id="ass_id" value="<?php  echo $proposta;?>"/>
  <label>
   <center><input type="submit" name="revisao" id="revisao" value="Revisar informa&ccedil;&otilde;es" /></center>
  </label>
</form>
<br/>
<form id="form2" name="form2" method="post" action="frm_confirma_update_cad_associado.php">
  <label>
    <center><input type="submit" name="finalizar" id="finalizar" value="Finalizar" /></center>
  </label>
</form>
<p>&nbsp; </p>
</body>
</html>
<?php
mysql_free_result($rs_proposta);
?>
