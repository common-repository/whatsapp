<?php
define("WABTN_NAME","WhatsApp Share Button");
define("WABTN_TAGLINE","Adds the WhatsApp share button to your posts and pages!");
define("WABTN_URL","http://peadig.com/wordpress-plugins/whatsapp-share-button/");
define("WABTN_EXTEND_URL","http://wordpress.org/extend/plugins/facebook-comments-plugin/");
define("WABTN_AUTHOR_TWITTER","alexmoss");
define("WABTN_DONATE_LINK","https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WFVJMCGGZTDY4");

add_action('admin_init', 'wa_btn_init' );
function wa_btn_init(){
  register_setting( 'wa_btn_options', 'wa_btn' );
  $new_options = array(
    'top' => 'on',
    'btm' => 'on',
    'posts' => 'on',
    'pages' => 'off',
    'homepage' => 'off',
    'tracking' => 'off'
  );
  add_option( 'wa_btn', $new_options );
}


add_action('admin_menu', 'show_wa_btn_options');
function show_wa_btn_options() {
  add_options_page('WhatsApp Share Button Options', 'WhatsApp Share Button', 'manage_options', 'wa_btn', 'wa_btn_options');
}


function wa_btn_fetch_rss_feed() {
    include_once(ABSPATH . WPINC . '/feed.php');
  $rss = fetch_feed("http://peadig.com/feed");  
  if ( is_wp_error($rss) ) { return false; }  
  $rss_items = $rss->get_items(0, 3);
    return $rss_items;
}   

