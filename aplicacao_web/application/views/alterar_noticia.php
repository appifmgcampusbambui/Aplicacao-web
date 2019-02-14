<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2>Alterar Notícia</h2>
        </div>
    </div>
        
    <div class="row" style="padding: 2rem 1rem 1rem 1rem;">
        <div class="col-sm-12">
            <form method="POST" action="<?= base_url() ?>Noticia/salvarAlteracao" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $noticia[0]->id; ?>" >
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Informe o título" autofocus="true" required="true" maxlength="250" value="<?= $noticia[0]->titulo; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="texto">Texto:</label>
                            <textarea id="texto_noticia" name="texto"><?= $noticia[0]->texto; ?></textarea>
                        </div>
                    </div>
                </div>                
                <div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="<?= base_url()?>Noticia/listagem/0" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>