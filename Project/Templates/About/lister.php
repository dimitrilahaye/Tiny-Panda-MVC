<html>
    <head>
        <title>Liste de users</title>
    </head>
    <body>
        <?php
            foreach($users as $user){ ?>
                 <h1><?= $user->getName() ?></h1>
            <?php } ?>
    </body>
</html>