// ADMIN PAGE
function wa_btn_options() {
?>
    <link href="<?php echo plugins_url( 'admin.css' , __FILE__ ); ?>" rel="stylesheet" type="text/css">
    <div class="pea_admin_wrap">
        <div class="pea_admin_top">
            <h1><?php echo WABTN_NAME?> <small> - <?php echo WABTN_TAGLINE?></small></h1>
        </div>

        <div class="pea_admin_main_wrap">
            <div class="pea_admin_main_left">
                <div class="pea_admin_signup">
                    Want to know about updates to this plugin without having to log into your site every time? Want to know about other cool plugins we've made? Add your email and we'll add you to our very rare mail outs.

                    <!-- Begin MailChimp Signup Form -->
                    <div id="mc_embed_signup">
                    <form action="http://peadig.us5.list-manage2.com/subscribe/post?u=e16b7a214b2d8a69e134e5b70&amp;id=eb50326bdf" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div class="mc-field-group">
                        <label for="mce-EMAIL">Email Address
                    </label>
                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL"><button type="submit" name="subscribe" id="mc-embedded-subscribe" class="pea_admin_green">Sign Up!</button>
                    </div>
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                        </div>  <div class="clear"></div>
                    </form>
                    </div>

                    <!--End mc_embed_signup-->
                </div>

    <form method="post" action="options.php" id="options">
      <?php settings_fields('wa_btn_options'); ?>
      <?php $options = get_option('wa_btn'); 
        if (!isset($options['posts'])) {$options['posts'] = "";}
        if (!isset($options['pages'])) {$options['pages'] = "";}
        if (!isset($options['homepage'])) {$options['homepage'] = "";}
        if (!isset($options['top'])) {$options['top'] = "";}
        if (!isset($options['btm'])) {$options['btm'] = "";}
        if (!isset($options['tracking'])) {$options['tracking'] = "";}
      ?>
      <table class="form-table">
        <tr valign="top"><th scope="row"><label for="posts">Singular Posts</label></th>
          <td><input id="posts" name="wa_btn[posts]" type="checkbox" value="on" <?php checked('on', $options['posts']); ?> /> <small>This includes all posts, custom post types and attacments.</small></td>
        </tr>
        <tr valign="top"><th scope="row"><label for="pages">Pages</label></th>
          <td><input id="pages" name="wa_btn[pages]" type="checkbox" value="on" <?php checked('on', $options['pages']); ?> /></td>
        </tr>
        <tr valign="top"><th scope="row"><label for="homepage">Homepage</label></th>
          <td><input id="home" name="wa_btn[homepage]" type="checkbox" value="on" <?php checked('on', $options['homepage']); ?> /></td>
        </tr>
        <tr valign="top"><th scope="row"><label for="top">Above Content</label></th>
          <td><input id="top" name="wa_btn[top]" type="checkbox" value="on" <?php checked('on', $options['top']); ?> /></td>
        </tr>
        <tr valign="top"><th scope="row"><label for="btm">Below Content</label></th>
          <td><input id="btm" name="wa_btn[btm]" type="checkbox" value="on" <?php checked('on', $options['btm']); ?> /></td>
        </tr>
        <tr valign="top"><th scope="row"><label for="tracking">Add Tracking</label></th>
          <td><input id="tracking" name="wa_btn[tracking]" type="checkbox" value="on" <?php checked('on', $options['tracking']); ?> /> <small>Enable this to add UTM data onto the shared URL. It doesn't look as pretty but lets you track visits within Google Analytics. Source: WhatsApp. Medium: IM. Name: share button</small></td>
        </tr>
      </table>

      <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
      </p>
    </form>

               <div class="pea_admin_box">
      <h3 class="title">Using the Shortcode</h3>
      <table class="form-table">
        <tr valign="top"><td>
<p>The settings above are for automatic insertion of the WhatsApp Share Button.</p>
<p>You can insert the button manually in any page or post or template by simply using the shortcode <strong>[whatsapp]</strong>. To enter the shortcode directly into templates using PHP, enter <strong>echo do_shortcode('[whatsapp]');</strong></p>
<p>You can also use the options below to override the the settings above.</p>
<ul>
<li><strong>url</strong> - leave blank for current URL</li>
<li><strong>title</strong> - leave blank to display current title</li>
</ul>
<p>Here's an example of using the shortcode:<br><code>[whatsapp url="http://peadig.com/wordpress-plugins/whatsapp-share-button/" title="Check this out!"]</code></p>
<p>You can also insert the shortcode directly into your theme with PHP:<br><code>&lt;?php echo do_shortcode('[whatsapp]'); ?&gt;</code>

          </td>
        </tr>
      </table>
</div>

</div>
            <div class="pea_admin_main_right">
                 <div class="pea_admin_box">

            <center><a href="http://peadig.com/?utm_source=<?php echo $domain; ?>&utm_medium=referral&utm_campaign=WhatsApp%2BAdmin" target="_blank"><img src="<?php echo plugins_url( 'images/peadig-landscape-300.png' , __FILE__ ); ?>" width="220" height="69" title="Peadig">
            <strong>Peadig: the WordPress framework that Integrates Bootstrap</strong></a><br /><br />
            <a href="https://twitter.com/peadig" class="twitter-follow-button">Follow @peadig</a>
      <div class="fb-like" data-href="http://www.facebook.com/peadig" data-layout="button_count" data-action="like" data-show-faces="false"></div>
<div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/116387945649998056474" data-rel="publisher"></div>
<br /><br /><br />


                </div>


                   <center> <h2>Share the plugin love!</h2>
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-like" data-href="<?php echo WABTN_URL; ?>" data-layout="button_count" data-show-faces="true"></div>

                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo WABTN_URL; ?>" data-text="Just been using <?php echo WABTN_NAME; ?> #WordPress plugin" data-via="<?php echo WABTN_AUTHOR_TWITTER; ?>" data-related="WPBrewers">Tweet</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<a href="http://bufferapp.com/add" class="buffer-add-button" data-text="Just been using <?php echo WABTN_NAME; ?> #WordPress plugin" data-url="<?php echo WABTN_URL; ?>" data-count="horizontal" data-via="<?php echo WABTN_AUTHOR_TWITTER; ?>">Buffer</a><script type="text/javascript" src="http://static.bufferapp.com/js/button.js"></script>
                    <div class="g-plusone" data-size="medium" data-href="<?php echo WABTN_URL; ?>"></div>
                    <script type="text/javascript">
                      window.___gcfg = {lang: 'en-GB'};

                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script>
                    <su:badge layout="3" location="<?php echo WABTN_URL?>"></su:badge>
                    <script type="text/javascript">
                      (function() {
                        var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
                        li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
                      })();
                    </script>
<br /><br />
<a href="<?php echo WABTN_DONATE_LINK; ?>" target="_blank"><img class="paypal" src="<?php echo plugins_url( 'images/paypal.gif' , __FILE__ ); ?>" width="147" height="47" title="Please Donate - it helps support this plugin!"></a></center>

                <div class="pea_admin_box">
                    <h2>About the Author</h2>

                    <?php
                    $default = "http://reviews.evanscycles.com/static/0924-en_gb/noAvatar.gif";
                    $size = 70;
                    $alex_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( "alex@peadig.com" ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
                    ?>

                    <p class="pea_admin_clear"><img class="pea_admin_fl" src="<?php echo $alex_url; ?>" alt="Alex Moss" /> <h3>Alex Moss</h3><br />Alex Moss is the Co-Founder of <a href="http://peadig.com/" target="_blank">Peadig</a>, a WordPress framework built with Bootstrap. He has also developed several WordPress plugins (which you can <a href="http://peadig.com/wordpress-plugins/?utm_source=<?php echo $domain; ?>&utm_medium=referral&utm_campaign=WhatsApp%2BPro%2BAdmin" target="_blank">view here</a>) totalling over 500,000 downloads.</p>
<center><br><a href="https://twitter.com/alexmoss" class="twitter-follow-button">Follow @alexmoss</a>
<div class="fb-subscribe" data-href="https://www.facebook.com/alexmoss1" data-layout="button_count" data-show-faces="false" data-width="220"></div>
<div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/+AlexMoss" data-rel="author"></div>
</div>

                    <h2>More from Peadig</h2>
    <p class="pea_admin_clear">
                    <?php
        $WABTN_feed = wa_btn_fetch_rss_feed();
                echo '<ul>';
                foreach ( $WABTN_feed as $item ) {
            $url = preg_replace( '/#.*/', '', esc_url( $item->get_permalink(), $protocolls=null, 'display' ) );
          echo '<li>';
          echo '<a href="'.$url.'?utm_source='.$domain.'&utm_medium=RSS&utm_campaign=WhatsApp%2BPro%2BAdmin" target="_blank">'. esc_html( $item->get_title() ) .'</a> ';
          echo '</li>';
          }
                echo '</ul>';
                    ?></p>


            </div>
        </div>
    </div>



<?php
}

?>