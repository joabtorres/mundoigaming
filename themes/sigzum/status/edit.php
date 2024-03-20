<?php $this->layout("_theme", ["head" => $head]); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5>Setor: <?= ($status->name ?? "") ?></h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= url("status") ?>"><i class="fa-solid fa-swatchbook"></i> Status</a></li>
                    <li class="breadcrumb-item"><a href="<?= url("status/update/{$status->id}") ?>"><i class="fa-solid fa-swatchbook"></i>
                            <?= ($status->name ?? "") ?></a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <div class="row">
        <div class="col">
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("status/update/{$status->id}") ?>">
                <?= csrf_input() ?>
                <input type="hidden" name="id" value="<?= ($status->id ?? "") ?>" />
                <div class="ajax_response"><?= flash() ?> </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-swatchbook"></i> Status</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for='icompany'>Empresa: </label><br />
                                <select class="custom-select select2-js" name="company" id="icompany">
                                    <?php if (!empty($companies)) : ?>
                                        <?php foreach ($companies as $company) : ?>
                                            <option value="<?= ($company->id ?? "") ?>"><?= ($company->full_name ?? "") ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback">Informe o setor</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inome">Nome: *</label>
                                <input name="name" id="inome" class="form-control" required value="<?= ($status->name ?? "") ?>" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome completo</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for='icor'>Cores: </label><br />
                                <select class="custom-select select2-js" name="class_color" id="icor">
                                    <?php foreach (backgroundColorOptions() as $bgColor) :  ?>
                                        <?php if ($status->class_color == $bgColor["value"]) : ?>
                                            <option value="<?= ($bgColor["value"] ?? "") ?>" selected="true"><?= ($bgColor["label"] ?? "") ?></option>
                                        <?php else : ?>
                                            <option value="<?= ($bgColor["value"] ?? "") ?>"><?= ($bgColor["label"] ?? "") ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Informe o setor</div>
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