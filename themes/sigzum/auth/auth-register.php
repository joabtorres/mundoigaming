<?php $this->layout("auth/_theme", ["head" => $head]); ?>

<section class="offset-lg-1 offset-md-2 col-lg-10 me-auto">
    <h5 class="text-white mb-0"><strong>Cadastre-se</strong></h5>
    <div class="mb-3 text-end text-secondary mt-1 mb-1">Voltar para página de login?<a href="<?= url("/login") ?>" class="text-white text-decoration-none"> Clique aqui</a></div>
    <form method="post" class="needs-validation" novalidate action="<?= url("/register") ?>">
        <?= csrf_input() ?>
        <div class="row">
            <div class="col-12 mb-2">
                <label for="iname" class="text-white"> <i class="fa-solid fa-user mr-1"></i>Nome:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"></div>
                    </div>
                    <input type="text" name="first_name" id="iname" class="form-control border-primary" placeholder="Informe o nome" aria-label="Informe o nome" required>
                </div>
            </div>
            <div class="col-12 mb-2">
                <label for="ilastname" class="text-white"> <i class="fa-solid fa-user mr-1"></i>Sobrenome:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"></div>
                    </div>
                    <input type="text" name="last_name" id="ilastname" class="form-control border-primary" placeholder="Informe o sobrenome" aria-label="Informe o sobrenome" required>
                </div>
            </div>
            <div class="col-12 mb-2">
                <label for="imail" class="text-white"> <i class="fa-solid fa-envelope mr-1"></i>E-mail:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"></div>
                    </div>
                    <input type="email" name="email" id="imail" class="form-control border-primary" placeholder="Informe o e-mail" aria-label="Informe o e-mail" required>
                </div>
            </div>
            <div class="col-12 mb-2">
                <label for="ipassword" class="text-white"> <i class="fa-solid fa-unlock mr-1"></i>Senha:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"></div>
                    </div>
                    <input type="password" name="password" id="ipassword" class="form-control border-primary" placeholder="Informe a senha" aria-label="Informe a senha" required>
                </div>
            </div>
            <div class="col-12 mb-2">
                <label for="ipix" class="text-white"> <i class="fa-brands fa-pix mr-1"></i>Chave-pix:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text bg-primary text-white border-primary pe-4 ps-4"></div>
                    </div>
                    <input type="text" name="pix" id="ipix" class="form-control border-primary" placeholder="Informe o pix" aria-label="Informe o pix" required>
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-primary pe-4 ps-4"> <i class="fa-solid fa-user-check"></i> Criar Conta</button>
        </div>

        <div class="ajax_response"><?= flash() ?></div>
    </form>

</section>