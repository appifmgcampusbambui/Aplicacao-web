<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function verificarSessao() {
        //A variável "userdata" guarda os valores da sessão de cada usuário em um vetor
        if ($this->session->userdata('appmeucampus_logado') == false) {
            redirect('Login');
        }
    }

    public function cadastro() {
        $this->verificarSessao();
        
        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');
        $this->load->view('cadastrar_noticia');
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_noticia');
        $this->load->view('includes/html_footer_final');
    }

    public function inserir() {
        $this->verificarSessao();

        $datahora = date('Y-m-d H:i:s');

        $dados['titulo'] = $this->input->post('titulo');
        $dados['texto'] = $this->input->post('texto');
        $dados['data_hora_publicacao'] = $datahora;
        $dados['usuario_publicacao'] = $this->session->userdata('appmeucampus_id');
        $dados['status'] = "A";

        $this->load->model('Noticia_model', 'noticia', true);
        if ($this->noticia->inserir($dados)) {
            redirect('Noticia/listagem/0/1');
        } else {
            redirect('Noticia/listagem/0/2');
        }
    }

    public function alterar($id = null) {
        $this->verificarSessao();

        //Busca os dados da notícia no Model
        $this->load->model('Noticia_model', 'noticia', true);
        $dados['noticia'] = $this->noticia->retornarNoticia($id);
        
        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');        
        $this->load->view('alterar_noticia', $dados);
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_noticia');
        $this->load->view('includes/html_footer_final');
    }

    public function salvarAlteracao() {
        $this->verificarSessao();

        $datahora = date('Y-m-d H:i:s');
        
        //Busca o id da notícia passado como parâmetro hidden
        $id = $this->input->post('id');

        $dados['titulo'] = $this->input->post('titulo');
        $dados['texto'] = $this->input->post('texto');
        $dados['data_hora_atualizacao'] = $datahora;
        $dados['usuario_atualizacao'] = $this->session->userdata('appmeucampus_id');
        
        $this->load->model('Noticia_model', 'noticia', true);
        if ($this->noticia->salvarAlteracao($id, $dados)) {
            redirect('Noticia/listagem/0/5');
        } else {
            redirect('Noticia/listagem/0/6');
        }
    }

    public function alterarStatus($id = null) {
        $this->verificarSessao();

        $this->load->model('Noticia_model', 'noticia', true);
        if ($this->noticia->alterarStatus($id)) {
            redirect('Noticia/listagem/0/5');
        } else {
            redirect('Noticia/listagem/0/6');
        }
    }
    
    public function wsRetornaNoticias() {
        $this->load->model('Noticia_model', 'noticia', true);
        
        //Devolve um json com os dados das Notícias
        echo json_encode($this->noticia->retornarNoticias(null, null, 'A'));
    }
    
    public function wsRetornaNoticiaEspecifica($id) {
        $this->load->model('Noticia_model', 'noticia', true);
        
        //Devolve um json com os dados da Notícia passada como parâmetro
        echo json_encode($this->noticia->retornarNoticia($id));
    }
    
    public function listagem($value = null, $indice = null) {
        $this->verificarSessao();
        
        if ($value == null) {
            $posicao = 0;
        } else {
            $posicao = $value;
        }

        $registrosPorPagina = 20;

        //Desativa o botão "Anterior"
        if ($posicao < $registrosPorPagina) {
            $dadosNoticias['btnAnterior'] = 'pointer-events:none'; //Não tem outra página antes da 1
        } else {
            $dadosNoticias['btnAnterior'] = '';
        }

        //Carrega o Model e busca o total de notícias cadastradas
        $this->load->model('Noticia_model', 'noticia', true);
        $total = $this->noticia->retornarQuantidadeDeNoticias();

        //Desativa o botão "Próximo"
        if (($total - $posicao) <= $registrosPorPagina) {
            $dadosNoticias['btnProximo'] = 'pointer-events:none'; //Não tem outra página depois da última
        } else {
            $dadosNoticias['btnProximo'] = '';
        }

        $dadosNoticias['posicao'] = $posicao;
        $dadosNoticias['registrosPorPagina'] = $registrosPorPagina;
        $dadosNoticias['totalRegistros'] = $total;

        //Calcula a quantidade de botões necessários
        $qtdInteiro = (int) $total / $registrosPorPagina;
        $qtdResto = $total % $registrosPorPagina;
        if ($qtdResto > 0) {
            $qtdInteiro += 1;
        }

        $dadosNoticias['quantidadeBotoes'] = $qtdInteiro;

        $dadosNoticias['listaNoticias'] = $this->noticia->retornarNoticias($posicao, $registrosPorPagina);
        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');

        if ($indice == 1) {
            $dados['msg'] = "Notícia cadastrada com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 2) {
            $dados['msg'] = "Ocorreu um erro ao cadastrar a Notícia.";
            $this->load->view('includes/msg_erro', $dados);
        } else if ($indice == 3) {
            $dados['msg'] = "Notícia excluída com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 4) {
            $dados['msg'] = "Ocorreu um erro ao excluir a Notícia.";
            $this->load->view('includes/msg_erro', $dados);
        } else if ($indice == 5) {
            $dados['msg'] = "Notícia alterada com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 6) {
            $dados['msg'] = "Ocorreu um erro ao alterar a Notícia.";
            $this->load->view('includes/msg_erro', $dados);
        }

        $this->load->view('listar_noticia', $dadosNoticias);
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_noticia');
        $this->load->view('includes/html_footer_final');      
    }

}