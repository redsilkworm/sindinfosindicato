<?php require_once('../Connections/sindicato.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_sindicato = new KT_connection($sindicato, $database_sindicato);

//Start Restrict Access To Page
$restrict = new tNG_RestrictAccess($conn_sindicato, "../");
//Grand Levels: Any
$restrict->Execute();
//End Restrict Access To Page

// Make a logout transaction instance
$logoutTransaction = new tNG_logoutTransaction($conn_sindicato);
$tNGs->addTransaction($logoutTransaction);
// Register triggers
$logoutTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "KT_logout_now");
$logoutTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "login.php");
// Add columns
// End of logout transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<link rel="stylesheet" href="../site/templates/sindicatos/css/template.css" type="text/css">
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
</head>
<body>
    <div class="menu_admin">
    <ul>
    	<li>
        <a href="#">Associados</a>
        	<ul>
            	<a href="/sindicatos/administrador/frm_adm_cad_pendentes.php">Cadastros Pendentes</a><br />
              	<a href="/sindicatos/administrador/frm_adm_cadastro_associado.php">Novo Cadastro</a><br />
                <a href="/sindicatos/administrador/frm_cons_cnp_atualiza_cad_associado.php">Alterar Cadastro</a><br />
                <a href="/sindicatos/administrador/frm_consulta_cnpj_upoad.php"> Upload de Boletos</a><br />
                <a href="/sindicatos/administrador/frm_consulta_download_arquivo.php"> Download de Boletos</a><br />
                <a href="/sindicatos/administrador/frm_consulta_logo.php">Gerenciar Logomarcas</a>
            </ul>
    </li>
    	<li>
        <a href="#">Declara&ccedil;&otilde;es</a>
        	<ul>
            	<a href="/sindicatos/administrador/frm_adm_consulta_certidoes.php">Emiss&atilde;o</a><br />
                <a href="/sindicatos/administrador/frm_adm_consulta_cnpj_certidao.php">Valida&ccedil;&atilde;o</a>
        </ul>
    </li>
        <li>
        <a href="#">Produtos</a>
        	<ul>
            	<a href="/sindicatos/administrador/frm_consulta_produto.php">Cadastro de Produtos</a><br />
                <a href="/sindicatos/administrador/listas/lst_tipos_produto.php">Cadastro de Tipos de Produtos</a>
            </ul>
    </li>
   	<li>
        <a href="#">Usu&aacute;rios</a>
<ul>
            	<a href="/sindicatos/administrador/listas/lst_usuarios.php">Cadastro</a>
            </ul>
</li>

        <li>
          <?php
	echo $tNGs->getErrorMsg();
?>
<a href="<?php echo $logoutTransaction->getLogoutLink(); ?>">Sair</a>
        </li>
      </ul>
    </div>
</body>
</html>