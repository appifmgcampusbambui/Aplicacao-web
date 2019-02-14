<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacao extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function verificarSessao() {
        if ($this->session->userdata('appmeucampus_logado') == false) {
            redirect('Login');
        }
    }

    public function cadastro($msg = null) {
        $this->verificarSessao();
        
        $this->load->view('includes/html_header');
        $this->load->view('includes/html_menu');

        if ($msg != null) {
            $this->load->view('includes/msg_notificacao', $msg);
        }

        $this->load->view('notificacao');
        $this->load->view('includes/html_footer');
        $this->load->view('includes/html_footer_final');
    }

    public function enviar() {
        $this->verificarSessao();

        //Payload
        //$payload = array();
        //$payload['team'] = 'App Meu Campus';
        //$payload['score'] = '1.0';

        //Preenche os dados do json a ser enviado
        $json = array();
        $json['title'] = $this->input->post('txtTitulo');
        $json['message'] = $this->input->post('txtMensagem');
        //$json['is_background'] = false;
        //$json['image'] = '';
        //$json['payload'] = $payload;
        //$json['timestamp'] = date('Y-m-d G:i:s');

        $fields = array();
        $fields['to'] = '/topics/global';
        $fields['data'] = $json;

        $response = $this->sendPushNotification($fields);

        //echo json_encode($fields);

        if ($response != '') {
            $dados['msg'] = $response;
            $this->cadastro($dados);
        }
    }

    //Função que envia a requisição para o Firebase
    private function sendPushNotification($fields) {        
        $headers = array(
            'Authorization: key=AAAATfrW_9Q:APA91bEq0TDEF_EOsB0M36M2WZIw4aPojoO-B5I4z1_CY7sjTMz24bZtqRMPYM8yzEMZq89I-oDGtVjzC9cfMHKBbDNJMmFcR6kSu0DAZEk16iKbrj-ixxbuJynKResdS23VDW-_NrBc',
            'Content-Type: application/json'
        );

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
    }
}