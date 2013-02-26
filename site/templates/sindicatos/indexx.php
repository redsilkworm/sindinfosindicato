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
  	<div class="topmenu">
    	<jdoc:include type="modules" name="top1" />
    </div>
    <div id="cabecalho">
    	<div class="logomarca">
        	<h1><a href="<?php echo $baseUrl; ?>/" title="<?php echo $mainframe->getCfg('sitename'); ?>"><?php echo $mainframe->getCfg('sitename') ;?></a></h1>
        </div>
        <div class="busca">
        	<jdoc:include type="modules" name="top2" />
        </div>
        <div class="slogan">
        <!-- 
        	<h3>Sindicato das Empresas de Informática / ES</h3>
        -->
	        <jdoc:include type="modules" name="user2" />
        </div>
    </div>
    <div id="zoom">
    	<jdoc:include type="modules" name="top3" />
    </div>
    <div id="breadcrumbs">
    	<jdoc:include type="modules" name="user1" />
    </div>
    <div id="tronco">
    	<div id="barralateral">
        	<jdoc:include type="modules" name="left" />
        </div>
        <div id="conteudo">
        	<div id="bannerp">
            	<jdoc:include type="modules" name="banner1" />
            </div>
            <div id="artigos">
            	<jdoc:include type="component" />
            </div>
            <div id="banneraux">
            	<jdoc:include type="modules" name="banner2" />
                <jdoc:include type="modules" name="banner3" />
            </div>
            <div id="clear">
            
            </div>
        </div>
    </div>
    <div id="rodape">
    	<address>
        	<jdoc:include type="modules" name="rodape" />
        </address>
    </div>
  </div>
  <div id="empresa">
  	<jdoc:include type="modules" name="empresa" />
  </div>
    	<div class="topmenu">
    	<jdoc:include type="modules" name="top1" />
    </div>
  </body>
</html>