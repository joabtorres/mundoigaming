<section class="modal fade" id="modal_view_<?= md5($status->id) ?>" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <section class="modal-content">
            <header class="modal-header bg-default">
                <h5 class="modal-title"><i class="fa-solid fa-swatchbook"></i> Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </header>
            <article class="modal-body">
                <ul class="list-unstyled">
                    <li><b>Status: </b> <span class="p-1 rounded <?= ($status->class_color ?? "bg-dark") ?>"><?= ($status->name ?? "") ?></span>;</li>
                    <li><b>Empresa: </b> <?= ($status->company()->full_name ?? "") ?>;</li>
                    <li><b>Data de cadastro: </b> <?= (date_fmt($status->created_at) ?? "") ?>;</li>
                    <li><b>Data de última alteração: </b> <?= !empty($status->updated_at) ? date_fmt($status->updated_at) : "" ?>.</li>
                </ul>
            </article>
            <footer class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>