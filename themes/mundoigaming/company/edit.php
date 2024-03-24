<?php $this->layout("_theme", ["head" => $head]); ?>


<div class="container-fluid">
    <div class="row">
        <div class="col" id="pagina-header">
            <h5>Empresa: <?= ($company->full_name ?? "") ?></h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= url() ?>"><i class="fa fa-tachometer-alt"></i> Inicial</a>
                    </li>
                    <li class="breadcrumb-item"><a href="<?= url("company") ?>"><i class="fa-solid fa-hotel"></i>
                            Empresa</a></li>
                    <li class="breadcrumb-item"><a href="<?= url("company/update/{$company->id}") ?>"><i class="fa-solid fa-hotel"></i>
                            <?= ($company->full_name ?? "") ?></a></li>
                </ol>
            </nav>
        </div>
        <!--fim pagina-header;-->
    </div>
    <div class="row">
        <div class="col">
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("company/update/{$company->id}") ?>">
                <?= csrf_input() ?>
                <input type="hidden" name="id" value="<?= ($company->id ?? "") ?>" />
                <div class="ajax_response"><?= flash() ?> </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title h6 mb-1 mt-1"><i class="fa-solid fa-hotel"></i> Empresa</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-12 mb-3">
                                <label for="inome">Nome: *</label>
                                <input name="full_name" id="inome" class="form-control" required value="<?= ($company->full_name ?? "") ?>" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome completo</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="iaddress">Endereço: *</label>
                                <input type="text" name="address" id="iaddress" class="form-control" required value="<?= ($company->address ?? "") ?>" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o endereço</div>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="icpnj">CNPJ: *</label>
                                <input type="text" name="cnpj" id="icpnj" class="form-control" required value="<?= ($company->cnpj ?? "") ?>" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o CNPJ</div>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="iemail">E-mail: *</label>
                                <input type="text" name="email" id="iemail" class="form-control" value="<?= ($company->email ?? "") ?>" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o e-mail</div>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="iphone">Telefone: *</label>
                                <input type="text" name="phone" id="iphone" class="form-control" value="<?= ($company->phone ?? "") ?>" />
                                <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o telefone</div>
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