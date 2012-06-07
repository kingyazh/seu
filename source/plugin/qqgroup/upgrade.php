<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: upgrade.php 29283 2012-03-31 09:35:36Z liudongdong $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$setting = C::t('common_setting')->fetch_all(array('qqgroup_usergroup_feed_list'));

if (!$setting) {

	$usergroups = array(1, 2, 3);

	$updateData = array(
							'qqgroup_usergroup_feed_list' => serialize($usergroups),
						);

	// 将数据记入setting表，并更新缓存

	C::t('common_setting')->update_batch($updateData);

}

$finish = true;

?>