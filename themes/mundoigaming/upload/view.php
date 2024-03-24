<section class="modal fade" id="modal_view_<?= md5($upload->id) ?>" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-default">
                <h5 class="modal-title"><i class="fa-solid fa-bullhorn"></i> Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="align-middle bg-secondary">Arquivo: </td>
                            <td class="align-middle"> <?= ($upload->description ?? "") ?></td>
                        </tr>

                        <tr>
                            <td class="align-middle bg-secondary">Usuário: </td>
                            <td class="align-middle"> <?= ("{$upload->user()->first_name} {$upload->user()->last_name}" ?? "") ?> </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Status: </td>
                            <td class="align-middle"><span class="p-1 rounded <?= ($upload->status()->class_color ?? "") ?>"><?= ($upload->status()->name ?? "") ?></span></td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Cadastro: </td>
                            <td class="align-middle"><?= (date_fmt($upload->created_at) ?? "") ?> </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Vizualizar: </td>
                            <td class="align-middle">
                                <img class="img-fluid d-block m-auto" src="<?= url(CONF_UPLOAD_DIR . "/{$upload->url}") ?>" />
                                <div class="d-flex align-content-center justify-content-center">
                                    <a href="<?= url(CONF_UPLOAD_DIR . "/{$upload->url}") ?>" class="mt-0 btn-link btn-sm" target="_blank" title="Baixar"> <i class="fa-solid fa-magnifying-glass mr-1"></i> Ampliar</a>
                                </div>
                                <?php if (user()->level > 1) : ?>
                                    <div class="d-flex align-content-center justify-content-center">
                                        <a href="<?= url("/upload/update/{$upload->id}/accepted") ?>" class="mt-2 btn btn-success ml-1" title="Aceitar"> <i class="fa-solid fa-check mr-1"></i> Aceitar</a>
                                        <a href="<?= url("/upload/update/{$upload->id}/recuse") ?>" class="mt-2 btn bg-danger ml-3" title="Recusar"><i class="fa-solid fa-xmark mr-1"></i> Recusar</a>
                                        <a href="<?= url("/upload/update/{$upload->id}/paid") ?>" class="mt-2 btn bg-warning ml-3" title="Pagamento realizado"><i class="fa-solid fa-dollar-sign mr-1"></i> Pagamento Realizado</a>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </article>
            <footer class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>