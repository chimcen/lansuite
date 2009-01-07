<?php
$smarty->assign('caption', t('Aktuelle Umfragen'));
$content = "";

$query = $db->qry('SELECT UNIX_TIMESTAMP(p.endtime) AS endtime, p.pollid, p.caption, COUNT(v.polloptionid) AS votes, UNIX_TIMESTAMP(p.changedate) AS changedate FROM %prefix%polls AS p
  LEFT JOIN %prefix%polloptions AS o on p.pollid = o.pollid
  LEFT JOIN %prefix%pollvotes AS v on o.polloptionid = v.polloptionid
  WHERE !p.group_id OR p.group_id = %int%
  GROUP BY p.pollid
  ORDER BY p.changedate DESC
  LIMIT 0, %int%
  ', $auth['group_id'], $cfg['home_item_count']);
if ($db->num_rows($query) > 0) {
	while($row = $db->fetch_array($query)) {
		$templ['home']['show']['row']['control']['link']	= 'index.php?mod=poll&action=show&step=2&pollid='. $row['pollid'];

		$templ['home']['show']['row']['info']['text']		= $func->CutString($row['caption'], 40);
		$templ['home']['show']['row']['info']['text2']		= '(Votes: '. $row['votes'] .') ';
    if ($row["endtime"] and $row["endtime"] < time()) $templ['home']['show']['row']['info']['text2'] .= ' <div class="infolink" style="display:inline"><img src="design/images/icon_locked.png" border="0" width="12" /><span class="infobox">'. t('Abstimmung wurde geschlossen') .'</span></div>';
		elseif ($row["endtime"]) $templ['home']['show']['row']['info']['text2'] .= '['. $func->unixstamp2date($row["endtime"], 'date') .']';

    if ($func->CheckNewPosts($row['changedate'], 'poll', $row['pollid'])) $content	.= $dsp->FetchModTpl('home', 'show_row_new');
    else $content	.= $dsp->FetchModTpl('home', 'show_row');

		$templ['home']['show']['row']['info']['text2']		= "";	// set var to NULL
	}
} else $content = "<i>". t('Keine Umfragen vorhanden') ."</i>";
?>