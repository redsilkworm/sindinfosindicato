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

//start Trigger_CheckPasswords trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords(&$tNG) {
  $myThrowError = new tNG_ThrowError($tNG);
  $myThrowError->setErrorMsg("Could not create account.");
  $myThrowError->setField("usuario_senha");
  $myThrowError->setFieldErrorMsg("The two passwords do not match.");
  return $myThrowError->Execute();
}
//end Trigger_CheckPasswords trigger

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("usuario_nome", true, "text", "", "", "", "");
$formValidation->addField("usuario_email", true, "text", "email", "", "", "");
$formValidation->addField("usuario_login", true, "text", "", "", "", "");
$formValidation->addField("usuario_senha", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_CheckOldPassword trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckOldPassword(&$tNG) {
  return Trigger_UpdatePassword_CheckOldPassword($tNG);
}
//end Trigger_CheckOldPassword trigger

// Make an insert transaction instance
$ins_bl_usuario = new tNG_multipleInsert($conn_sindicato);
$tNGs->addTransaction($ins_bl_usuario);
// Register triggers
$ins_bl_usuario->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_bl_usuario->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_bl_usuario->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$ins_bl_usuario->registerConditionalTrigger("{POST.usuario_senha} != {POST.re_usuario_senha}", "BEFORE", "Trigger_CheckPasswords", 50);
// Add columns
$ins_bl_usuario->setTable("bl_usuario");
$ins_bl_usuario->addColumn("usuario_nome", "STRING_TYPE", "POST", "usuario_nome");
$ins_bl_usuario->addColumn("usuario_email", "STRING_TYPE", "POST", "usuario_email");
$ins_bl_usuario->addColumn("usuario_login", "STRING_TYPE", "POST", "usuario_login");
$ins_bl_usuario->addColumn("usuario_senha", "STRING_TYPE", "POST", "usuario_senha");
$ins_bl_usuario->addColumn("usuario_ativo", "STRING_TYPE", "POST", "usuario_ativo");
$ins_bl_usuario->setPrimaryKey("usuario_id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_bl_usuario = new tNG_multipleUpdate($conn_sindicato);
$tNGs->addTransaction($upd_bl_usuario);
// Register triggers
$upd_bl_usuario->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_bl_usuario->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_bl_usuario->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
$upd_bl_usuario->registerConditionalTrigger("{POST.usuario_senha} != {POST.re_usuario_senha}", "BEFORE", "Trigger_CheckPasswords", 50);
$upd_bl_usuario->registerTrigger("BEFORE", "Trigger_CheckOldPassword", 60);
// Add columns
$upd_bl_usuario->setTable("bl_usuario");
$upd_bl_usuario->addColumn("usuario_nome", "STRING_TYPE", "POST", "usuario_nome");
$upd_bl_usuario->addColumn("usuario_email", "STRING_TYPE", "POST", "usuario_email");
$upd_bl_usuario->addColumn("usuario_login", "STRING_TYPE", "POST", "usuario_login");
$upd_bl_usuario->addColumn("usuario_senha", "STRING_TYPE", "POST", "usuario_senha");
$upd_bl_usuario->addColumn("usuario_ativo", "STRING_TYPE", "POST", "usuario_ativo");
$upd_bl_usuario->setPrimaryKey("usuario_id", "NUMERIC_TYPE", "GET", "usuario_id");

// Make an instance of the transaction object
$del_bl_usuario = new tNG_multipleDelete($conn_sindicato);
$tNGs->addTransaction($del_bl_usuario);
// Register triggers
$del_bl_usuario->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_bl_usuario->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../includes/nxt/back.php");
// Add columns
$del_bl_usuario->setTable("bl_usuario");
$del_bl_usuario->setPrimaryKey("usuario_id", "NUMERIC_TYPE", "GET", "usuario_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsbl_usuario = $tNGs->getRecordset("bl_usuario");
$row_rsbl_usuario = mysql_fetch_assoc($rsbl_usuario);
$totalRows_rsbl_usuario = mysql_num_rows($rsbl_usuario);
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
if (@$_GET['usuario_id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Usu&aacute;rio </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsbl_usuario > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="usuario_nome_<?php echo $cnt1; ?>">Nome:</label></td>
            <td><input type="text" name="usuario_nome_<?php echo $cnt1; ?>" id="usuario_nome_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsbl_usuario['usuario_nome']); ?>" size="32" maxlength="255" />
              <?php echo $tNGs->displayFieldHint("usuario_nome");?> <?php echo $tNGs->displayFieldError("bl_usuario", "usuario_nome", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="usuario_email_<?php echo $cnt1; ?>">E-maill:</label></td>
            <td><input type="text" name="usuario_email_<?php echo $cnt1; ?>" id="usuario_email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsbl_usuario['usuario_email']); ?>" size="32" maxlength="255" />
              <?php echo $tNGs->displayFieldHint("usuario_email");?> <?php echo $tNGs->displayFieldError("bl_usuario", "usuario_email", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="usuario_login_<?php echo $cnt1; ?>">Usuario:</label></td>
            <td><input type="text" name="usuario_login_<?php echo $cnt1; ?>" id="usuario_login_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsbl_usuario['usuario_login']); ?>" size="15" maxlength="15" />
              <?php echo $tNGs->displayFieldHint("usuario_login");?> <?php echo $tNGs->displayFieldError("bl_usuario", "usuario_login", $cnt1); ?></td>
          </tr>
          <?php 
// Show IF Conditional show_old_usuario_senha_on_update_only 
if (@$_GET['usuario_id'] != "") {
?>
            <tr>
              <td class="KT_th"><label for="old_usuario_senha_<?php echo $cnt1; ?>">Old Senha: </label></td>
              <td><input type="password" name="old_usuario_senha_<?php echo $cnt1; ?>" id="old_usuario_senha_<?php echo $cnt1; ?>" value="" size="10" maxlength="10" />
                <?php echo $tNGs->displayFieldError("bl_usuario", "old_usuario_senha", $cnt1); ?></td>
            </tr>
            <?php } 
// endif Conditional show_old_usuario_senha_on_update_only
?>
          <tr>
            <td class="KT_th"><label for="usuario_senha_<?php echo $cnt1; ?>">Senha: </label></td>
            <td><input type="password" name="usuario_senha_<?php echo $cnt1; ?>" id="usuario_senha_<?php echo $cnt1; ?>" value="" size="10" maxlength="10" />
              <?php echo $tNGs->displayFieldHint("usuario_senha");?> <?php echo $tNGs->displayFieldError("bl_usuario", "usuario_senha", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="re_usuario_senha_<?php echo $cnt1; ?>">Re-type Senha: </label></td>
            <td><input type="password" name="re_usuario_senha_<?php echo $cnt1; ?>" id="re_usuario_senha_<?php echo $cnt1; ?>" value="" size="10" maxlength="10" /></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="usuario_ativo_<?php echo $cnt1; ?>">Ativo:</label></td>
            <td><select name="usuario_ativo_<?php echo $cnt1; ?>" id="usuario_ativo_<?php echo $cnt1; ?>">
              <option value="s" <?php if (!(strcmp("s", KT_escapeAttribute($row_rsbl_usuario['usuario_ativo'])))) {echo "SELECTED";} ?>>Sim</option>
              <option value="n" <?php if (!(strcmp("n", KT_escapeAttribute($row_rsbl_usuario['usuario_ativo'])))) {echo "SELECTED";} ?>>Nao</option>
            </select>
              <?php echo $tNGs->displayFieldError("bl_usuario", "usuario_ativo", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_bl_usuario_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsbl_usuario['kt_pk_bl_usuario']); ?>" />
        <?php } while ($row_rsbl_usuario = mysql_fetch_assoc($rsbl_usuario)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['usuario_id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'usuario_id')" />
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