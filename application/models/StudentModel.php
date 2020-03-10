<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StudentModel extends CI_Model {

    public function index()
	{
		$this->load->view('welcome_message');
    }
    //listar aluno no banco de dados
    public function list_studets()
    {
        $query=$this->db->get('Aluno');
        return $query->result();
    }
    //pegar aluno no banco de dados pelo id
    public function get_studet($id)
    {
        $query=$this->db->get_where('Aluno',array('id'=>$id));
        return $query->result();
    }
    //deletar aluno no banco de dados pelo id
    public function delete_studet($id)
    {
        $query=$this->db->delete('Aluno', array('id'=>$id));
        return $query;
    }

    //registrar aluno no banco de dados  
    public function register_studet($datas=NULL)
 	{
        if ($datas != NULL)
        {
            $query = $this->db->insert('Aluno', $datas);		
            return  $query;
        
        }else 
        {
            return false;
        } 
    }
    //atalizar aluno no banco de dados pelo id 
    public function update_student($datas=NULL)
    {
       if ($datas != NULL)
       {
           $this->db->where('id', $datas['id']);
           $this->db->set($datas);
           return $this->db->update('Aluno',$datas);
        }else 
        {
           return false;
       } 
   }

}

