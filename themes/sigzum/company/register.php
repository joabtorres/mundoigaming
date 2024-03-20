<section class="modal fade" id="novo-registro" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-light">
                <h5 class="modal-title"><i class="fa-solid fa-hotel"></i> Empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("company/register") ?>">
                    <?= csrf_input() ?>
                    <div class="ajax_response"><?= flash() ?></div>
                    <div class="form-row">
                        <div class="col-12 mb-3">
                            <label for="inome">Nome: *</label>
                            <input name="full_name" id="inome" class="form-control" required />
                            <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome completo</div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="iaddress">Endereço: *</label>
                            <input type="text" name="address" id="iaddress" class="form-control" required />
                            <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o endereço</div>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="icpnj">CNPJ: *</label>
                            <input type="text" name="cnpj" id="icpnj" class="form-control" required />
                            <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o CNPJ</div>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="iemail">E-mail: *</label>
                            <input type="text" name="email" id="iemail" class="form-control" />
                            <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o e-mail</div>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="iphone">Telefone: *</label>
                            <input type="text" name="phone" id="iphone" class="form-control" />
                            <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o telefone</div>
                        </div>
                    </div>
                    <button class="btn btn-success" name="nSalvaHistorico" value="true" type="submit"><i class="fa fa-check-circle" aria-hidden="true"></i> Salvar</button>
                </form>
            </article>
            <footer class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>