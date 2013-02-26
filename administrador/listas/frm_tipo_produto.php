<?php require_once('../../Connections/sindicato.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_sindicato = new KT_connection($sindicato, $database_sindicato);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

// Make an insert transaction instance
$ins_bl_tipo_produto = new tNG_multipleInsert($conn_sindicato);
$tNGs->addTransaction($ins_bl_tipo_produto);
// Register triggers
$ins_bl_tipo_produto->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_bl_tipo_produto->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_bl_tipo_produto->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$ins_bl_tipo_produto->setTable("bl_tipo_produto");
$ins_bl_tipo_produto->addColumn("tipo_prod_descricao", "STRING_TYPE", "POST", "tipo_prod_descricao");
$ins_bl_tipo_produto->addColumn("tipo_prod_ativo", "STRING_TYPE", "POST", "tipo_prod_ativo");
$ins_bl_tipo_produto->setPrimaryKey("tipo_prod_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_bl_tipo_produto = new tNG_multipleUpdate($conn_sindicato);
$tNGs->addTransaction($upd_bl_tipo_produto);
// Register triggers
$upd_bl_tipo_produto->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_bl_tipo_produto->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_bl_tipo_produto->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$upd_bl_tipo_produto->setTable("bl_tipo_produto");
$upd_bl_tipo_produto->addColumn("tipo_prod_descricao", "STRING_TYPE", "POST", "tipo_prod_descricao");
$upd_bl_tipo_produto->addColumn("tipo_prod_ativo", "STRING_TYPE", "POST", "tipo_prod_ativo");
$upd_bl_tipo_produto->setPrimaryKey("tipo_prod_id", "NUMERIC_TYPE", "GET", "tipo_prod_id");

// Make an instance of the transaction object
$del_bl_tipo_produto = new tNG_multipleDelete($conn_sindicato);
$tNGs->addTransaction($del_bl_tipo_produto);
// Register triggers
$del_bl_tipo_produto->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_bl_tipo_produto->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_bl_tipo_produto->setTable("bl_tipo_produto");
$del_bl_tipo_produto->setPrimaryKey("tipo_prod_id", "NUMERIC_TYPE", "GET", "tipo_prod_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsbl_tipo_produto = $tNGs->getRecordset("bl_tipo_produto");
$row_rsbl_tipo_produto = mysql_fetch_assoc($rsbl_tipo_produto);
$totalRows_rsbl_tipo_produto = mysql_num_rows($rsbl_tipo_produto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
}
</script>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['tipo_prod_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Tipo de Produto</h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsbl_tipo_produto > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="tipo_prod_descricao_<?php echo $cnt1; ?>">Tipo de Produto:</label></td>
            <td><input type="text" name="tipo_prod_descricao_<?php echo $cnt1; ?>" id="tipo_prod_descricao_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsbl_tipo_produto['tipo_prod_descricao']); ?>" size="32" maxlength="255" />
              <?php echo $tNGs->displayFieldHint("tipo_prod_descricao");?> <?php echo $tNGs->displayFieldError("bl_tipo_produto", "tipo_prod_descricao", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="tipo_prod_ativo_<?php echo $cnt1; ?>">Ativo:</label></td>
            <td><select name="tipo_prod_ativo_<?php echo $cnt1; ?>" id="tipo_prod_ativo_<?php echo $cnt1; ?>">
              <option value="S" <?php if (!(strcmp("S", KT_escapeAttribute($row_rsbl_tipo_produto['tipo_prod_ativo'])))) {echo "SELECTED";} ?>>Sim</option>
              <option value="N" <?php if (!(strcmp("N", KT_escapeAttribute($row_rsbl_tipo_produto['tipo_prod_ativo'])))) {echo "SELECTED";} ?>>Nao</option>
            </select>
              <?php echo $tNGs->displayFieldError("bl_tipo_produto", "tipo_prod_ativo", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_bl_tipo_produto_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsbl_tipo_produto['kt_pk_bl_tipo_produto']); ?>" />
        <?php } while ($row_rsbl_tipo_produto = mysql_fetch_assoc($rsbl_tipo_produto)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['tipo_prod_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'tipo_prod_id')" />
            </div>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
            <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
            <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../../includes/nxt/back.php')" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>