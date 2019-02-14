<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="<?= base_url() ?>">SGI - APP MEU CAMPUS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <?php if (isset($_SESSION['appmeucampus_tipo'])) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-item active" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cadastros</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <!--Habilita os menus de acordo com o tipo do usuário-->                        
                            <?php if (($_SESSION['appmeucampus_tipo'] == 'A') || ($_SESSION['appmeucampus_tipo'] == 'C')) { 
                                ?>
                                <a class="dropdown-item" href="<?= base_url() ?>Cardapio/listagem/0">Cardápio</a>
                            <?php }
        
                            if (($_SESSION['appmeucampus_tipo'] == 'A') || ($_SESSION['appmeucampus_tipo'] == 'R')) { 
                                ?>
                                <a class="dropdown-item" href="<?= base_url() ?>Evento/listagem/0">Eventos</a>
                                <a class="dropdown-item" href="<?= base_url() ?>Noticia/listagem/0">Notícias</a>
                            <?php } ?>
                    </div>
                </li>
                <?php if ($_SESSION['appmeucampus_tipo'] == 'A') { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-item active" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notificações</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown02">
                            <a class="dropdown-item" href="<?= base_url() ?>Notificacao/cadastro">Enviar</a>
                        </div>
                    </li>
                <?php } ?>
            <?php } ?>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="nav-item dropdown">
                <a id="mnUsuario" class="nav-link dropdown-toggle nav-item active" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if (isset($_SESSION['appmeucampus_nome'])) { 
                    echo "[" . $_SESSION['appmeucampus_id'] . "-" . $_SESSION['appmeucampus_nome'];
                    $id = $_SESSION['appmeucampus_id'] . "]";
                    } ?>]
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#" id="btnAlterarUsuario" name="<?php echo $_SESSION['appmeucampus_id']; ?>">Alterar Usuário</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalAlterarSenha" data-backdrop="static">Alterar senha</a>
                    <a class="dropdown-item" href="<?= base_url() ?>Principal/sair">Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<!-- Modal para alterar a senha do usuário -->
<div id="ModalAlterarSenha" class="modal fade" role="dialog" aria-labelledby="ModalAlterarSenhaTitle" aria-hidden="true">
    <div class="modal-dialog" role="dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="frmAlterarSenha">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="ModalAlterarSenhaTitle" name="ModalAlterarSenhaTitle">Alterar senha</h4>
            </div>
            <div class="modal-body">                
                <div class="form-group">
                    <div class="row ajuste-campos-forms">
                        <label class="control-label col-sm-3 col-form-label col-form-label-sm" for="txtSenhaAtual">Senha atual:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control form-control-sm" id="txtSenhaAtual" name="txtSenhaAtual" maxlength="20" required>
                        </div>
                    </div>
                    <div class="row ajuste-campos-forms">
                        <label class="control-label col-sm-3 col-form-label col-form-label-sm" for="txtNovaSenha">Nova senha:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control form-control-sm" id="txtNovaSenha" name="txtNovaSenha" maxlength="20" required>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btnAlterarSenha" name="btnAlterarSenha">Alterar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- Fim do Modal para alterar a senha -->

<!-- Modal para alterar os dados do usuário -->
<div id="ModalAlterarUsuario" class="modal fade" role="dialog" aria-labelledby="ModalAlterarUsuarioTitle" aria-hidden="true">
    <div class="modal-dialog" role="dialog">
        <div class="modal-content">
            <form class="form-horizontal" id="frmAlterarUsuario">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="ModalAlterarUsuarioTitle" name="ModalAlterarUsuarioTitle">Meus dados</h4>
            </div>
            <div class="modal-body">                
                <div class="form-group">
                    <div class="row ajuste-campos-forms">
                        <label class="control-label col-sm-3 col-form-label col-form-label-sm" for="txtNome">Nome:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="txtNome" name="txtNome" maxlength="60" required>
                        </div>
                    </div>
                    <div class="row ajuste-campos-forms">
                        <label class="control-label col-sm-3 col-form-label col-form-label-sm" for="txtLogin">Login:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" id="txtLogin" name="txtLogin" maxlength="10" pattern="[^\s]+"  title="O login não pode conter espaços em branco" required>
                        </div>
                    </div>
                    <div class="row ajuste-campos-forms">
                        <label class="control-label col-sm-3 col-form-label col-form-label-sm" for="txtEmail">E-mail:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control form-control-sm" id="txtEmail" name="txtEmail" maxlength="100" pattern="[^\s]+"  title="O e-mail não pode conter espaços em branco" required>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <input type="hidden" name="idUsuario" id="idUsuario" />
                <button type="submit" class="btn btn-success" id="btnAlterarUsuario" name="btnAlterarUsuario">Salvar alterações</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
            </form>
        </div>
    </div>
</div> <!-- Fim do Modal para alterar os dados do usuário -->