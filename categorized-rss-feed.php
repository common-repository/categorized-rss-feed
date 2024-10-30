<?php
/*
 * Plugin Name: Categorized RSS feed
 * Plugin URI: https://boomil.com
 * Description: Widget for categorized RSS feed.
 * Version: 1.0.5
 * Author: boomil
 * Author URI: https://boomil.com/
 * License: GPLv2
 */
class MyCategorizedRssFeedWidget extends WP_Widget {
	function MyCategorizedRssFeedWidget() {
		parent::__construct ( false, 'Categorized Rss Feed' );
	}
	function widget($args, $instance) {
		extract ( $args );
		$feedly = strip_tags ( $instance ['feedly'] );
		
		$rssImageTag = '<div style="margin-bottom:15px;"><img src="' . content_url () . '/plugins/categorized-rss-feed/rss.png"/> ';
		$feedlyLinkPrefix = "<a href='https://cloud.feedly.com/#subscription/feed/";
		$feedlyLinkSuffix = "'  target='blank'><img id='feedlyFollow' src='https://s3.feedly.com/img/follows/feedly-follow-rectangle-volume-medium_2x.png' alt='follow us in feedly' width='71' height='28'></a>";
		if (is_single ()) {
			echo "<a style=\"text-decoration: none;\" href=\"" . get_category_feed_link ( get_the_category () [0]->cat_ID ) . "\" target=\"_blank\">";
			echo $rssImageTag . get_the_category () [0]->cat_name . "RSS</a>　";
			if ($feedly == 1)
				echo $feedlyLinkPrefix . urlencode ( htmlspecialchars_decode ( get_category_feed_link ( get_the_category () [0]->cat_ID ) ) ) . $feedlyLinkSuffix;
		} else if (is_category ()) {
			$cat = get_category ( get_query_var ( 'cat' ), false );
			echo "<a style=\"text-decoration: none;\" href=\"" . get_category_feed_link ( get_query_var ( 'cat' ) ) . "\" target=\"_blank\">";
			echo $rssImageTag . $cat->name . "RSS</a>　";
			if ($feedly == 1)
				echo $feedlyLinkPrefix . urlencode ( htmlspecialchars_decode ( get_category_feed_link ( get_query_var ( 'cat' ) ) ) ) . $feedlyLinkSuffix;
		} else {
			echo "<a style=\"text-decoration: none;\" href=\"" . get_feed_link () . "\" target=\"_blank\">" . $rssImageTag . "</a>　";
			if ($feedly == 1)
				echo $feedlyLinkPrefix . urlencode ( htmlspecialchars_decode ( get_feed_link () ) ) . $feedlyLinkSuffix;
		}
		echo "</div>";
	}
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	function form($instance) {
		$instance = wp_parse_args ( ( array ) $instance, array (
		) );
		$feedly = strip_tags ( $instance ['feedly'] );
		?>
<p>
	<label for="<?php echo $this->get_field_id('feedly'); ?>"><?php _e('Display feedly button:'); ?></label>
	<input name="<?php echo $this->get_field_name('feedly'); ?>"
		type="checkbox" value="1"
		<?php checked( $instance['feedly'], 1 ); ?> />
	<br/><br/>
	If you like this plugin, please share the link for my blog. もしこのプラグインを気に入ったら、私のブログへのリンクをお願いします.<br/>
	https://boomil.com/?p=755
	
		<?php
	}
}
function my_categorized_rss_feed_widget_register() {
	register_widget ( 'MyCategorizedRssFeedWidget' );
}

add_action ( 'widgets_init', 'my_categorized_rss_feed_widget_register' );

?>