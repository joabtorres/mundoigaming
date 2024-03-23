<?php $this->layout("_theme", ["head" => $head]); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5>Novo registro</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a> </li>
                    <li class="breadcrumb-item"><a href="<?= url("user") ?>"><i class="fas fa-tasks"></i> Usuários</a></li>
                    <li class="breadcrumb-item"><a href="<?= url("user/register") ?>"><i class="fa-solid fa-user-plus"></i> Novo registro</a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <div class="row">
        <div class="col">
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("user/register") ?>">
                <?= csrf_input() ?>
                <input type="hidden" name="id" />
                <div class="ajax_response"><?= flash() ?> </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-user-plus"></i> Novo registro</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="inome">Nome: *</label>
                                        <input type="text" name="first_name" id="inome" class="form-control" required />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome completo</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="ilastname">Sobrenome: *</label>
                                        <input type="text" name="last_name" id="ilastname" class="form-control" required />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o sobrenome</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="imail">E-mail: *</label>
                                        <input type="email" name="email" id="imail" class="form-control" required />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o email</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="ipassword">Senha: *</label>
                                        <input type="password" name="password" id="ipassword" class="form-control" required />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe a senha</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="irpassword">Repetir senha: *</label>
                                        <input type="password" name="rpassword" id="irpassword" class="form-control" required />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o repetir senha</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for='icompany'>Setor: *</label><br />
                                        <select class="custom-select select2-js" name="sector_id" id="icompany" required>
                                            <option value="" disabled selected>Selecione</option>
                                            <?php if (!empty($sectors)) : ?>
                                                <?php foreach ($sectors as $sector) : ?>
                                                    <option value="<?= ($sector->id ?? "") ?>"><?= ($sector->name ?? "") ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <div class="invalid-feedback">Informe o setor</div>
                                    </div>
                                    <?php
                                    if (user()->level > 1) : ?>
                                        <div class="col-md-12 mb-3">
                                            <label for="ilevel">Nivel de acesso:</label> <br>
                                            <select class="custom-select select2-js" name="level" id="ilevel">
                                                <option value="" disabled selected>Selecione</option>
                                                <?php
                                                $levels = list_user_level();
                                                if (!empty($levels)) : ?>
                                                    <?php foreach ($levels as $item) : ?>
                                                        <option value="<?= ($item["value"] ?? "") ?>"><?= ($item["label"] ?? "") ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                            <div class="invalid-feedback">Informe o nível de acesso</div>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="iStatus">Status da conta: </label> <br>
                                            <select class="custom-select select2-js" name="status" id="iStatus">
                                                <option value="" disabled selected>Selecione</option>
                                                <?php
                                                $access = [
                                                    ['value' => 1, "label" => "Acesso permitido"],
                                                    ["value" => 0, "label" => "Acesso revogado"]
                                                ];
                                                if (!empty($access)) : ?>
                                                    <?php foreach ($access as $item) : ?>
                                                        <option value="<?= ($item["value"] ?? "") ?>"><?= ($item["label"] ?? "") ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>

                                    <?php endif; ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button class="btn btn-success" name="nSalvaHistorico" value="true" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i> Salvar</button>
                    <a class="btn btn-danger" href="<?= url_back() ?>"><i class="fa fa-close" aria-hidden="true"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>