<?php

defined('BASEPATH') OR exit('Acesso negado.');

class Principal extends CI_Controller {

    public function verificarSessao() {
        //A variável "userdata" guarda os valores da sessão de cada usuário em um vetor
        if ($this->session->userdata('appmeucampus_logado') == false) {
            redirect('Login');
        }
    }
    
    public function index()	{
        $this->verificarSessao();

        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');
        $this->load->view('principal');
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_final');
    }
        
    public function sair() {
        if ($this->session->userdata('appmeucampus_logado') == true) {
            $this->session->sess_destroy();
            redirect('Login');
        }
    }
}