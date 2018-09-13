<div class="form-wrap">
    <h2>اطلاعات حساب بانکی کاربر </h2>
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
                            <?php echo $info['account_name']; ?>
                        </strong>
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="sheba">شماره شبا : </label>
                </th>
                <td>
                    <h2>
                        <strong style="font-size:18px;">
                            <?php echo $info['sheab_number']; ?>
                        </strong>
                    </h2>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label style="display: inline-block;" for="bank_name">نام بانک : </label>
                </th>
                <td>
                    <h2>
                        <strong style="font-size:18px;">
                            <?php echo $info['bank_name']; ?>
                        </strong>
                    </h2>
                </td>
            </tr>

            </tbody>

        </table>

    </form>

</div>