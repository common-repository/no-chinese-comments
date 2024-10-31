<?php
function no_chinese_comments_register_settings() {
	add_option('no_chinese_comments_notice', '对不起，本博客不接受中文评论。如有不便，尽请谅解！
對不起，本部落格不接受中文評論。如有不便，盡請諒解！
Sorry, but the blog do not accept comments in Chinese.');
	add_option('no_chinese_comments_mode', 'wordpress');
	register_setting('no_chinese_comments_options', 'no_chinese_comments_notice');
	register_setting('no_chinese_comments_options', 'no_chinese_comments_mode');
}
add_action('admin_init', 'no_chinese_comments_register_settings');

function no_chinese_comments_register_options_page() {
	add_options_page(__('No Chinese Comments Options Page', NO_CHINESE_COMMENTS_TEXT_DOMAIN), __('No Chinese Comments', NO_CHINESE_COMMENTS_TEXT_DOMAIN), 'manage_options', NO_CHINESE_COMMENTS_TEXT_DOMAIN.'-options', 'no_chinese_comments_options_page');
}
add_action('admin_menu', 'no_chinese_comments_register_options_page');

function no_chinese_comments_get_select_option($select_option_name, $select_option_value, $select_option_id){
	?>
	<select name="<?php echo $select_option_name; ?>" id="<?php echo $select_option_name; ?>">
		<?php
		for($num = 0; $num < count($select_option_id); $num++){
			$select_option_value_each = $select_option_value[$num];
			$select_option_id_each = $select_option_id[$num];
			?>
			<option value="<?php echo $select_option_id_each; ?>"<?php if (get_option($select_option_name) == $select_option_id_each){?> selected="selected"<?php } ?>>
				<?php echo $select_option_value_each; ?>
			</option>
		<?php } ?>
	</select>
	<?php
}

function no_chinese_comments_options_page() {
?>
<div class="wrap">
	<h2><?php _e("No Chinese Comments Options Page", NO_CHINESE_COMMENTS_TEXT_DOMAIN); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields('no_chinese_comments_options'); ?>
		<h3><?php _e("General Options", NO_CHINESE_COMMENTS_TEXT_DOMAIN); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="no_chinese_comments_notice"><?php _e("Disallow Japanese Language Comments Notice: ", NO_CHINESE_COMMENTS_TEXT_DOMAIN); ?></label></th>
					<td>
						<textarea name="no_chinese_comments_notice" id="no_chinese_comments_notice" rows="5" cols="60"><?php echo get_option("no_chinese_comments_notice"); ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="no_chinese_comments_mode"><?php _e("Blog Comments Mode: ", NO_CHINESE_COMMENTS_TEXT_DOMAIN); ?></label></th>
					<td>
						<?php no_chinese_comments_get_select_option("no_chinese_comments_mode", array(__('Wordpress Default', NO_CHINESE_COMMENTS_TEXT_DOMAIN), __('AJAX', NO_CHINESE_COMMENTS_TEXT_DOMAIN)), array('wordpress', 'ajax')); ?>
						<?php _e("(If you don't know what it means, Please try both)", NO_CHINESE_COMMENTS_TEXT_DOMAIN); ?>
					</td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}
?>