<!DOCTYPE html>
<html lang="fr">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?= titleHead($title) ?></title>
    <link rel="icon" href="<?= url('public') ?>/favicon.svg" />

    <?php scripts('head', $scripts) ?>

</head>

<body class="d-flex flex-column">

    <header class="main-header fixed-top d-print-none order-0">
        <?php include path('template') . "/components/header-navbar.php"; ?>
    </header>

    <main class="pb-5 mb-auto order-1">
        <?php include path('template') . "/components/alerts.php" ?>
        <?php include $view; ?>
    </main>

    <?php include path('template') . "/components/button-back-to-top.php"; ?>

    <footer class="main-footer d-print-none order-3">
        <?php include path('template') . "/components/footer.php"; ?>
    </footer>

    <?php include path('template') . "/components/json-data.php"; ?>

    <?php scripts('end', $scripts) ?>

</body>

</html>
