<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: member_connect_logging.php 26543 2011-12-15 02:17:57Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!empty($_POST)) {
	if($result['member']['conisbind']) {
		showmessage('qqconnect:connect_register_bind_already');
	}
	if($result['member']['groupid'] == 8) {
		showmessage('qqconnect:connect_register_bind_need_inactive');
	}

	$auth_code = authcode($_GET['auth_hash']);
	$auth_code = explode('|', authcode($_GET['auth_hash']));
	$conuin = authcode($auth_code[0]);
	$conuinsecret = authcode($auth_code[1]);
	$conopenid = authcode($auth_code[2]);
	$user_auth_fields = authcode($auth_code[3]);
	$is_use_qqshow = !empty($_GET['use_qqshow']) ? 1 : 0;
	$conispublishfeed = $conispublisht = 1;

	if ($conuin && $conopenid) {
		C::t('#qqconnect#common_member_connect')->insert(array('uid' => $uid, 'conuin' => $conuin, 'conuinsecret' => $conuinsecret, 'conopenid' => $conopenid, 'conispublishfeed' => $conispublishfeed, 'conispublisht' => $conispublisht, 'conisregister' => '0', 'conisqzoneavatar' => '0', 'conisfeed' => $user_auth_fields, 'conisqqshow' => $is_use_qqshow), false, true);
		C::t('common_member')->update($uid, array('conisbind' => '1'));
		C::t('#qqconnect#connect_memberbindlog')->insert(array('uid' => $uid, 'uin' => $conopenid, 'type' => '1', 'dateline' => $_G['timestamp']));

		dsetcookie('connect_js_name', 'user_bind', 86400);
		dsetcookie('connect_js_params', base64_encode(serialize(array('type' => 'registerbind'))), 86400);

		dsetcookie('connect_login', 1, 31536000);
		dsetcookie('connect_is_bind', '1', 31536000);
		dsetcookie('connect_uin', $conopenid, 31536000);
		dsetcookie('stats_qc_reg', 2, 86400);
		if ($_GET['is_feed']) {
			dsetcookie('connect_synpost_tip', 1, 31536000);
		}

	} else {
		showmessage('qqconnect:connect_get_access_token_failed', dreferer());
	}
}

?>