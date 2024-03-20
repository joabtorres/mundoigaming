<?php $this->layout("_theme", ["head" => $head]); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5>Usuario: <?= "{$user->first_name} {$user->last_name}" ?></h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a> </li>
                    <li class="breadcrumb-item"><a href="<?= url("user") ?>"><i class="fas fa-tasks"></i> Usuários</a></li>
                    <li class="breadcrumb-item"><a href="<?= url("user/update/" . $user->id) ?>"><i class="fa-solid fa-user"></i> <?= "{$user->first_name} {$user->last_name}" ?></a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <div class="row">
        <div class="col">
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("user/update/{$user->id}") ?>">
                <?= csrf_input() ?>
                <input type="hidden" name="id" value="<?= ($user->id ?? "") ?>" />
                <div class="ajax_response"><?= flash() ?> </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-user"></i>
                            Usuario</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for="inome">Nome: *</label>
                                        <input type="text" name="first_name" id="inome" class="form-control" required value="<?= ($user->first_name ?? "") ?>" />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome completo</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="ilastname">Sobrenome: *</label>
                                        <input type="text" name="last_name" id="ilastname" class="form-control" required value="<?= ($user->last_name ?? "") ?>" />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o sobrenome</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="imail">E-mail: *</label>
                                        <input type="email" name="email" id="imail" class="form-control" required value="<?= ($user->email ?? "") ?>" />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o email</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="ipassword">Senha: </label>
                                        <input type="password" name="password" id="ipassword" class="form-control" />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe a senha</div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="irpassword">Repetir senha: </label>
                                        <input type="password" name="rpassword" id="irpassword" class="form-control" />
                                        <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o repetir senha</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label for='icompany'>Setor: *</label><br />
                                        <select class="custom-select select2-js" name="sector_id" id="icompany" required>
                                            <?php if (!empty($sectors)) : ?>
                                                <?php foreach ($sectors as $sector) : ?>
                                                    <?php if ($user->sector_id == $sector->id) : ?>
                                                        <option value="<?= ($sector->id ?? "") ?>" selected="selected"><?= ($sector->name ?? "") ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= ($sector->id ?? "") ?>"><?= ($sector->name ?? "") ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <div class="invalid-feedback">Informe o setor</div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="iStatus">Acesso:</label> <br>
                                        <select class="custom-select select2-js" name="status" id="iStatus">
                                            <?php
                                            $access = [
                                                ['value' => 1, "label" => "Acesso permitido"],
                                                ["value" => 0, "label" => "Acesso revogado"]
                                            ];
                                            if (!empty($access)) : ?>
                                                <?php foreach ($access as $item) : ?>
                                                    <?php if ($user->status == $item["status"]) : ?>s
                                                    <option value="<?= ($item["value"] ?? "") ?>"><?= ($item["label"] ?? "") ?></option>
                                                <?php else : ?>
                                                    <option value="<?= ($item["value"] ?? "") ?>"><?= ($item["label"] ?? "") ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </select>
                                    </div>
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