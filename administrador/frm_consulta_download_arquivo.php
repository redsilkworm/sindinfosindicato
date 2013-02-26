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
	font-weight: bold;
}
-->
</style></head>

<body>
<div id="consulta" style="float:left;">
<form id="form1" name="form1" method="get" action="frm_adm_download_arquivo.php">
  <label><span class="letra">Insira o número do CNPJ (apenas números)</span>
    <input type="text" name="cnpj" id="cnpj" />
  </label>
  <label>
    <input type="submit" name="buscar" id="buscar" value="buscar" />
  </label>
</form>
</div>
<div id="voltar">
  <form id="form2" name="form2" method="post" action="index.php">
    <label>
        <input name="voltar" type=image  class="KT_topnav" id="voltar" src="../images/voltar.png" />
    </label>
  </form>
</div>
</body>
</html>