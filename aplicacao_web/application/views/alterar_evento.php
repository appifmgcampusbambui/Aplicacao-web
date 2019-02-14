<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2>Alterar Evento</h2>
        </div>
    </div>
        
    <div class="row" style="padding: 2rem 1rem 1rem 1rem;">
        <div class="col-sm-12">
            <form method="POST" action="<?= base_url() ?>Evento/salvarAlteracao" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $evento[0]->id; ?>" >
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="txtNome">Nome:</label>
                            <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="Informe o nome" autofocus="true" required="true" maxlength="100" value="<?= $evento[0]->nome; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="txtDescricao">Descrição:</label>
                            <textarea class="form-control" id="txtDescricao" name="txtDescricao" placeholder="Informe a descrição" maxlength="500" rows="3"><?= $evento[0]->descricao; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="txtLocal">Local:</label>
                            <input type="text" class="form-control" id="txtLocal" name="txtLocal" placeholder="Informe o local" maxlength="100" value="<?= $evento[0]->local; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="txtDataInicial">Data inicial:</label>
                            <input type="date" class="form-control form-control-sm" id="txtDataInicial" name="txtDataInicial" placeholder="Informe a data inicial" required="true" min="2018-01-01" value="<?= $evento[0]->data_inicial; ?>"/>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="txtHoraInicial">Horário:</label>
                            <input type="time" class="form-control form-control-sm" id="txtHoraInicial" name="txtHoraInicial" required="true" value="<?= $evento[0]->hora_inicial; ?>"/>
                        </div>
                    </div>
                    <div class="col-sm-8"></div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="txtDataFinal">Data final:</label>
                            <input type="date" class="form-control form-control-sm" id="txtDataFinal" name="txtDataFinal" placeholder="Informe a data final" required="true" min="2018-01-01" value="<?= $evento[0]->data_final; ?>"/>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="txtHoraFinal">Horário:</label>
                            <input type="time" class="form-control form-control-sm" id="txtHoraFinal" name="txtHoraFinal" required="true" value="<?= $evento[0]->hora_final; ?>"/>
                        </div>
                    </div>
                    <div class="col-sm-8"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <!-- Verifica se existe algum arquivo anexado para o evento -->
                            <label for="txtAnexo">Arquivo anexo: 
                                <?php if ($evento[0]->arquivo_anexo != null) { ?>
                                    <a href="<?= base_url('uploads/anexos_eventos/'.$evento[0]->arquivo_anexo) ?>" target="_blank">[Clique aqui para acessar o anexo atual]</a>
                                <?php } ?>
                            </label>
                            <input type="file" name="txtAnexo" id="txtAnexo" class="form-control" accept="application/pdf, image/png, image/jpg, image/jpeg" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="cmbAtivo">Ativo:</label>
                            <select class="form-control form-control-sm" id="cmbAtivo" name="cmbAtivo" required>
                                <option value=""></option>
                                <option value="S" <?= $evento[0]->ativo == 'S' ? ' selected ' : '' ?>>Sim</option>
                                <option value="N" <?= $evento[0]->ativo == 'N' ? ' selected ' : '' ?>>Não</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-10"></div>
                </div>
                <div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="<?= base_url()?>Evento/listagem/0" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>