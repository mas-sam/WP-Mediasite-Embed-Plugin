<?php
	/*
	Plugin Name: Mediasite Embed
	Plugin URI: http://www.example.com/plugin
	Description: Mediasiteコンテンツを埋め込むプラグイン
	Author: Masaya Okada
	Version: 0.1
	Author URI: http://www.mediasite.co.jp
	*/
	
class MediasiteEmbed {
    function __construct() {
      add_action('admin_menu', array($this, 'add_pages'));
    }

    function add_pages() {
      add_menu_page('Mediasite埋込設定','Mediasite埋込設定',  'level_8', __FILE__, array($this,'mediasite_embed_option_page'), '', 26);
    }
    function mediasite_embed_option_page() {
    //$_POST['mediasite_embed_options'])があったら保存
    if ( isset($_POST['mediasite_embed_options'])) {
        check_admin_referer('msemboptions');
        $opt = $_POST['mediasite_embed_options'];
        update_option('mediasite_embed_options', $opt);
        ?><div class="updated fade"><p><strong><?php _e('Options saved.'); ?></strong></p></div><?php
    }
    ?>
    <div class="wrap">
    <div id="icon-options-general" class="icon32"><br /></div><h2>Mediasite埋込設定</h2>
        <form action="" method="post">
            <?php
            wp_nonce_field('msemboptions');
            $opt = get_option('mediasite_embed_options');
            $show_text = isset($opt['text']) ? $opt['text']: null;
            ?> 
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="inputtext">ベースURL</label></th>
                    <td><input name="mediasite_embed_options[text]" type="text" id="inputtext" value="<?php  echo $show_text ?>" class="regular-text" /></td>
                </tr>
            </table>
            <p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
          
        </form>
    <!-- /.wrap --></div>
    <?php

    }
}
$mediasite_embed = new MediasiteEmbed;



function embed_mediasite( $matches, $attr, $url, $rawattr ) {
$opt2 = get_option('mediasite_embed_options');
$baseurl = isset($opt2['text']) ? $opt2['text']: null;
	
	
	$embed = sprintf(
			'<iframe src="%1$splay/%2$s" width="320px" height="240px" frameborder="0" scrolling="no" marginwidth="0" marginheight="0"></iframe>',
			$baseurl,
			esc_attr($matches[1])
			);

	return apply_filters( 'embed_mediasite', $embed, $matches, $attr, $url, $rawattr );
}
//上とおなじk
$opt3 = get_option('mediasite_embed_options');
  	$baseurl2 = isset($opt3['text']) ? $opt3['text']: null;

wp_embed_register_handler( 'mediasite', '#'.$baseurl2.'play/([a-zA-Z0-9]+)#i', 'embed_mediasite' );