<div class="wrap">
    <h1>تنظیمات طراحی</h1>
    <form action="" method="post">
		<?php foreach ( $themes as $theme => $title ) : ?>
            <input type="radio" name="auth_color"
                   value="<?php echo $theme ?>" <?php echo $default_theme == $theme ? 'checked' : '' ?> >
            <label for="auth_color"><?php echo $title; ?></label>
		<?php endforeach; ?>
        <?php echo do_shortcode("[auth_dramatist_front_upload]"); ?>
        <button name="auth_save_options" type="submit">فعال کردن</button>
    </form>
</div>