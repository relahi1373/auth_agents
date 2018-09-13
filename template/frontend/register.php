<main style="max-width:100%" class="clearfix width-100" id="main" role="main">
    <div class="fusion-row" style="max-width:100%">
        <div class="container">
            <?php if (isset($hasError) && $hasError): ?>

                <?php
                foreach ($message as $key => $value) {

                    echo "<div class=\"alert alert-danger\">";
                    echo "<strong>پیغام خطا ! </strong> $value";
                    echo "</div>";
                }
                ?>
            <?php endif; ?>
            <?php if (isset($hasTrue) && $hasTrue): ?>

                <?php
                echo "<div class=\"container\">";
                echo "<div class=\"alert alert-success\">";
                echo "<strong>تبریک !</strong>. ثبت نام شما با موفقیت انجام شد ";
                echo "</div></div>";
                wp_redirect('auth/login');

                ?>

            <?php endif; ?>
            <div class="row main">
                <div class="panel-heading">
                    <div class="panel-title text-center">
                        <h1 class="title">ثبت نام در <span style="color: #ffc107;"><?php bloginfo('title'); ?></span>
                        </h1>
                        <hr/>
                    </div>
                </div>
                <div class="main-login main-center">
                    <form name="registration_user" class="form-horizontal" method="post" action="">

                        <div class="form-group">
                            <label for="name" class="cols-sm-2 control-label">نام و نام خانوادگی(الزامی) : </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa"
                                                                               aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="نام و نام خانوادگی"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="cols-sm-2 control-label">ایمیل شما(اختیاری) :</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                                           aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="email" id="email"
                                           placeholder="ایمیل"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username" class="cols-sm-2 control-label">نام کاربری(الزامی) :</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users fa"
                                                                           aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="username" id="username"
                                           placeholder="نام کاربری"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="display: block;" for="password" class="cols-sm-2 control-label">کلمه عبور(الزامی)
                                :</label>
                            <em style="color: #ffab00;font-size: 12px;">از اعداد 0-9 و حروف A-Z ,a-z و کاراکترهای
                                (@،%،$،#) استفاده شود.</em>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                                           aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" name="password" id="password"
                                           placeholder="کلمه عبور"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="display: block;" for="confirm" class="cols-sm-2 control-label">تایید کلمه
                                عبور(الزامی) :</label>
                            <em style="color: #ffab00;font-size: 12px;">کلمه عبور خود را مجدداً در فیلد زیر تکرار کنید
                                .</em>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg"
                                                                           aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" name="confirm" id="confirm"
                                           placeholder="تایید کلمه عبور"/>
                                </div>
                            </div>
                        </div>
                        <?php wp_nonce_field('register_agent', 'register_agent_nonce'); ?>

                        <div class="form-group ">
                            <input type="submit" name="register" class="btn-primary" value="ثبت نام">
                        </div>
                        <div class="login-register">
                            <a href="<?php echo bloginfo('url').'/agent-login' ?>">برای ورود به <?php bloginfo('title'); ?> کلیک کنید .</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>