<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <link rel="stylesheet" href="<?= assets('resources/scss/app.scss') ?>">
</head>
<body>
    <?= $this->renderSection('content') ?>
</body>
</html>
