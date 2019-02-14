<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2>Cardápio do Restaurante</h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <a id="btnAdicionar" name="btnAdicionar" class="btn btn-outline-dark pull-left" href="<?= base_url() ?>Cardapio/cadastro">Novo Cardápio</a>
        </div>
    </div>
    
    <div class="row" style="padding: 2rem 1rem 1rem 1rem;">
        <table class="table table-striped table-bordered table-sm borda-tabela">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 10%">Data</th>
                    <th style="width: 7%">Tipo</th>
                    <th style="width: 70%">Descrição</th>
                    <th style="width: 8%" colspan="4" class="text-center">Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaCardapio as $cardapio) { ?>
                <tr>
                    <td><?= $cardapio->id; ?></td>
                    <td><?= $cardapio->data; ?></td>
                    <td><?= $cardapio->tipo_refeicao == 'A' ? ' Almoço' : 'Jantar'; ?></td>
                    <td><?= $cardapio->descricao; ?></td>
                    
                    <td><a href="<?= base_url('Cardapio/alterar/'.$cardapio->id) ?>" class="botao-grid-xs"><i title="Alterar" class="fa fa-pencil fa-fw"></i></a></td>
                    <td><a href="<?= base_url('Cardapio/excluir/'.$cardapio->id) ?>" class="botao-grid-xs" onclick="return confirm('Confirma a exclusão do Cardápio?');"><i title="Excluir" class="fa fa-trash"></i></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <nav>
            <ul class="pagination">
                <li class="page-item">
                  <a class="page-link link-black" href="<?= base_url('Cardapio/listagem/' . ($posicao-($registrosPorPagina))) ?>" aria-label="Anterior" style='<?= $btnAnterior ?>'>
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>

                <?php 
                    $numPag = 1;
                    for ($i = 1; $i <= $quantidadeBotoes; $i++) { ?>
                        <li><a class="page-link link-black" href="<?= base_url('Cardapio/listagem/' . ($numPag-1)) ?>"><?= $i ?></a></li>
                        <?php 
                        $numPag += $registrosPorPagina;
                    } ?>

                <li>
                  <a class="page-link link-black" href="<?= base_url('Cardapio/listagem/' . ($posicao+($registrosPorPagina))) ?>" aria-label="Próximo" style='<?= $btnProximo ?>'>
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
            </ul>
        </nav>
    </div>
</div>