<section class="modal fade" id="novo-registro" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-md modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-light">
                <h5 class="modal-title"><i class="fa-solid fa-swatchbook"></i> Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <form method="post" class="needs-validation" novalidate enctype="multipart/form-data" action="<?= url("list_id/register") ?>">
                    <?= csrf_input() ?>
                    <div class="ajax_response"></div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="if">Id: *</label>
                            <input name="identify" id="if" class="form-control" required />
                            <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o ID</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="inome">Nome: * </label>
                            <input name="name" id="inome" class="form-control" required />
                            <div class="invalid-feedback"><i class="fa fa-info-circle"></i> Informe o nome</div>
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