<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Cardapio_model extends CI_Model {

		public $data;
		public $tipo_refeicao;
		public $descricao;
        public $data_inclusao;
        public $usuario_inclusao;
        public $data_ult_atualizacao;
        public $usuario_ult_atualizacao;

		function __construct() {
			parent::__construct();
		}

		public function inserir($dados) {
        	return $this->db->insert('cardapio', $dados);
		}

		public function excluir($id) {
			$this->db->where('id', $id);
	        return $this->db->delete('cardapio');
		}

		public function salvarAlteracao($id, $dados) {
	        $this->db->where('id', $id);
	        return $this->db->update('cardapio', $dados);
		}

		public function retornarCardapio($id) {
			$this->db->where('id', $id);
        	return $this->db->get('cardapio')->result();
		}

		public function retornarCardapios($posicao = null, $registrosPorPagina = null) {
			$this->db->select('id, date_format(data, "%d/%m/%Y") data, tipo_refeicao, descricao');

	        $this->db->order_by('data DESC, tipo_refeicao');

	        if ($posicao != null && $registrosPorPagina != null) {
	        	$this->db->limit($registrosPorPagina, $posicao);
	        }

	        return $this->db->get('cardapio')->result();
		}

		public function retornarQuantidadeDeCardapios() {
			return $this->db->count_all('cardapio');
		}
	}

?>