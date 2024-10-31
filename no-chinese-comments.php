<?php
/*

**************************************************************************

Plugin Name:  No Chinese Comments
Plugin URI:   http://www.arefly.com/no-chinese-comments/
Description:  Disallow Chinese Comments in Your Blog. 在你的部落格中禁止中文評論
Version:      1.0.4
Author:       Arefly
Author URI:   http://www.arefly.com/
Text Domain:  no-chinese-comments
Domain Path:  /lang/

**************************************************************************

	Copyright 2014  Arefly  (email : eflyjason@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**************************************************************************/

define("NO_CHINESE_COMMENTS_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("NO_CHINESE_COMMENTS_FULL_DIR", plugin_dir_path( __FILE__ ));
define("NO_CHINESE_COMMENTS_TEXT_DOMAIN", "no-chinese-comments");

/* Plugin Localize */
function no_chinese_comments_load_plugin_textdomain() {
	load_plugin_textdomain(NO_CHINESE_COMMENTS_TEXT_DOMAIN, false, dirname(plugin_basename( __FILE__ )).'/lang/');
}
add_action('plugins_loaded', 'no_chinese_comments_load_plugin_textdomain');

include_once NO_CHINESE_COMMENTS_FULL_DIR."options.php";

/* Add Links to Plugins Management Page */
function no_chinese_comments_action_links($links){
	$links[] = '<a href="'.get_admin_url(null, 'options-general.php?page='.NO_CHINESE_COMMENTS_TEXT_DOMAIN.'-options').'">'.__("Settings", NO_CHINESE_COMMENTS_TEXT_DOMAIN).'</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'no_chinese_comments_action_links');

function no_chinese_comments($incoming_comment) {
	$cpattern = '/[\x7f-\xff]/';
	if(preg_match($cpattern, $incoming_comment['comment_content'])){
		$message = nl2br(get_option("no_chinese_comments_notice"));
		if (get_option("no_chinese_comments_mode") == "ajax") {
			err($message);
		}else{
			header("Content-type: text/html; charset=utf-8");
			wp_die($message);
		}
		exit;
	}
	return($incoming_comment);
}
add_filter('preprocess_comment', 'no_chinese_comments');
