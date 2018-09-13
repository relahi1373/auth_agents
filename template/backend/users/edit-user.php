<?php $url = content_url(); ?>
<div class="form-wrap">
    <h2>مرحله احراز هویت نماینده</h2>
    <form class="validate" action="" method="post">
        <table class="form-table">
            <tbody>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="name">نام و نام خانوادگی : </label>
                </th>
                <td>
                    <h2>
                        <strong style="font-size:18px;">
                            <?php echo $user->display_name; ?>
                        </strong>
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="user_name">نام کاربری : </label>
                </th>
                <td>
                    <h2>
                        <strong style="font-size:18px;">
                            <?php echo $user->user_login; ?>
                        </strong>
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="user_email">ایمیل : </label>
                </th>
                <td>
                    <h2>
                        <strong style="font-size:18px;">
                            <?php echo $user->user_email; ?>
                        </strong>
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="national_code">کد ملی نماینده :</label>
                </th>
                <td>
                    <h2>
                        <input type="text" name="national_code" id="national_code"
                               value="<?php echo auth_replace_persian_number($info['national_code']); ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="store_name">نام فروشگاه :</label>
                </th>
                <td>
                    <h2>
                        <input type="text" name="store_name" id="store_name" value="<?php echo $info['store_name']; ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="store_address">آدرس فروشگاه :</label>
                </th>
                <td>
                    <h2>
                        <input type="text" name="store_address" id="store_address"
                               value="<?php echo $info['address']; ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="postal_code">کد پستی :</label>
                </th>
                <td>
                    <h2>
                        <input type="text" name="postal_code" id="postal_code"
                               value="<?php echo auth_replace_persian_number($info['postal_code']); ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="landline_phone">تلفن ثابت :</label>
                </th>
                <td>
                    <h2>
                        <input type="text" name="landline_phone" id="landline_phone"
                               value="<?php echo auth_replace_persian_number($info['landline_phone']); ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="phone">تلفن همراه :</label>
                </th>
                <td>
                    <h2>
                        <input type="text" name="phone" id="phone"
                               value="<?php echo auth_replace_persian_number($info['phone']); ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="business_no">شماره جواز کسب :</label>
                </th>
                <td>
                    <h2>
                        <input type="text" name="business_no" id="business_no"
                               value=" <?php echo auth_replace_persian_number($info['business_license']); ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="economic_no">شماره اقتصادی :</label>

                </th>
                <td>
                    <h2>
                        <input type="text" name="economic_no" id="economic_no"
                               value=" <?php echo auth_replace_persian_number($info['economic_identifier']); ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="register_company_no">شماره ثبت شرکت :</label>

                </th>
                <td>
                    <h2>
                        <input type="text" name="register_company_no" id="register_company_no"
                               value=" <?php echo auth_replace_persian_number($info['compony_register_num']); ?>">
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="font-weight: 600; margin-bottom: 20px;" for="national_code_img">تصویر کارت ملی نماینده
                        :</label>
                </th>
                <td>
                    <?php if (empty($info['upload_img_national_card'])): ?>
                        <em style="color: red;">برای این قسمت تصویری آپلود نشده است .</em>
                    <?php else: ?>
                        <img width="500" height="300"
                             src="<?php echo $url . '/uploads/' . $info['upload_img_national_card']; ?>" alt="">
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="font-weight: 600; margin-bottom: 20px;" for="business_license_img">تصویر جواز کسب
                        :</label>
                </th>
                <td>
                    <?php if (empty($info['upload_img_business_license'])): ?>
                        <em style="color: red;">برای این قسمت تصویری آپلود نشده است .</em>
                    <?php else: ?>
                        <img width="500" height="300"
                             src="<?php echo $url . '/uploads/' . $info['upload_img_business_license']; ?>" alt="">
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="font-weight: 600; margin-bottom: 20px;" for="latest_newspaper_img">تصویر آخرین روزنامه
                        رسمی شرکت
                        :</label>
                </th>
                <td>
                    <?php if (empty($info['upload_img_newspaper'])): ?>
                        <em style="color: red;">برای این قسمت تصویری آپلود نشده است .</em>
                    <?php else: ?>
                        <img width="500" height="300"
                             src="<?php echo $url . '/uploads/' . $info['upload_img_newspaper']; ?>"
                             alt="">
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="agent_status">تایید صلاحیت کاربر به عنوان نماینده
                        فروش</label>
                </th>
                <td>
                    <input type="checkbox" name="agent_status"
                        <?php echo $status == 'on' ? 'checked' : '' ?> >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="editbtn">ذخیره سازی اطلاعات</label>
                </th>
                <td>
                    <?php echo get_submit_button('ویرایش', 'primary', 'editbtn', true); ?>
                </td>
            </tr>

            </tbody>

        </table>

    </form>

</div>