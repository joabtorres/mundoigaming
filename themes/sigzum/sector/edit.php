<?php $this->layout("_theme", ["head" => $head]); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5>Setor: <?= ($sector->name ?? "") ?></h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= url("sector") ?>"><i class="fa-solid fa-sitemap"></i>
                            Setores</a></li>
                    <li class="breadcrumb-item"><a href="<?= url("sector/update/{$sector->id}") ?>"><i class="fa-solid fa-sitemap"></i>
                            <?= ($sector->name ?? "") ?></a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <div class="row">
        <div class="col">
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("sector/update/{$sector->id}") ?>">
                <?= csrf_input() ?>
                <input type="hidden" name="id" value="<?= ($sector->id ?? "") ?>" />
                <div class="ajax_response"><?= flash() ?> </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-sitemap"></i>
                            Setores</h4>
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
                                <input name="name" id="inome" class="form-control" required value="<?= ($sector->name ?? "") ?>" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome completo</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="abber">Abreviação:</label>
                                <input type="text" name="abbreviation" id="abber" class="form-control" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe a abreviação</div>
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