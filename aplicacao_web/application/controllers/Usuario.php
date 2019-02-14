<?php

defined('BASEPATH') OR exit('Acesso negado.');

class Usuario extends CI_Controller {

    public function verificarSessao() {
        //A variável "userdata" guarda os valores da sessão de cada usuário em um vetor
        if ($this->session->userdata('appmeucampus_logado') == false) {
            redirect('Login');
        }
    }

    public function retornarUsuario() {
        $this->verificarSessao();
        
        if ($this->input->post('idUsuario') !== null) {
            //Busca os dados do Usuario no Model
            $this->load->model('Usuario_model', 'usuario', true);            
            
            //Devolve um json com os dados do Usuario
            echo json_encode($this->usuario->retornarUsuario($this->input->post('idUsuario')));
        }
    }
    
    public function alterarSenha() {
        $this->verificarSessao();

        //Busca as senhas informadas pelo usuário
        $senhaAtual = $this->input->post('txtSenhaAtual');
        $novaSenha = $this->input->post('txtNovaSenha');
        $idUsuario = $this->session->userdata('appmeucampus_id');

        //Executa uma consulta no banco pesquisando usuários ativos por login
        $this->db->where('id', $idUsuario);
        $dados['usuario'] = $this->db->get('usuario')->result();
        
        //Verifica se encontrou algum usuário. Se encontrou, verifica se a senha atual está correta
        if ((count($dados['usuario']) == 1) && (password_verify($senhaAtual, $dados['usuario'][0]->senha))) {
            //Converte a nova senha informada
            $novaSenhaConvertida = password_hash($novaSenha, PASSWORD_DEFAULT);
            
            //Atualiza a senha do usuário
            $this->load->model('Usuario_model', 'usuario', true);
            $this->usuario->alterarSenha($idUsuario, $novaSenhaConvertida);

            //Informa que a senha foi alterada com sucesso
            $data['status'] = true;
        } else {
            //informando que a senha atual informada está errada
            $data['status'] = false;
        }

        echo json_encode($data);
    }

    public function alterar() {
        $this->verificarSessao();

        $this->load->helper('date');
        $datahora = date('Y-m-d H:i:s');
        
        $idUsuario = $this->session->userdata('appmeucampus_id');
        
        //Busca os dados preenchidos pelo usuário
        $dados['nome'] = $this->input->post('txtNome');
        $dados['login'] = $this->input->post('txtLogin');
        $dados['email'] = $this->input->post('txtEmail');
        $dados['data_ult_atualizacao'] = $datahora;
        $dados['usuario_ult_atualizacao'] = $idUsuario;  
        
        //Carrega o Model do Usuário
        $this->load->model('Usuario_model', 'usuario', true);
        
        //Atualiza o registro
        $resultado = $this->usuario->salvarAlteracao($idUsuario, $dados);
                
        if ($resultado) {
            //Altera o nome do Usuário na session
            $dadosParaSessao['appmeucampus_nome'] = $dados['nome'];
            $this->session->set_userdata($dadosParaSessao);

            echo json_encode(array('status'=>true, 'nomeUsuario'=>'[' . $idUsuario . '-' . $dados['nome'] . '] '));
        } else {
            echo json_encode(array('status'=>false));
        }
    }

    public function novaSenha() {
        //Busca os dados preenchidos pelo usuário
        $login = $this->input->post('txtLoginNovaSenha');
        $email = $this->input->post('txtEmailNovaSenha');

        //Carrega o Model do Usuário
        $this->load->model('Usuario_model', 'usuario', true);

        //Verifica se existe na base de dados algum usuário com o login e e-mail informados
        $dados['usuario'] = $this->usuario->retornarUsuarioPorLoginEmail($login, $email);

        if (count($dados['usuario']) == 1) {
            //Gera nova senha e a criptografa
            $this->load->helper('string');
            $novaSenha = random_string('alnum', 10);
            $novaSenhaConvertida = password_hash($novaSenha, PASSWORD_DEFAULT);

            //Grava a nova senha no BD
            $this->usuario->alterarSenha($dados['usuario'][0]->id, $novaSenhaConvertida);

            //Envia o e-mail para o solicitante
            $this->load->helper('email');
            $mensagem = '<html><head></head><body><h2>ATENÇÃO - Mensagem enviada pelo Sistema Integrado de Seleção da Assistência Estudantil do IFMG</h2><br><h3>Sua senha de acesso foi alterada para:</h3><p style="font-style: italic;">' . $novaSenha . '</p><br><br><p>Caso você não tenha feito esta solicitação, entre em contato com o setor de Assistência Estudantil do IFMG.</p><br></body></html>';
            enviar($email, 'Alteração de senha no SISAE/IFMG', $mensagem);

            echo json_encode(array('status'=>true));
        } else {
            //Não encontrou o usuário pelos dados informados
            echo json_encode(array('status'=>false));
        }
    }
}