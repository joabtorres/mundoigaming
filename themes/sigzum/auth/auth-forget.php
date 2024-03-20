<?php $this->layout("auth/_theme", ["head" => $head]); ?>

<section class="offset-lg-1 offset-md-2 col-lg-10 me-auto">
    <h5 class="text-white"><strong>Recuperar senha</strong></h5>
    <p class="text-white">Informe seu e-mail para receber um link de recuperação.</p>
    <form class="auth_form" data-reset="true" action="<?= url("/forget") ?>" method="post" enctype="multipart/form-data">
        <?= csrf_input() ?>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"><i class="fa-solid fa-user"></i></div>
            </div>
            <input type="email" name="email" class="form-control border-primary" placeholder="Informe o e-mail" aria-label="Informe o e-mail" required>
        </div>
        <div>
            <div class="m-0 text-end text-secondary mt-1 mb-1">Voltar para página de login?<a href="<?= url("/login") ?>" class="text-white text-decoration-none"> Clique aqui</a></div>
            <button class="btn btn-primary pe-4 ps-4"><i class="fa-solid fa-right-to-bracket"></i>
                Recuperar</button>
        </div>

        <div class="ajax_response"><?= flash() ?></div>
    </form>

</section>