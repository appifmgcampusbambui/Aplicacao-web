<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cardapio extends CI_Controller {

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
        $this->load->view('cadastrar_cardapio');
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_final');
    }

    public function inserir() {
        $this->verificarSessao();

        $datahora = date('Y-m-d H:i:s');

        $dados['data'] = $this->input->post('txtData');
        $dados['tipo_refeicao'] = $this->input->post('cmbTipoRefeicao');
        $dados['descricao'] = $this->input->post('txtDescricao');
        $dados['data_inclusao'] = $datahora;
        $dados['usuario_inclusao'] = $this->session->userdata('appmeucampus_id');

        $this->load->model('Cardapio_model', 'cardapio', true);
        if ($this->cardapio->inserir($dados)) {
            redirect('Cardapio/listagem/0/1');
        } else {
            redirect('Cardapio/listagem/0/2');
        }
    }

    public function alterar($id = null) {
        $this->verificarSessao();

        //Busca os dados do Cardápio no Model
        $this->load->model('Cardapio_model', 'cardapio', true);
        $dados['cardapio'] = $this->cardapio->retornarCardapio($id);
        
        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');        
        $this->load->view('alterar_cardapio', $dados);
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_final');
    }

    public function salvarAlteracao() {
        $this->verificarSessao();

        $datahora = date('Y-m-d H:i:s');
        
        //Busca o id d Cardápio passado como parâmetro hidden
        $id = $this->input->post('id');
        
        $dados['data'] = $this->input->post('txtData');
        $dados['tipo_refeicao'] = $this->input->post('cmbTipoRefeicao');
        $dados['descricao'] = $this->input->post('txtDescricao');
        $dados['data_ult_atualizacao'] = $datahora;
        $dados['usuario_ult_atualizacao'] = $this->session->userdata('appmeucampus_id');
        
        $this->load->model('Cardapio_model', 'cardapio', true);
        if ($this->cardapio->salvarAlteracao($id, $dados)) {
            redirect('Cardapio/listagem/0/5');
        } else {
            redirect('Cardapio/listagem/0/6');
        }
    }

    public function excluir($id = null) {
        $this->verificarSessao();

        $this->load->model('Cardapio_model', 'cardapio', true);
        if ($this->cardapio->excluir($id)) {
            redirect('Cardapio/listagem/0/3');
        } else {
            redirect('Cardapio/listagem/0/4');
        }
    }
    
    public function listagem($value = null, $indice = null) {
        $this->verificarSessao();
        
        if ($value == null) {
            $posicao = 0;
        } else {
            $posicao = $value;
        }

        $registrosPorPagina = 40;

        //Desativa o botão "Anterior"
        if ($posicao < $registrosPorPagina) {
            $dadosCardapio['btnAnterior'] = 'pointer-events:none'; //Não tem outra página antes da 1
        } else {
            $dadosCardapio['btnAnterior'] = '';
        }

        //Carrega o Model e busca o total de carcápios cadastrados
        $this->load->model('Cardapio_model', 'cardapio', true);
        $total = $this->cardapio->retornarQuantidadeDeCardapios();

        //Desativa o botão "Próximo"
        if (($total - $posicao) <= $registrosPorPagina) {
            $dadosCardapio['btnProximo'] = 'pointer-events:none'; //Não tem outra página depois da última
        } else {
            $dadosCardapio['btnProximo'] = '';
        }

        $dadosCardapio['posicao'] = $posicao;
        $dadosCardapio['registrosPorPagina'] = $registrosPorPagina;
        $dadosCardapio['totalRegistros'] = $total;

        //Calcula a quantidade de botões necessários
        $qtdInteiro = (int) $total / $registrosPorPagina;
        $qtdResto = $total % $registrosPorPagina;
        if ($qtdResto > 0) {
            $qtdInteiro += 1;
        }

        $dadosCardapio['quantidadeBotoes'] = $qtdInteiro;

        $dadosCardapio['listaCardapio'] = $this->cardapio->retornarCardapios($posicao, $registrosPorPagina);
        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');

        if ($indice == 1) {
            $dados['msg'] = "Cardápio cadastrado com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 2) {
            $dados['msg'] = "Ocorreu um erro ao cadastrar o Cardápio.";
            $this->load->view('includes/msg_erro', $dados);
        } else if ($indice == 3) {
            $dados['msg'] = "Cardápio excluído com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 4) {
            $dados['msg'] = "Ocorreu um erro ao excluir o Cardápio.";
            $this->load->view('includes/msg_erro', $dados);
        } else if ($indice == 5) {
            $dados['msg'] = "Cardápio alterado com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 6) {
            $dados['msg'] = "Ocorreu um erro ao alterar o Cardápio.";
            $this->load->view('includes/msg_erro', $dados);
        }

        $this->load->view('listar_cardapio', $dadosCardapio);
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_final');      
    }
}