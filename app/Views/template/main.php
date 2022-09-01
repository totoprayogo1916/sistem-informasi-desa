<!DOCTYPE html>
<html lang="id">

<head>
    <title>Website Desa Bumi Pertiwi</title>
    <meta content="utf-8" http-equiv="encoding">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta property="og:image" content="http://localhost:2772/assets/files/artikel/kecil_logo.jpg">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="180">
    <meta property="og:url" content="http%3A%2F%2Flocalhost%3A2772%2Ffirst">
    <meta property="og:title" content="">
    <meta property="og:site_name" content="Bumi Pertiwi" />
    <link rel="shortcut icon" href="http://localhost:2772/assets/files/logo/logo-kab.png" />
    <link type='text/css' href="http://localhost:2772/assets/front/css/first.css" rel='Stylesheet' />
    <link type='text/css' href="http://localhost:2772/assets/css/ui-buttons.css" rel='Stylesheet' />
    <link type='text/css' href="http://localhost:2772/assets/front/css/colorbox.css" rel='Stylesheet' />
    <script src="http://localhost:2772/assets/front/js/stscode.js"></script>
    <script src="http://localhost:2772/assets/front/js/jquery.js"></script>
    <script src="http://localhost:2772/assets/front/js/layout.js"></script>
    <script src="http://localhost:2772/assets/front/js/jquery.colorbox.js"></script>
    <script>
        $(document).ready(function() {
            $(".group2").colorbox({
                rel: 'group2',
                transition: "fade"
            });
            $(".group3").colorbox({
                rel: 'group3',
                transition: "fade"
            });
        });
    </script>
</head>

<body>
    <div id="maincontainer">
        <?= $this->include('template/header') ?>

        <?= $this->renderSection('content') ?>
        <?= $this->include('template/sidebar') ?>

        <?= $this->include('template/footer') ?>
    </div>
</body>

</html>
