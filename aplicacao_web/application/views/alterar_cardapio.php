<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2>Alterar Cardápio</h2>
        </div>
    </div>
        
    <div class="row" style="padding: 2rem 1rem 1rem 1rem;">
        <div class="col-sm-12">
            <form method="POST" action="<?= base_url() ?>Cardapio/salvarAlteracao" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $cardapio[0]->id; ?>" >
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="txtData">Data:</label>
                            <input type="date" class="form-control form-control-sm" id="txtData" name="txtData" placeholder="Informe a Data" autofocus="true" required="true" min="2017-10-01" value="<?= $cardapio[0]->data; ?>"/>
                        </div>
                    </div>
                    <div class="col-sm-9"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="cmbTipoRefeicao">Tipo:</label>
                            <select class="form-control form-control-sm" id="cmbTipoRefeicao" name="cmbTipoRefeicao" required value="<?= $cardapio[0]->tipo_refeicao; ?>">
                                <option value="A" <?= $cardapio[0]->tipo_refeicao == "A" ? 'selected' : '' ?>   >Almoço</option>
                                <option value="J" <?= $cardapio[0]->tipo_refeicao == "J" ? 'selected' : '' ?>   >Jantar</option>
                            </select>
                        </div>
                        <div class="col-sm-9"></div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="txtDescricao">Descrição <span style="color: red;"> (separar os itens com vírgula e sem espaço após ela)</span>:</label>
                            <input type="text" class="form-control form-control-sm" id="txtDescricao" name="txtDescricao" maxlength="300" value="<?= $cardapio[0]->descricao; ?>">
                        </div>
                    </div>
                </div>                
                <div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="<?= base_url()?>Cardapio/listagem/0" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>