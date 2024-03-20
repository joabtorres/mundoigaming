<?php $this->layout("auth/_theme", ["head" => $head]); ?>

<section class="offset-lg-1 offset-md-2 col-lg-10 me-auto">
    <h5 class="text-white"><strong>Criar nova senha</strong></h5>
    <p class="text-white">Informe e repita uma nova senha para recuperar o acesso.</p>
    <form class="auth_form" data-reset="true" action="<?= url("/forget/reset") ?>" method="post" enctype="multipart/form-data">
        <?= csrf_input() ?>
        <input type="hidden" name="code" value="<?= $code; ?>" />
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"><i class="fa-solid fa-lock"></i></div>
            </div>
            <input type="password" name="password" class="form-control" placeholder="Nova senha" aria-label="Nova senha" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"><i class="fa-solid fa-lock"></i></div>
            </div>
            <input type="password" name="password_re" class="form-control" placeholder="Repita a nova senha" aria-label="Repita a nova senha" required>
        </div>
        <div>
            <button class="btn btn-primary pe-4 ps-4"><i class="fa-solid fa-right-to-bracket"></i>
                Alterar Senha</button>
        </div>

        <div class="ajax_response"><?= flash() ?></div>
    </form>

</section>