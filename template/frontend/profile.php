<?php// auth_load_templates('header', compact(''), 'frontend'); ?>
<main style="max-width:100%" class="clearfix width-100" id="main" role="main">
    <div class="fusion-row" style="max-width:100%">
<div class="container">
    <?php foreach ($user as $name): ?>
        <h4 style="text-align:right;direction:rtl;color: #9c27b0;"><?php echo 'سلام '.$name . ' :)'; ?></h4>
    <?php endforeach; ?>
    <?php $wallet = get_user_meta($current_user_id,'_auth_wallet_value',true); ?>
    <?php if (empty($wallet)): $wallet=0; endif; ?>
    <?php echo '<p style="text-align: right;color: #9c27b0;direction: rtl;">موجودی کیف پول : '.$wallet.' تومان می باشد .</p>'; ?>
    <?php echo get_user_meta($current_user_id,'account_name',true); ?>
    <div class="row main">
        <div class="alert alert-warning">
            <a href="<?php echo home_url(); ?>" class="alert-link">صفحه اصلی سایت</a>
            <?php if (!auth_is_admin()): ?>
                <a class="info-complate-agent" href="<?php echo home_url('information'); ?>" class="alert-link">تکمیل
                    اطلاعات نمایندگی</a>
            <?php endif; ?>
            <a href="<?php echo home_url( 'auth-wallet' ); ?>" class="alert-link">کیف پول</a>
            <a href="<?php echo home_url( 'pony-request' ); ?>" class="alert-link">درخواست موجودی</a>
            <a href="<?php echo wp_logout_url(); ?>" class="alert-link">خروج از حساب کاربری</a>
        </div>
        <?php if (!current_user_can('manage_options')): ?>
            <div class="alert alert-info">
                <strong>راهنما</strong>
                <ul>
                    <li>همکار گرامی برای شروع کار در وب سایت ابتدا باید از طریق منوی <strong>تکمیل اطلاعات
                            نمایندگی</strong> تمامی مدارک و اطلاعات مورد نیاز را برای مدیریت ارسال نمایید .
                    </li>
                    <li>برای مشاهده قیمت عمده محصولات <strong> فروشگاه</strong> ابتدا باید منتظر تایید اطلاعات و مدارک
                        ارسالی توسط مدیریت باشید .
                    </li>
                    <li>پس از تایید اطلاعات توسط مدیریت پیام های اطلاع رسانی از طریق <strong>ایمیل</strong> و <strong>پیام
                            کوتاه</strong> برای شما ارسال خواهد شد .
                    </li>
                    <li>پس از هربار خرید عمده از فروشگاه سایت ، <?php echo auth_replace_persian_number(2); ?> درصد از
                        مبلغ خرید در کیف پول شما شارژ خواهد شد .
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
</div>
</div>
</main>
<?php get_footer(); ?>
