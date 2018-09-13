<main style="max-width:100%" class="clearfix width-100" id="main" role="main">
    <div class="fusion-row" style="max-width:100%">
        <div class="container">
            <?php if (isset($hasError) && $hasError): ?>

                <?php
                foreach ($message as $key => $value) {

                    echo "<div class=\"alert alert-danger\">";
                    echo "<strong>مهمترین خطا ! </strong> $value" . '<br>' .
                        '<strong>فیلدهای کد ملی و کد پستی باید 10 رقمی باشد .</strong>' . '<br>'
                        . '<strong>از بین فیلد های شماره جواز کسب و شماره ثبت شرکت یکی به دلخواه پر شود.</strong>' . '<br>'
                        . '<strong>فیلدهای تلفن ثابت و تلفن همراه باید 11 رقمی باشد .</strong>' . '<br>'
                        . '<strong>فیلد کد پستی را بدون خط فاصله وارد کنید .</strong>';
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
                <div class="alert alert-info">
                    <strong>نکته !</strong>
                    <ul>
                        <li>پر کردن یکی از فیلد های شماره جواز کسب و شماره ثبت شرکت الزامی است .</li>
                        <li>آپلود یکی از تصاویر جواز کسب و یا تصویر آخرین روزنامه رسمی شرکت الزامی است .</li>
                        <li>پر کردن فیلد شناسه اقتصادی اختیاری است .</li>
                        <li>آپلود تصویر کارت ملی اختیاری است .</li>
                        <li>فیلد کد پستی را بدون کارکتر (-) وارد کنید .</li>
                    </ul>
                </div>
                <div class="panel-heading">
                    <div class="panel-title text-center">
                        <h1 class="title">ثبت نام نمایندگان فروش در <span
                                    style="color: #ffc107;"><?php bloginfo('title'); ?></span>
                        </h1>
                        <hr/>
                    </div>
                </div>
                <div class="main-login main-center" style="max-width: 900px">
                    <!------ Include the above in your HEAD tag ---------->
                    <form name="registration_user" class="form-horizontal" method="post" action=""
                          enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="national_code" class="cols-sm-2 control-label">کد ملی(الزامی)
                                : </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user fa"
                                                                               aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="national_code"
                                           id="national_code"
                                           placeholder="کد ملی"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="store_name" class="cols-sm-2 control-label">نام فروشگاه(الزامی)
                                : </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-shopping-cart"
                                                                               aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="store_name"
                                           id="store_name"
                                           placeholder="نام فروشگاه"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="store_address" class="cols-sm-2 control-label">آدرس
                                فروشگاه(الزامی)
                                : </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker-alt"
                                                                               aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="store_address"
                                           id="store_address"
                                           placeholder="آدرس فروشگاه"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="postal_code" class="cols-sm-2 control-label">کد پستی(الزامی)
                                : </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                            <span class="input-group-addon"><i class="far fa-address-card"
                                                                               aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="postal_code"
                                           id="postal_code"
                                           placeholder="کد پستی"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="landline_phone" class="cols-sm-2 control-label">تلفن
                                ثابت(الزامی)
                                : </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-phone"
                                                                               aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="landline_phone"
                                           id="landline_phone"
                                           placeholder="تلفن ثابت"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="cols-sm-2 control-label">تلفن همراه(الزامی)
                                : </label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-mobile"
                                                                               aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="phone"
                                           id="phone"
                                           placeholder="تلفن همراه"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="economic_identifier" class="cols-sm-2 control-label">شناسه
                                اقتصادی
                                (اختیاری) :</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="far fa-address-card"
                                                                           aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="economic_identifier"
                                           id="economic_identifier"
                                           placeholder="شناسه اقتصادی (اختیاری)"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="business_license" class="cols-sm-2 control-label">شماره جواز کسب(الزامی)
                                :</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="far fa-address-card"
                                                                           aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="business_license"
                                           id="business_license"
                                           placeholder="شماره جواز کسب"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="compony_register_num" class="cols-sm-2 control-label">شماره ثبت شرکت(الزامی)
                                :</label>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="far fa-address-card"
                                                                           aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="compony_register_num"
                                           id="compony_register_num"
                                           placeholder="شماره ثبت شرکت"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="upload_img_national_card"
                                   class="cols-sm-2 control-label">آپلود تصویر کارت
                                ملی (الزامی) :</label>
                            <em style="color: #ffab00;font-size: 12px;">فرمت های مجاز (jpeg,png)،حداکثر سایز
                                فایل
                                2MB</em>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-cloud-upload-alt"
                                                                           aria-hidden="true"></i></span>
                                    <input type="file" class="form-control" name="upload_img_national_card"
                                           id="upload_img_national_card" accept="image/jpeg, image/png"
                                           placeholder="لطفا یک تصویر انتخاب کنید ..."/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="upload_img_business_license" class="cols-sm-2 control-label">آپلود
                                تصویر
                                جواز کسب(الزامی) :</label>
                            <em style="color: #ffab00;font-size: 12px;">فرمت های مجاز (jpeg,png)،حداکثر سایز
                                فایل
                                2MB</em>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-cloud-upload-alt"
                                                                           aria-hidden="true"></i></span>
                                    <input type="file" class="form-control"
                                           name="upload_img_business_license"
                                           id="upload_img_business_license" accept="image/jpeg, image/png"
                                           placeholder="لطفا یک تصویر انتخاب کنید ..."/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="upload_img_newspaper" class="cols-sm-2 control-label">آپلود تصویر
                                آخرین
                                روزنامه رسمی شرکت(الزامی) :</label>
                            <em style="color: #ffab00;font-size: 12px;">فرمت های مجاز (jpeg,png)،حداکثر سایز
                                فایل
                                2MB</em>
                            <div class="cols-sm-10">
                                <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-cloud-upload-alt"
                                                                           aria-hidden="true"></i></span>
                                    <input type="file" class="form-control" name="upload_img_newspaper"
                                           id="upload_img_newspaper" accept="image/jpeg, image/png"
                                           placeholder="لطفا یک تصویر انتخاب کنید ..."/>
                                </div>
                            </div>
                        </div>
                        <?php wp_nonce_field('register_info', 'register_info_nonce'); ?>
                        <div class="form-group ">
                            <input type="submit" name="register_meta_data" class="btn-primary"
                                   value="ثبت نام نماینده فروش">
                        </div>
                        <div class="login-register">
                            <a href="profile.php">برای بازگشت به پروفایل کلیک کنید .</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>