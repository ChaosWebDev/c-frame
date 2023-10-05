<?php
// * ADD THIS [uncommented] TO PAGES THAT NEED TO ENSURE THE USER IS LOGGED IN * //
// $user = new App\Controllers\UserController();
// $isUserAuthenticated = $user->checkExistingAuthentication();
// * * //
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $_ENV['SITE_TITLE'] ?? $_SESSION['SITE_TITLE'] ?? "Untitled" ?>
    </title>
    <link rel='apple-touch-icon' sizes='180x180' href='/favicons/apple-touch-icon.png'>
    <link rel="shortcut icon" href="/favicons/favicon.ico" type="image/x-icon">
    <link rel='manifest' href='/favicons/manifest.json'>

    <?php
    // * THEME SELECTION * //
    $theme = $_SESSION['settings']['theme'] ?? 'dark';
    if ($theme === 'light') {
        $themeVarsFile = '/styles/light_theme.css';
    } elseif ($theme === 'dark') {
        $themeVarsFile = '/styles/dark_theme.css';
    } else {
        $cTheme = $_SESSION['settings']['theme'] ?? 'cust' . rand(1, 9999);
        $themeVarsFile = "/styles/custom_theme_" . $cTheme . ".css";
    }
    ?>

    <link rel="stylesheet" href="<?php echo $themeVarsFile; ?>">
    <link rel="stylesheet" href="/styles/styles.css">
    <script src='/scripts/jquery.min.js'></script>
</head>

<body>
    [BODY]
</body>

</html>