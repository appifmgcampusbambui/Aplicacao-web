<div class="container container-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title"><strong>Acesso ao sistema</strong></h3></div>
            <div class="card-body">
                <form role="form" method="POST" action="<?= base_url() ?>Login/entrar">
                    <div class="form-group">
                        <label for="login">Login</label>
                        <input type="text" class="form-control" id="login" name="login" maxlength="10" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" maxlength="20" required value="">
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-default">Entrar</button>
                    </div>
                    <div style="padding-top: 10px;">
                        <a data-toggle="modal" data-target="#ModalNovaSenha" data-backdrop="static" style="cursor: pointer;">Esqueceu a senha?</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para gerar nova senha -->
<div id="ModalNovaSenha" class="modal fade" role="dialog" aria-labelledby="ModalNovaSenhaTitle" aria-hidden="true">
    <div class="modal-dialog" role="dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="frmNovaSenha">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="ModalNovaSenhaTitle" name="ModalNovaSenhaTitle">Gerar nova senha</h4>
            </div>
            <div class="modal-body">
                <label>Por favor, informe os dados solicitados abaixo.<br>Caso eles estejam corretos, você receberá uma nova senha no e-mail cadastrado.</label><br>
                <div class="form-group">
                    <div class="row ajuste-campos-forms">
                        <label class="control-label col-sm-3 col-form-label col-form-label-sm" for="txtLoginNovaSenha">Login:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="txtLoginNovaSenha" name="txtLoginNovaSenha" maxlength="10" pattern="[^\s]+"  title="O login não pode conter espaços em branco" required>
                        </div>
                    </div>
                    <div class="row ajuste-campos-forms">
                        <label class="control-label col-sm-3 col-form-label col-form-label-sm" for="txtEmailNovaSenha">E-mail:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control form-control-sm" id="txtEmailNovaSenha" name="txtEmailNovaSenha" maxlength="100" pattern="[^\s]+"  title="O e-mail não pode conter espaços em branco" required>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btnNovaSenha" name="btnNovaSenha">Solicitar nova senha</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnCancelarNovaSenha" name="btnCancelarNovaSenha">Cancelar</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- Fim do Modal para gerar nova senha -->