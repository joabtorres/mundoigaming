<?php $this->layout("auth/_theme", ["head" => $head]); ?>

<section class="offset-lg-1 offset-md-2 col-lg-10 me-auto">
    <p class="m-0 text-end text-secondary mt-1 mb-1">Ainda não tem conta? <a title="Cadastre-se" href="<?= url("/register") ?>" class="text-white text-decoration-none bg-primary p-1 rounded">Cadastre-se!</a></p>
    <h5 class="text-white"><strong>Fazer Login</strong></h5>
    <form class="auth_form" action="<?= url("/login") ?>" method="post" enctype="multipart/form-data">
        <?= csrf_input() ?>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"><i class="fa-solid fa-user"></i></div>
            </div>
            <input type="email" name="email" class="form-control border-primary" placeholder="Informe o e-mail" aria-label="Informe o e-mail" required>
        </div>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"><i class="fa-solid fa-lock"></i></div>
            </div>
            <input type="password" name="password" class="form-control" placeholder="Informe a senha" aria-label="Informe a senha" required>
        </div>
        <div>
            <div class="m-0 text-end text-secondary mt-1 mb-1">Esqueceu a senha? <a href="<?= url("/forget") ?>" class="text-white text-decoration-none">Clique aqui</a></div>
            <button class="btn btn-primary pe-4 ps-4"><i class="fa-solid fa-right-to-bracket"></i>
                Entrar</button>
        </div>

        <div class="ajax_response"><?= flash() ?></div>
    </form>

</section>