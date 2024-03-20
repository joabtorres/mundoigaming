<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $head ?>
    <link rel="icon" type="image/gif" href="<?= theme("assets/image/icon.png") ?>" sizes="32x32" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        html,
        body,
        * {
            font-family: "Quicksand", sans-serif;
        }

        html,
        body {
            background-color: #f0eded;
        }

        header>* {
            margin: 0;
            margin-bottom: 10px;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            text-align: center;
        }

        .content {
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .error {
            font-size: 24px;
            margin-top: 0;
        }

        .text-center {
            text-align: center;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1B2044;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        h1 {
            color: #1B2044;
        }

        .btn:hover {
            background-color: #1F7BDA;
        }
    </style>
</head>

<body>
    <article class="not_found">
        <div class="container content">
            <header>
                <img src="<?= theme("assets/image/page-error.png") ?>" />
                <p class="error text-center">&bull;<?= $error->code; ?>&bull;</p>
                <h1 class="text-center"><?= $error->title; ?></h1>
                <p class="text-center"><?= $error->message; ?></p>
                <?php if ($error->link) : ?>
                    <a class="btn" title="<?= $error->linkTitle; ?>" href="<?= $error->link; ?>"><?= $error->linkTitle; ?></a>
                <?php endif ?>
            </header>
        </div>
    </article>
</body>

</html>