<section class="modal fade" id="modal_remove_<?= md5($anexo->id) ?>" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-danger text-while">
                <h5 class="modal-title">Deseja remover este registro?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <ul class="list-unstyled">
                    <li><b>Nome: </b> <?= ($anexo->description ?? "") ?>;</li>
                    <li><b>Usuario: </b> <?= ("{$anexo->user()->first_name} {$anexo->user()->last_name}" ?? "") ?>;</li>
                    <li><b>Data de cadastro: </b> <?= (date_fmt($anexo->created_at) ?? "") ?>;</li>
                    <li><b>Data de última alteração: </b> <?= !empty($anexo->updated_at) ? date_fmt($anexo->updated_at) : "" ?>.</li>
                </ul>
                <p class="text-justify text-danger"><span class="font-bold">OBS : </span> Ao clicar em "Excluir", este registro e todos registos relacionados ao mesmo deixaram de existir no sistema.</p>
            </article>
            <footer class="modal-footer">
                <a class="btn btn-danger pull-left" href="<?= url("publicity/anexo/remove/{$anexo->id}") ?>"> <i class="fa fa-trash"></i> Excluir</a>
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>