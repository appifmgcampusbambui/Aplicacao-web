<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2>Notícias</h2>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <a id="btnAdicionar" name="btnAdicionar" class="btn btn-outline-dark pull-left" href="<?= base_url() ?>Noticia/cadastro">Nova Notícia</a>
        </div>
    </div>
    
    <div class="row" style="padding: 2rem 1rem 1rem 1rem;">
        <table class="table table-striped table-bordered table-sm borda-tabela">
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 40%">Título</th>
                    <th style="width: 20%">Autor</th>
                    <th style="width: 14%">Publicação</th>
                    <th style="width: 5%">Views</th>
                    <th style="width: 5%">Status</th>                    
                    <th style="width: 7%" colspan="4" class="text-center">Operações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaNoticias as $noticia) { ?>
                <tr>
                    <td><?= $noticia->id; ?></td>
                    <td><?= $noticia->titulo; ?></td>
                    <td><?= $noticia->autor; ?></td>
                    <td><?= $noticia->data_hora_publicacao; ?></td>
                    <td><?= $noticia->qtd_visualizacoes; ?></td>
                    <td><?= $noticia->status; ?></td>
                    
                    <td><a href="<?= base_url('Noticia/alterar/'.$noticia->id) ?>" class="botao-grid-xs"><i title="Alterar" class="fa fa-pencil fa-fw"></i></a></td>
                    <td><a href="<?= base_url('Noticia/alterarStatus/'.$noticia->id) ?>" class="botao-grid-xs" onclick="return confirm('Confirma a alteração do status da Notícia?');"><i title="Mudar status" class="fa fa-tags"></i></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <nav>
            <ul class="pagination">
                <li class="page-item">
                  <a class="page-link link-black" href="<?= base_url('Noticia/listagem/' . ($posicao-($registrosPorPagina))) ?>" aria-label="Anterior" style='<?= $btnAnterior ?>'>
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>

                <?php 
                    $numPag = 1;
                    for ($i = 1; $i <= $quantidadeBotoes; $i++) { ?>
                        <li><a class="page-link link-black" href="<?= base_url('Noticia/listagem/' . ($numPag-1)) ?>"><?= $i ?></a></li>
                        <?php 
                        $numPag += $registrosPorPagina;
                    } ?>

                <li>
                  <a class="page-link link-black" href="<?= base_url('Noticia/listagem/' . ($posicao+($registrosPorPagina))) ?>" aria-label="Próximo" style='<?= $btnProximo ?>'>
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
            </ul>
        </nav>
    </div>
</div>