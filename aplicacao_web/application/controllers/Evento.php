<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Evento extends CI_Controller {

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
        $this->load->view('cadastrar_evento');
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_final');
    }

    public function inserir() {
        $this->verificarSessao();

        $dados['nome'] = $this->input->post('txtNome');
        $dados['descricao'] = $this->input->post('txtDescricao');
        $dados['data_inicial'] = $this->input->post('txtDataInicial');
        $dados['hora_inicial'] = $this->input->post('txtHoraInicial');
        $dados['data_final'] = $this->input->post('txtDataFinal');        
        $dados['hora_final'] = $this->input->post('txtHoraFinal');
        $dados['local'] = $this->input->post('txtLocal');
        $dados['ativo'] = $this->input->post('cmbAtivo');
        $dados['data_inclusao'] = date('Y-m-d H:i:s');
        $dados['usuario_inclusao'] = $this->session->userdata('appmeucampus_id');
        
        //Verifica se anexou algum arquivo
        if ($_FILES['txtAnexo'] != null && $_FILES['txtAnexo']['name'] !== '') {
            //Gera um nome aleatório para o arquivo (número aleatório concatenado com a data e a hora atual)
            $nome_arquivo_original = $_FILES['txtAnexo']['name'];
            $extensao = pathinfo($nome_arquivo_original, PATHINFO_EXTENSION);
            $nome_arquivo_novo = mt_rand() . '_' . date('Ymd_His');
            $dados['arquivo_anexo'] = $nome_arquivo_novo . '.' . $extensao;
            
            //Armazena o arquivo no servidor
            $config['upload_path'] = './uploads/anexos_eventos/';
            $config['allowed_types'] = 'pdf|jpeg|jpg|png';
            $config['max_size'] = 10000;
            $config['file_name'] = $nome_arquivo_novo . '.' . $extensao;
            $this->load->library('upload', $config);
            $this->upload->do_upload('txtAnexo');
        }

        $this->load->model('Evento_model', 'evento', true);
        if ($this->evento->inserir($dados)) {
            redirect('Evento/listagem/0/1');
        } else {
            redirect('Evento/listagem/0/2');
        }
    }

    public function alterar($id = null) {
        $this->verificarSessao();

        //Busca os dados do Evento no Model
        $this->load->model('Evento_model', 'evento', true);
        $dados['evento'] = $this->evento->retornarEvento($id);
        
        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');        
        $this->load->view('alterar_evento', $dados);
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_final');
    }

    public function salvarAlteracao() {
        $this->verificarSessao();

        //Busca o id do Evento passado como parâmetro hidden
        $id = $this->input->post('id');
        
        $dados['nome'] = $this->input->post('txtNome');
        $dados['descricao'] = $this->input->post('txtDescricao');
        $dados['local'] = $this->input->post('txtLocal');
        $dados['data_inicial'] = $this->input->post('txtDataInicial');
        $dados['hora_inicial'] = $this->input->post('txtHoraInicial');
        $dados['data_final'] = $this->input->post('txtDataFinal');        
        $dados['hora_final'] = $this->input->post('txtHoraFinal');
        $dados['ativo'] = $this->input->post('cmbAtivo');
        $dados['data_ult_atualizacao'] = date('Y-m-d H:i:s');
        $dados['usuario_ult_atualizacao'] = $this->session->userdata('appmeucampus_id');
        
        //Verifica se anexou algum arquivo
        if ($_FILES['txtAnexo'] != null && $_FILES['txtAnexo']['name'] !== '') {
            //Gera um nome aleatório para o arquivo (número aleatório concatenado com a data e a hora atual)
            $nome_arquivo_original = $_FILES['txtAnexo']['name'];
            $extensao = pathinfo($nome_arquivo_original, PATHINFO_EXTENSION);
            $nome_arquivo_novo = mt_rand() . '_' . date('Ymd_His');
            $dados['arquivo_anexo'] = $nome_arquivo_novo . '.' . $extensao;
            
            //Armazena o arquivo no servidor
            $config['upload_path'] = './uploads/anexos_eventos/';
            $config['allowed_types'] = 'pdf|jpeg|jpg|png';
            $config['max_size'] = 10000;
            $config['file_name'] = $nome_arquivo_novo . '.' . $extensao;
            $this->load->library('upload', $config);
            $this->upload->do_upload('txtAnexo');
        }
        
        $this->load->model('Evento_model', 'evento', true);
        if ($this->evento->salvarAlteracao($id, $dados)) {
            redirect('Evento/listagem/0/5');
        } else {
            redirect('Evento/listagem/0/6');
        }
    }

    public function excluir($id = null) {
        $this->verificarSessao();

        $this->load->model('Evento_model', 'evento', true);
        if ($this->evento->excluir($id)) {
            redirect('Evento/listagem/0/3');
        } else {
            redirect('Evento/listagem/0/4');
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
            $dadosEvento['btnAnterior'] = 'pointer-events:none'; //Não tem outra página antes da 1
        } else {
            $dadosEvento['btnAnterior'] = '';
        }

        //Carrega o Model e busca o total de eventos cadastrados
        $this->load->model('Evento_model', 'evento', true);
        $total = $this->evento->retornarQuantidadeDeEventos();

        //Desativa o botão "Próximo"
        if (($total - $posicao) <= $registrosPorPagina) {
            $dadosEvento['btnProximo'] = 'pointer-events:none'; //Não tem outra página depois da última
        } else {
            $dadosEvento['btnProximo'] = '';
        }

        $dadosEvento['posicao'] = $posicao;
        $dadosEvento['registrosPorPagina'] = $registrosPorPagina;
        $dadosEvento['totalRegistros'] = $total;

        //Calcula a quantidade de botões necessários
        $qtdInteiro = (int) $total / $registrosPorPagina;
        $qtdResto = $total % $registrosPorPagina;
        if ($qtdResto > 0) {
            $qtdInteiro += 1;
        }

        $dadosEvento['quantidadeBotoes'] = $qtdInteiro;

        $dadosEvento['listaEvento'] = $this->evento->retornarEventos($posicao, $registrosPorPagina);
        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');

        if ($indice == 1) {
            $dados['msg'] = "Evento cadastrado com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 2) {
            $dados['msg'] = "Ocorreu um erro ao cadastrar o Evento.";
            $this->load->view('includes/msg_erro', $dados);
        } else if ($indice == 3) {
            $dados['msg'] = "Evento excluído com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 4) {
            $dados['msg'] = "Ocorreu um erro ao excluir o Evento.";
            $this->load->view('includes/msg_erro', $dados);
        } else if ($indice == 5) {
            $dados['msg'] = "Evento alterado com sucesso.";
            $this->load->view('includes/msg_sucesso', $dados);
        } else if ($indice == 6) {
            $dados['msg'] = "Ocorreu um erro ao alterar o Evento.";
            $this->load->view('includes/msg_erro', $dados);
        }

        $this->load->view('listar_evento', $dadosEvento);
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_final');      
    }
}