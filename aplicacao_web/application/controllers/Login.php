<?php
defined('BASEPATH') OR exit('Acesso negado.');

class Login extends CI_Controller {

    public function verificarSessao() {
        //A variável "userdata" guarda os valores da sessão de cada usuário em um vetor
        if ($this->session->userdata('appmeucampus_logado') == false) {
            redirect('Login');
        }
    }
    
    public function acessa($indice = null, $tentativasRestantes = null) {
        //$this->verificarSessao();
        
        $this->load->view('includes/html_header');
        
        if ($indice == 1) {
            $dados['msg'] = "Login incorreto ou usuário inativo.";
            $this->load->view('includes/msg_erro_login', $dados);
        } else if ($indice == 2) {
            $dados['msg'] = "Senha incorreta. Tentativas restantes: " . $tentativasRestantes;
            $this->load->view('includes/msg_erro_login', $dados);
        } else if ($indice == 3) {
            $dados['msg'] = "Seu usuário foi bloqueado pelo excesso de tentativas. Entre em contato com o administrador do sistema.";
            $this->load->view('includes/msg_erro_login', $dados);
        }
        
        $this->load->view('login');
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_login');
        $this->load->view('includes/html_footer_final');
    }
    
    public function index($indice = null) {
        $this->acessa();
	}
    
    public function entrar() {
        //Busca o login e a senha informados pelo usuário
        $login = $this->input->post('login');
        $senha = $this->input->post('senha');
        
        //Executa uma consulta no banco pesquisando usuários ativos por login
        $this->db->where('login', $login);
        $this->db->where('status', 'A');
        $dados['usuario'] = $this->db->get('usuario')->result();
        
        //Verifica se encontrou algum usuário
        if (count($dados['usuario']) != 1) { //Usuário inexistente
            redirect('Login/acessa/1'); 
        } else {
            //Verifica a quantidade de tentativas restantes
            $this->load->model('Usuario_model', 'usuario', true);
            $tentativasRestantes = $this->usuario->retornarTentativasRestantes($dados['usuario'][0]->id);
            if ($tentativasRestantes == 1) {
                //Inativa o usuário e volta para a tela inicial                
                $this->usuario->inativar($dados['usuario'][0]->id);
                redirect('Login/acessa/3');
            } else {
                if (password_verify($senha, $dados['usuario'][0]->senha)) {
                    //salva na sessão o nome, o id e a indicação de logado
                    $dadosParaSessao['appmeucampus_id'] = $dados['usuario'][0]->id;
                    $dadosParaSessao['appmeucampus_nome'] = $dados['usuario'][0]->nome;
                    $dadosParaSessao['appmeucampus_tipo'] = $dados['usuario'][0]->tipo;
                    $dadosParaSessao['appmeucampus_logado'] = true;
                    $this->session->set_userdata($dadosParaSessao);

                    //Atualiza a data do último login do usuário
                    $this->usuario->alterarUltimoLogin($dados['usuario'][0]->id);

                    //Registra o histórico de logins
                    $dadosHistorico['id_usuario'] = $dados['usuario'][0]->id;
                    $dadosHistorico['endereco_ip'] = $this->input->ip_address();
                    $dadosHistorico['data'] = date('Y-m-d H:i:s');
                    $this->usuario->registrarHistoricoLogin($dadosHistorico);

                    //Zera a quantidade de tentativas de login do usuário
                    $this->usuario->zerarTentativasLogin($dados['usuario'][0]->id);

                    //Redireciona para a página inicial
                    redirect('Principal');
                } else { //Senha inválida
                    //Altera a quantidade de tentativas do login informado
                    $this->usuario->incrementarTentativasLogin($dados['usuario'][0]->id);

                    //Verifica a quantidade de tentativas restantes
                    $tentativasRestantes = $this->usuario->retornarTentativasRestantes($dados['usuario'][0]->id);

                    redirect('Login/acessa/2/' . $tentativasRestantes);
                }
            }
        }
    }
}