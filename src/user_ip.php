<?php

/**
 * @version 			SEBLOD 3.x More
 * @package			SEBLOD (App Builder & CCK) // SEBLOD nano (Form Builder)
 * @url				https://www.seblod.com
 * @editor			Octopoos - www.octopoos.com
 * @copyright		Copyright (C) 2009 - 2018 SEBLOD. All Rights Reserved.
 * @license 			GNU General Public License version 2 or later; see _LICENSE.php
 * */
defined('_JEXEC') or die;

// Plugin
class plgCCK_Field_LiveUser_Ip extends JCckPluginLive {

	protected static $type = 'user_ip';

	// -------- -------- -------- -------- -------- -------- -------- -------- // Prepare
	// onCCK_Field_LivePrepareForm
	public function onCCK_Field_LivePrepareForm(&$field, &$value = '', &$config = array(), $inherit = array()) {
		if (self::$type != $field->live) {
			return;
		}

		// Init
		$options = parent::g_getLive($field->live_options);

		// Prepare
		function get_ip($default_value) {
			$reyt	 = $default_value;
			$ip		 = getenv("HTTP_CLIENT_IP");
			if ($ip) {
				$reyt = $ip;
			} else {
				$ip = getenv("HTTP_X_FORWARDED_FOR");
				if ($ip) {
					if ($ip == '' || $ip == "unknown") {
						$ip = getenv("REMOTE_ADDR");
					}
					$reyt = $ip;
				} else {
					$ip = getenv("REMOTE_ADDR");
					if ($ip) {
						$reyt = $ip;
					}
				}
			}
			return $reyt;
		}

		$default_value	 = $options->get('default_value', '');
		$live			 = get_ip($default_value);
		// Set
		$value			 = (!$live ) ? '' : (string) $live;
	}

}

?>