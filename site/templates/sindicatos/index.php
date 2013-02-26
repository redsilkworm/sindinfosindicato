<?php
/**
* @version	$Id: index.php 21140 2011-04-11 17:10:29Z dextercowley $
* @package	Joomla.Site
* @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
* @license	GNU General Public License version 2 or later; see LICENSE.txt
*/
defined('_JEXEC') or die;
?>
<?php echo '<?'; ?>xml version="1.0" encoding="<?php echo $this->_charset ?>"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
</head>
  <body>
    <div id="geral">
      <div id="top-findes">
           <jdoc:include type="modules" name="top1" />
      </div>
      <div id="cabecalho">
        <div class="espaco"></div>
        <div class="logo">
          <h1><a href="<?php echo $baseUrl; ?>/" title="<?php echo $mainframe->getCfg('sitename'); ?>"><?php echo $mainframe->getCfg('sitename') ;?></a></h1>
        </div>
        <div class="slogan">
          <jdoc:include type="modules" name="top2" />
        </div>
        <div class="espaco"></div>
      </div>
      <div id="corpo">
        <div id="left">
          <jdoc:include type="modules" name="left" />
        </div>
        <div id="resource">
          <div class="bslider">
            <jdoc:include type="modules" name="banner1" />
          </div>
          <div class="right">
            <jdoc:include type="modules" name="right" />
          </div>
        </div>
        <div id="texto">
          <div class="usr1">
            <jdoc:include type="modules" name="user1" />
          </div>
          <div class="usr2">
            <jdoc:include type="modules" name="user2" />
          </div>
          <div class="usr3">
            <jdoc:include type="modules" name="user3" />
          </div>
          <div class="usr4">
            <jdoc:include type="modules" name="user4" />
          </div>
        </div>
      </div>
      <div id="rodape">
        <div class="logo">
          <jdoc:include type="modules" name="user5" />
        </div>
        <address>
          <jdoc:include type="modules" name="rodape" />
        </address>
        <div class="filiacao">
          <jdoc:include type="modules" name="syndicate" />
        </div>
        <div class="rsociais">
          <!-- Redes Sociais -->
        </div>
      </div>
    </div>
  </body>
</html>