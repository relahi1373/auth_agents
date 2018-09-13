<div class="wrap">
    <h1>پنل مدیریت</h1>
    <table class="widefat">
        <tr>
            <th><strong>نام و نام خانوادگی</strong></th>
            <th><strong>ایمیل</strong></th>
            <th><strong>وضعیت صلاحیت نماینده</strong></th>
            <th><strong>موجودی</strong></th>
            <th><strong>اطلاعات بانکی</strong></th>
            <th><strong>عملیات</strong></th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><em><?php echo $user->display_name; ?></em></td>
                <td><em><?php echo $user->user_email; ?></em></td>
                <td>
                    <?php
                    $stat = get_user_meta($user->ID, 'agent_status', true);
                    if ($stat == 'on') {
                        echo '<span style="background: #4caf50;font-size: 14px;padding: 5px 25px;border-radius: 5px;color: #fff;">تایید شده</span>';
                    } else {
                        echo '<span style="background: #E91E63;font-size: 14px;padding: 5px 25px;border-radius: 5px;color: #fff;">تایید نشده</span>';
                    }
                    ?>
                </td>
                <?php $current_user_id = $user->ID; ?>
                <?php $wallet = get_user_meta($current_user_id, '_auth_wallet_value', true); ?>
                <?php if (is_null($wallet)): $wallet = 0; endif; ?>
                <td><?php echo auth_replace_persian_number($wallet) . ' تومان'; ?></td>
                <td><a href="<?php echo add_query_arg(['action' => 'bank_info', 'id' => $user->ID]); ?>"
                       title="اطلاعات بانکی"><span class="dashicons dashicons-external"></span></a></td>
                <td><a href="<?php echo add_query_arg(['action' => 'user_edit', 'id' => $user->ID]); ?>"
                       title="ویرایش اطلاعات"><span class="dashicons dashicons-hammer"></span></a></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>