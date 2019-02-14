<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <h2>Nova Notificação</h2>
        </div>
    </div>
        
    <div class="row" style="padding: 2rem 1rem 1rem 1rem;">
        <div class="col-sm-12">
            <form method="POST" action="<?= base_url() ?>Notificacao/enviar" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="txtTitulo">Título:</label>
                            <input type="text" class="form-control" id="txtTitulo" name="txtTitulo" placeholder="Informe o título" autofocus="true" maxlength="50" required/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="txtMensagem">Mensagem:</label>
                            <textarea class="form-control" id="txtMensagem" name="txtMensagem" placeholder="Informe a mensagem" maxlength="300" required></textarea>
                        </div>
                    </div>
                </div>                
                <div>
                    <button type="submit" class="btn btn-success">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>