<?php require_once('../../Connections/sindicato.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the required classes
require_once('../../includes/tfi/TFI.php');
require_once('../../includes/tso/TSO.php');
require_once('../../includes/nav/NAV.php');

// Make unified connection variable
$conn_sindicato = new KT_connection($sindicato, $database_sindicato);

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

// Filter
$tfi_listbl_usuario7 = new TFI_TableFilter($conn_sindicato, "tfi_listbl_usuario7");
$tfi_listbl_usuario7->addColumn("bl_usuario.usuario_nome", "STRING_TYPE", "usuario_nome", "%");
$tfi_listbl_usuario7->addColumn("bl_usuario.usuario_email", "STRING_TYPE", "usuario_email", "%");
$tfi_listbl_usuario7->addColumn("bl_usuario.usuario_login", "STRING_TYPE", "usuario_login", "%");
$tfi_listbl_usuario7->addColumn("bl_usuario.usuario_ativo", "STRING_TYPE", "usuario_ativo", "%");
$tfi_listbl_usuario7->Execute();

// Sorter
$tso_listbl_usuario7 = new TSO_TableSorter("rsbl_usuario1", "tso_listbl_usuario7");
$tso_listbl_usuario7->addColumn("bl_usuario.usuario_nome");
$tso_listbl_usuario7->addColumn("bl_usuario.usuario_email");
$tso_listbl_usuario7->addColumn("bl_usuario.usuario_login");
$tso_listbl_usuario7->addColumn("bl_usuario.usuario_ativo");
$tso_listbl_usuario7->setDefault("bl_usuario.usuario_nome");
$tso_listbl_usuario7->Execute();

// Navigation
$nav_listbl_usuario7 = new NAV_Regular("nav_listbl_usuario7", "rsbl_usuario1", "../../", $_SERVER['PHP_SELF'], 20);

//NeXTenesio3 Special List Recordset
$maxRows_rsbl_usuario1 = $_SESSION['max_rows_nav_listbl_usuario7'];
$pageNum_rsbl_usuario1 = 0;
if (isset($_GET['pageNum_rsbl_usuario1'])) {
  $pageNum_rsbl_usuario1 = $_GET['pageNum_rsbl_usuario1'];
}
$startRow_rsbl_usuario1 = $pageNum_rsbl_usuario1 * $maxRows_rsbl_usuario1;

// Defining List Recordset variable
$NXTFilter_rsbl_usuario1 = "1=1";
if (isset($_SESSION['filter_tfi_listbl_usuario7'])) {
  $NXTFilter_rsbl_usuario1 = $_SESSION['filter_tfi_listbl_usuario7'];
}
// Defining List Recordset variable
$NXTSort_rsbl_usuario1 = "bl_usuario.usuario_nome";
if (isset($_SESSION['sorter_tso_listbl_usuario7'])) {
  $NXTSort_rsbl_usuario1 = $_SESSION['sorter_tso_listbl_usuario7'];
}
mysql_select_db($database_sindicato, $sindicato);

$query_rsbl_usuario1 = "SELECT bl_usuario.usuario_nome, bl_usuario.usuario_email, bl_usuario.usuario_login, bl_usuario.usuario_ativo, bl_usuario.usuario_id FROM bl_usuario WHERE {$NXTFilter_rsbl_usuario1} ORDER BY {$NXTSort_rsbl_usuario1}";
$query_limit_rsbl_usuario1 = sprintf("%s LIMIT %d, %d", $query_rsbl_usuario1, $startRow_rsbl_usuario1, $maxRows_rsbl_usuario1);
$rsbl_usuario1 = mysql_query($query_limit_rsbl_usuario1, $sindicato) or die(mysql_error());
$row_rsbl_usuario1 = mysql_fetch_assoc($rsbl_usuario1);

if (isset($_GET['totalRows_rsbl_usuario1'])) {
  $totalRows_rsbl_usuario1 = $_GET['totalRows_rsbl_usuario1'];
} else {
  $all_rsbl_usuario1 = mysql_query($query_rsbl_usuario1);
  $totalRows_rsbl_usuario1 = mysql_num_rows($all_rsbl_usuario1);
}
$totalPages_rsbl_usuario1 = ceil($totalRows_rsbl_usuario1/$maxRows_rsbl_usuario1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listbl_usuario7->checkBoundries();
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
<script src="../../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_usuario_nome {width:140px; overflow:hidden;}
  .KT_col_usuario_email {width:140px; overflow:hidden;}
  .KT_col_usuario_login {width:105px; overflow:hidden;}
  .KT_col_usuario_ativo {width:140px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listbl_usuario7">
  <h1> Lista de Usu&aacute;rios
    <?php
  $nav_listbl_usuario7->Prepare();
  require("../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listbl_usuario7->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listbl_usuario7'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listbl_usuario7']; ?>
          <?php 
  // else Conditional region1
  } else { ?>
          <?php echo NXT_getResource("all"); ?>
          <?php } 
  // endif Conditional region1
?>
<?php echo NXT_getResource("records"); ?></a> &nbsp;
        &nbsp;
        <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listbl_usuario7'] == 1) {
?>
          <a href="<?php echo $tfi_listbl_usuario7->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
          <?php 
  // else Conditional region2
  } else { ?>
          <a href="<?php echo $tfi_listbl_usuario7->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
          <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="usuario_nome" class="KT_sorter KT_col_usuario_nome <?php echo $tso_listbl_usuario7->getSortIcon('bl_usuario.usuario_nome'); ?>"> <a href="<?php echo $tso_listbl_usuario7->getSortLink('bl_usuario.usuario_nome'); ?>">Nome</a></th>
            <th id="usuario_email" class="KT_sorter KT_col_usuario_email <?php echo $tso_listbl_usuario7->getSortIcon('bl_usuario.usuario_email'); ?>"> <a href="<?php echo $tso_listbl_usuario7->getSortLink('bl_usuario.usuario_email'); ?>">E-mail</a></th>
            <th id="usuario_login" class="KT_sorter KT_col_usuario_login <?php echo $tso_listbl_usuario7->getSortIcon('bl_usuario.usuario_login'); ?>"> <a href="<?php echo $tso_listbl_usuario7->getSortLink('bl_usuario.usuario_login'); ?>">Login</a></th>
            <th id="usuario_ativo" class="KT_sorter KT_col_usuario_ativo <?php echo $tso_listbl_usuario7->getSortIcon('bl_usuario.usuario_ativo'); ?>"> <a href="<?php echo $tso_listbl_usuario7->getSortLink('bl_usuario.usuario_ativo'); ?>">Ativo</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listbl_usuario7'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listbl_usuario7_usuario_nome" id="tfi_listbl_usuario7_usuario_nome" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbl_usuario7_usuario_nome']); ?>" size="20" maxlength="255" /></td>
              <td><input type="text" name="tfi_listbl_usuario7_usuario_email" id="tfi_listbl_usuario7_usuario_email" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbl_usuario7_usuario_email']); ?>" size="20" maxlength="255" /></td>
              <td><input type="text" name="tfi_listbl_usuario7_usuario_login" id="tfi_listbl_usuario7_usuario_login" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listbl_usuario7_usuario_login']); ?>" size="15" maxlength="15" /></td>
              <td><select name="tfi_listbl_usuario7_usuario_ativo" id="tfi_listbl_usuario7_usuario_ativo">
                <option value="S" <?php if (!(strcmp("S", KT_escapeAttribute(@$_SESSION['tfi_listbl_usuario7_usuario_ativo'])))) {echo "SELECTED";} ?>>Sim</option>
                <option value="N" <?php if (!(strcmp("N", KT_escapeAttribute(@$_SESSION['tfi_listbl_usuario7_usuario_ativo'])))) {echo "SELECTED";} ?>>Nao</option>
              </select></td>
              <td><input type="submit" name="tfi_listbl_usuario7" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsbl_usuario1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="6"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsbl_usuario1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_bl_usuario" class="id_checkbox" value="<?php echo $row_rsbl_usuario1['usuario_id']; ?>" />
                  <input type="hidden" name="usuario_id" class="id_field" value="<?php echo $row_rsbl_usuario1['usuario_id']; ?>" /></td>
                <td><div class="KT_col_usuario_nome"><?php echo KT_FormatForList($row_rsbl_usuario1['usuario_nome'], 20); ?></div></td>
                <td><div class="KT_col_usuario_email"><?php echo KT_FormatForList($row_rsbl_usuario1['usuario_email'], 20); ?></div></td>
                <td><div class="KT_col_usuario_login"><?php echo KT_FormatForList($row_rsbl_usuario1['usuario_login'], 15); ?></div></td>
                <td><div class="KT_col_usuario_ativo"><?php echo KT_FormatForList($row_rsbl_usuario1['usuario_ativo'], 20); ?></div></td>
                <td><a class="KT_edit_link" href="frm_usuario.php?usuario_id=<?php echo $row_rsbl_usuario1['usuario_id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
              </tr>
              <?php } while ($row_rsbl_usuario1 = mysql_fetch_assoc($rsbl_usuario1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listbl_usuario7->Prepare();
            require("../../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a></div>
        <span>&nbsp;</span>
        <select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="3">3</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="frm_usuario.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a></div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($rsbl_usuario1);
?>
