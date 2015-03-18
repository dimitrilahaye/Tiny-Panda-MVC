<html>
    <head>
        <title><?= $user->getPrenom().$user->getNom() ?></title>
    </head>
    <body>
        <h1><?= $user->getNom() ?></h1>
        <p><?= $user->getPrenom() ?></p>
    </body>
</html>