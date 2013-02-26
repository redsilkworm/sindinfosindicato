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

// Make an instance of the transaction object
$del_bl_produto = new tNG_delete($conn_sindicato);
$tNGs->addTransaction($del_bl_produto);
// Register triggers
$del_bl_produto->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "prod_id");
$del_bl_produto->registerTrigger("END", "Trigger_Default_Redirect", 99, "frm_relacao_produto.php?associado={ass_id}");
// Add columns
$del_bl_produto->setTable("bl_produto");
$del_bl_produto->setPrimaryKey("prod_id", "NUMERIC_TYPE", "GET", "prod_id");

// Execute all the registered transactions
$tNGs->executeTransactions();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
</body>
</html>