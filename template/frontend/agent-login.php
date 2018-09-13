<main style="max-width:100%" class="clearfix width-100" id="main" role="main">
    <div class="fusion-row" style="max-width:100%">
        <div class="container">
            <?php if (isset($hasError) && $hasError): ?>

                <?php
                foreach ($message as $error) {
                    echo "<div class=\"container\">";
                    echo "<div class=\"alert alert-danger\">";
                    echo "<strong>پیغام ! </strong>$error";
                    echo "</div></div>";
                }
                ?>
            <?php endif; ?>
            <div class="row main">
                <div class="panel-heading">
                    <div class="panel-title text-center">
                        <h1 class="title">ورود به <span style="color: #ffc107;"><?php bloginfo('title'); ?></span></h1>
                        <hr/>
                    </div>
                </div>
                <div class="main-login main-center">
                    <form class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="username" class="cols-sm-2 control-label">نام کاربری :</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="username" id="username"
                                           placeholder="لطفاً نام کاربری خود را وارد کنید"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="cols-sm-2 control-label">کلمه عبور :</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="لطفاً کلمه عبور را وارد کنید "/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="cols-sm-2 control-label"><input name="remember" type="checkbox"> مرا به خاطر بسپار
                                !</label>
                        </div>
                        <?php wp_nonce_field('login_user_login', 'login_user_nonce'); ?>
                        <div class="form-group ">
                            <input type="submit" name="login" class="btn-primary" value="ورود به سایت">
                        </div>
                        <div class="login-register">
                            <a href="<?php echo wp_lostpassword_url() ?>">کلمه عبور را فراموش کرده اید ؟</a>
                        </div>
                        <div class="login-register">
                            <a href="<?php echo bloginfo('url').'/register' ?>">ثبت نام در <?php bloginfo('title'); ?></a>
                        </div>
                        <div class="login-register">
                            <a href="<?php bloginfo('url') ?>">بازگشت به صفحه اصلی سایت</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>

