<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2>Eventos</h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <a id="btnAdicionar" name="btnAdicionar" class="btn btn-outline-dark pull-left" href="<?= base_url() ?>Evento/cadastro">Novo Evento</a>
        </div>
    </div>
    
    <div class="row" style="padding: 2rem 1rem 1rem 1rem;">
        <table class="table table-striped table-bordered table-sm borda-tabela">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 52%">Nome</th>
                    <th style="width: 15%">Início</th>
                    <th style="width: 15%">Término</th>
                    <th style="width: 5%; text-align: center;">Ativo</th>
                    <th style="width: 8%" colspan="4" class="text-center">Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaEvento as $evento) { ?>
                <tr>
                    <td><?= $evento->id; ?></td>
                    <td><?= $evento->nome; ?></td>
                    <td><?= $evento->data_inicial; ?></td>
                    <td><?= $evento->data_final; ?></td>
                    <td style="text-align: center;"><?= $evento->ativo; ?></td>
                    
                    <td><a href="<?= base_url('Evento/alterar/'.$evento->id) ?>" class="botao-grid-xs"><i title="Alterar" class="fa fa-pencil fa-fw"></i></a></td>
                    <td><a href="<?= base_url('Evento/excluir/'.$evento->id) ?>" class="botao-grid-xs" onclick="return confirm('Confirma a exclusão do Evento?');"><i title="Excluir" class="fa fa-trash"></i></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <nav>
            <ul class="pagination">
                <li class="page-item">
                  <a class="page-link link-black" href="<?= base_url('Evento/listagem/' . ($posicao-($registrosPorPagina))) ?>" aria-label="Anterior" style='<?= $btnAnterior ?>'>
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>

                <?php 
                    $numPag = 1;
                    for ($i = 1; $i <= $quantidadeBotoes; $i++) { ?>
                        <li><a class="page-link link-black" href="<?= base_url('Evento/listagem/' . ($numPag-1)) ?>"><?= $i ?></a></li>
                        <?php 
                        $numPag += $registrosPorPagina;
                    } ?>

                <li>
                  <a class="page-link link-black" href="<?= base_url('Evento/listagem/' . ($posicao+($registrosPorPagina))) ?>" aria-label="Próximo" style='<?= $btnProximo ?>'>
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
            </ul>
        </nav>
    </div>
</div>