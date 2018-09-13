<?php
//auth_load_templates('header', compact(''), 'frontend');
//?>
    <main style="max-width:100%" class="clearfix width-100" id="main" role="main">
        <div class="fusion-row" style="max-width:100%">
            <div class="container">
                <?php $wallet = get_user_meta($id, '_auth_wallet_value', true); ?>
                <?php if (is_null($wallet)): $wallet = 0; ?>
                <?php else: ?>
                    <?php echo '<p style="text-align: right;color: #9c27b0;direction: rtl;"><i class="fas fa-dollar-sign"></i> موجودی کیف پول : ' . $wallet . ' تومان می باشد .</p>'; ?>
                <?php endif; ?>
                <div class="row main">
                    <div class="alert alert-warning">
                        <a href="<?php echo home_url('wp-admin'); ?>" class="alert-link">پیشخوان</a>
                        <a href="<?php echo home_url(); ?>" class="alert-link">صفحه اصلی سایت</a>
                        <?php if (!auth_is_admin()): ?>
                            <a class="info-complate-agent" href="<?php echo home_url('information'); ?>"
                               class="alert-link">تکمیل
                                اطلاعات نمایندگی</a>
                        <?php endif; ?>
                        <a href="<?php echo home_url('pony-request'); ?>" class="alert-link">درخواست موجودی</a>
                        <a href="<?php echo wp_logout_url(); ?>" class="alert-link">خروج از حساب کاربری</a>
                    </div>
                    <div class="alert alert-info">
                        <strong>موجودی کیف پول در پایان هر سال با شما تسویه خواهد شد .</strong>
                        <li>بسته به مقدار خرید و همچنین درصد کیف پولی که برای هر محصول توسط مدیریت فروشگاه تنظیم می شود
                            موجودی افزایش خواهد یافت .
                        </li>
                    </div>
                </div>
            </div>
        </div>
        </div>

        </div>
    </main>
<?php get_footer(); ?>