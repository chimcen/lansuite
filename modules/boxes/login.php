<?php
/**
 * Generate Loginbox
 *
 * @package lansuite_core
 * @author knox
 * @version $Id$
 */

if ($_GET['mod'] == 'logout') $smarty->assign('action', 'index.php');
else $smarty->assign('action', 'index.php?mod=auth&action=login');
$smarty->assign('buttons_add', $dsp->FetchIcon('index.php?mod=signon', 'add_user'));
$smarty->assign('buttons_pw', $dsp->FetchIcon('index.php?mod=usrmgr&amp;action=pwrecover', 'pw_forgot'));
$smarty->assign('buttons_login', '<input type="submit" class="Button" name="login" value="Einloggen" />');

$box->AddTemplate($smarty->fetch('modules/boxes/templates/box_login_content.htm'));
?>