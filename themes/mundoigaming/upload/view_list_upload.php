<section class="modal fade" id="modal_view_<?= md5($user->id) ?>" tabindex="-1" role="dialog">
    <article class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
                            <td class="align-middle bg-secondary">Usuário: </td>
                            <td class="align-middle"> <?= ("{$user->first_name} {$user->last_name}" ?? "") ?> </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">Cadastro: </td>
                            <td class="align-middle"><?= (date_fmt($user->created_at) ?? "") ?> </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-secondary">T. de registros: </td>
                            <td class="align-middle">
                                <?php $status = $user->upload_by_status(); ?>
                                <span class="p-1 rounded bg-primary"><?= ($status->waiting ?? "") ?> Aguardando visualização</span>
                                <span class="p-1 rounded bg-success"><?= ($status->accepted ?? "") ?> Aceito</span>
                                <span class="p-1 rounded bg-danger"><?= ($status->recuse ?? "") ?> Recusado</span>
                                <span class="p-1 rounded bg-warning"><?= ($status->paid ?? "") ?> Pagamento realizado</span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-responsive">
                    <!--table-->
                    <table class="table table-striped table-bordered table-sm table-hover mb-0">
                        <thead class="bg-secondary">
                            <tr class="">
                                <th scope="col" class="align-middle" width="50px">#</th>
                                <th scope="col" class="align-middle">Descrição</th>
                                <th scope="col" class="align-middle">Data</th>
                                <th scope="col" class="align-middle">Status</th>
                                <th scope="col" class="align-middle" width="100px">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $uploads = $user->upload();
                            if (isset($uploads)) :
                                $qtd = 1;
                                foreach ($uploads as $upload) :
                            ?>
                                    <tr>
                                        <td class="text-center align-middle"><?php echo $qtd ?></td>
                                        <td class="align-middle"><?= ($upload->description ?? "") ?></td>
                                        <td class="align-middle"><?= (date_fmt($upload->created_at) ?? "") ?></td>
                                        <td class="align-middle"><span class="p-1 rounded <?= ($upload->status()->class_color ?? "") ?>"><?= ($upload->status()->name ?? "") ?></span></td>
                                        <td class="align-middle table-acao text-center">
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_view_<?= (md5($upload->id) ?? "") ?>" title="Visualizar"><i class="fa fa-eye"></i></button>
                                            <?php if (user()->level > 1  || $upload->status == 1) : ?>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_remove_<?= (md5($upload->id) ?? "") ?>" title="Excluir"><i class="fa fa-trash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                            <?php
                                    $qtd++;
                                endforeach;
                            else :
                                echo "<tr><td colspan='5'>Nenhum registro encontrado! </td></tr>";
                            endif;
                            ?>
                        </tbody>
                    </table>
                    <!--table-->
                </div>
            </article>
            <footer class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
            </footer>
        </section>
    </article>
</section>

<!-- modal para visualizar -->
<?php
if (isset($uploads) && is_array($uploads)) :
    foreach ($uploads as $upload) :
        $this->insert("upload/view", ["upload" => $upload]);
    endforeach;
endif;
?>
<!-- fim modal para visualizar -->

<?php
if (isset($uploads) && is_array($uploads)) :
    foreach ($uploads as $upload) :
        if (user()->level > 1  || $upload->status == 1) :
            $this->insert("upload/remove", ["upload" => $upload]);
        endif;
    endforeach;
endif;
?>