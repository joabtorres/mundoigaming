<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $head ?>
    <link rel="icon" type="image/gif" href="<?= theme("assets/image/icon.png") ?>" sizes="32x32" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= theme("assets/styles_minify.css") ?>">
    <script>
        base_url = "<?= url() ?>";
    </script>
</head>

<body>
    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <p class="ajax_load_box_title">Aguarde, carregando...</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 bg-light d-flex align-items-center justify-content-center" id="content-logo">
                <div>
                    <img src="<?= theme("assets/image/logo-login.png") ?>" class="mx-auto d-block">
                </div>
            </div>
            <div class="col-md-5 bg-strong pt-3 pb-3" id="content-login">
                <div></div>
                <div class="main-content">
                    <?= $this->section("content"); ?>
                </div>
                <footer class="text-center text-secondary">
                    <i class="fa-solid fa-copyright"></i> 2024 - Desenvolvido com <i class="fa-solid fa-heart text-danger"></i> por <a href="https://joabtorres.com.br/" target="_blank" class="text-decoration-none">Joab
                        Torres</a>
                </footer>
            </div>
        </div>

    </div>

    <script src="<?= theme("/assets/scripts_minify.js"); ?>"></script>
    <?= $this->section("scripts"); ?>
</body>

</html>