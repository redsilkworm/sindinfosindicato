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
	color: #1A3D80;
	font-weight: bold;
}
.letra {
	font-family: Arial;
	font-size: 13px;
	color: #2B617D;
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
<h3 class="title2">Validar Certid&atilde;o</h3>
<div id="consulta">
<form id="form1" name="form1" method="post" action="frm_adm_resultado_cons_cnpj_certidao.php">
  <label><span class="letra">Insira o n�mero do CNPJ (apenas n�meros)</span>
    <input name="cnpj" type="text" id="cnpj" size="14" maxlength="14" />
  </label>
  <label><br />
    <br />
    <span class="letra">Insira o n�mero da Certidao</span>
    <input name="certidao" type="text" id="certidao" size="14" maxlength="14" />
    <br />
    <br />
<input type="submit" name="buscar" id="buscar" value="Buscar"/>
  </label>
</form>
</div>
<br/>
<div id="voltar">
  <form id="form2" name="form2" method="post" action="index.php">
    <label>
      <input name="voltar" type=image  class="KT_topnav" id="voltar2" src="../images/voltar.png" />
    </label>
  </form>
</div>
</body>
</html>