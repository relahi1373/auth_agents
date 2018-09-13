<!doctype html>
<html lang="<?php language_attributes(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>حساب کاربری من</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo AUTH_ASS_CSS . 'fontiran.css'; ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo AUTH_ASS_CSS . 'main.css'; ?>" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="<?php echo AUTH_ASS_JS . 'main.js'; ?>"></script>

</head>
<body class="<?php body_class(); ?>">

<div id="wrapper">
    <div class="overlay"></div>

    <!-- Sidebar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
        <ul class="nav sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    پیشخوان
                </a>
            </li>
            <li>
                <a href="<?php echo home_url( 'profile' ); ?>">پروفایل</a>
            </li>
            <li>
                <a href="<?php echo home_url( 'auth-wallet' ); ?>">موجودی کیف پول</a>
            </li>
            <li>
                <a href="<?php echo home_url( 'pony-request' ); ?>">درخواست موجودی</a>
            </li>
            <li>
                <a href="/logout">خروج از پیشخوان</a>
            </li>
        </ul>
    </nav>
    <!-- /#sidebar-wrapper -->
    <div id="page-content-wrapper">
        <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
        </button>


        <!--            <li class="dropdown">-->
        <!--                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Works <span class="caret"></span></a>-->
        <!--                <ul class="dropdown-menu" role="menu">-->
        <!--                    <li class="dropdown-header">Dropdown heading</li>-->
        <!--                    <li><a href="#">Action</a></li>-->
        <!--                    <li><a href="#">Another action</a></li>-->
        <!--                    <li><a href="#">Something else here</a></li>-->
        <!--                    <li><a href="#">Separated link</a></li>-->
        <!--                    <li><a href="#">One more separated link</a></li>-->
        <!--                </ul>-->
        <!--            </li>-->