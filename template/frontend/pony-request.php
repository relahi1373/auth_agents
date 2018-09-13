<main style="max-width:100%" class="clearfix width-100" id="main" role="main">
    <div class="fusion-row" style="max-width:100%">
        <div class="container">
            <?php if ($hasSuccess): ?>
                <div class="alert alert-success" role="alert">
                    <?php foreach ($message as $key => $value): ?>
                        <strong>
                            <?php echo $value; ?>
                        </strong>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($hasError) && $hasError): ?>

                <?php
                foreach ($message as $key => $value) {

                    echo "<div class=\"alert alert-danger\">";
                    echo "<strong>پیغام خطا ! </strong> $value";
                    echo "</div>";
                }
                ?>
            <?php endif; ?>
            <div class="row main">
                <div class="panel-heading">
                    <div class="panel-title text-center">
                        <h1 class="title">تکمیل اطلاعات حساب کاربری جهت دریافت موجودی کیف پول </h1>
                        <h3 style="color: #00bcd4">در پایان سال مبلغی که به کیف پول شما تاکنون افزوده شده به این حساب
                            واریز خواهد شد .</h3>
                        <hr/>
                    </div>
                </div>
                <div class="main-login main-center">

                    <form name="registration_account_info" class="form-horizontal" method="post" action="">

                        <div class="form-group">
                            <label for="account_name" class="cols-sm-2 control-label">نام دارنده حساب : </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa"
                                                                               aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="account_name" id="account_name"
                                           placeholder="نام دارنده حساب"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="display: block;" for="sheba_number" class="cols-sm-2 control-label">شماره
                                شبا:</label>
                            <em style="color: #ffab00;font-size: 10px;">کد 26 کاراکتری بدون خط تیره (شروع با IR و سپس
                                اعداد
                                انگلیسی)</em>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa"
                                                                           aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="sheba_number" id="sheba_number"
                                           placeholder="شماره شبا"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bank_name" class="cols-sm-2 control-label">نام بانک :</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users fa"
                                                                           aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="bank_name" id="bank_name"
                                           placeholder="نام بانک مقصد"/>
                                </div>
                            </div>
                        </div>

                        <?php wp_nonce_field('register_account_info_field', 'register_account_info_field_nonce'); ?>

                        <div class="form-group ">
                            <input type="submit" name="register_account_info" class="btn-primary"
                                   value="ثبت اطلاعات حساب">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>
<?php get_footer(); ?>