<?php
if (!defined('ABSPATH')) {exit;}
?>

<div class="container">

    <h1><?php echo __(WP_MOODLE_PLUGIN_NM,WP_MOODLE_DOMAIN);?></h1>



    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <li><a data-toggle="tab" href="#dashboard">Coming Soon</a></li>

    </ul>



<div class="tab-content">
    <div id="home" class="tab-pane fade in active">
        <br>
        <form action="options.php" method="post" class="moodle_setting_form">
            <?php settings_fields( 'wp_moodle_group'); ?>
            <?php do_settings_sections( 'wp_moodle_group' ); ?>

            <div class="form-group">
                <label for="moodle_url">Moodle URL:</label>
                <input type="url" class="form-control" id="moodle_url" name="moodle_url" value="<?php echo get_option( 'moodle_url' ); ?>">
            </div>

            <div class="form-group">
                <label for="moodle_token">Moodle Webservice Token:</label>
                <input type="text" class="form-control" id="moodle_token" name="moodle_token" value="<?php echo get_option( 'moodle_token' ); ?>">
            </div>


            <div class="checkbox">
                <label><input name="moodle_disable" type="checkbox" value="disabled" <?php if ( 'disabled' == get_option('moodle_disable')) echo 'checked="checked"'; ?>> Disable Plugin</label>
            </div>
            <?php submit_button(); ?>
        </form>

    </div>

</div>
</div>


<!---->
<!--<h3>Create your Facebook API KEY:</h3>-->
<!--<ul>-->
<!--    <li>1.Go to your <a target="_blank" href="https://www.facebook.com/ads/manager/pixel/facebook_pixel"> Facebook Pixel tab</a> in Ads Manager.</li>-->
<!--    <li>2.Click Create a Pixel.</li>-->
<!--    <li>3.Enter a name for your pixel. You can have only one pixel per ad account, so choose a name that represents your business.</li>-->
<!--    <li>Note: You can change the name of the pixel later from the Facebook Pixel tab.</li>-->
<!--    <li>4.Check the box to accept the terms.</li>-->
<!--    <li>5.Click Create Pixel.</li>-->
<!--    <li>6.Copy code and paste</li>-->
<!--</ul>-->
<!--<h3>You can visit our tutorial to setup Facebook pixel</h3>-->
<!--<iframe width="560" height="315" src="https://www.youtube.com/embed/gAzQSmnyV6M" frameborder="0" allowfullscreen></iframe>-->