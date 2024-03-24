<?php $this->layout("_theme", ["head" => $head]); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5><?= ($listId->name ?? "") ?></h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= url("list_id") ?>"><i class="fa-solid fa-list-ol"></i> Lista de ID</a></li>
                    <li class="breadcrumb-item"><a href="<?= url("list_id/update/{$listId->id}") ?>"><i class="fa-solid fa-swatchbook"></i>
                            <?= ($listId->name ?? "") ?></a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <div class="row">
        <div class="col">
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("list_id/update/{$listId->id}") ?>">
                <?= csrf_input() ?>
                <input type="hidden" name="id" value="<?= ($listId->id ?? "") ?>" />
                <div class="ajax_response"><?= flash() ?> </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-swatchbook"></i> Status</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="if">Id: *</label>
                                <input name="identify" id="if" class="form-control" required  value="<?= ($listId->identify ?? "") ?>"/>
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o ID</div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="inome">Nome: * </label>
                                <input name="name" id="inome" class="form-control" required  value="<?= ($listId->identify ?? "") ?>"/>
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button class="btn btn-success" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i> Salvar</button>
                    <a class="btn btn-danger" href="<?= url_back() ?>"><i class="fa fa-close" aria-hidden="true"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>