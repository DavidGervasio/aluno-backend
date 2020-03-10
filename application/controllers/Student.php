<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require (APPPATH.'/libraries/Format.php');
require (APPPATH.'/libraries/REST_Controller.php');
require (APPPATH.'/libraries/S3.php');
require (APPPATH.'/libraries/image_check.php');
require (APPPATH.'/libraries/s3_config.php');

use chriskacerguis\RestServer\RestController;

class Student extends RestController{
    
    public function __construct()
    {   //permitir acesso de servidor externo
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        parent::__construct();
    }

    //listar todos alunos
    public function list_students_get()
	  {
        $this->load->model('StudentModel','student');
        $result = $this->student->list_studets();

        header('Content-Type: application/json');
        echo json_encode( $result );
    
    }

    //pegar um aluno pelo id
    public function student_get($id = 0)
	  {        
       $this->load->model('StudentModel','student', $id);
       $result = $this->student->get_studet($id);
      
       header('Content-Type: application/json');
       echo json_encode( $result );
    }
    //deletar aluno
    public function delete_get($id = 0)
	  {        
       $this->load->model('StudentModel','student', $id);
       $result = $this->student->delete_studet($id);
      
       header('Content-Type: application/json');
       echo json_encode( $result );
    }
    //registrar novo aluno
    public function student_post()
 	  {
        //Verifica se foi passado o campo nome vazio.
 		if ($this->input->post('nome') == NULL) {
 			  echo 'O campo nome do aluno é obrigatório.';
 			  echo '<a href="/produtos/add" title="voltar">Voltar</a>';
    }else if ( $this->input->post('endereco') == NULL){
        //Verifica se foi passado o campo endereço vazio.
        echo 'O compo endereço do aluno é obrigatório.';
        echo '<a href="/produtos/add" title="voltar">Voltar</a>';
    }else {

 		$this->load->model('StudentModel', 'student');
    
    $datas['nome'] = $this->input->post('nome');
 		$datas['endereco'] = $this->input->post('endereco');
                 
    $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
                
    $msg='';
   
    //pegar dodos da foto        
    $name = $_FILES['foto']['name'];
    $size = $_FILES['foto']['size'];
    $tmp = $_FILES['foto']['tmp_name'];
    $ext = getExtension($name);
 
      if(strlen($name) > 0)
      {
      // Validação do formato de arquivo 
          if(in_array($ext,$valid_formats))
          {
          // validação Tamanho do arquivo 
          if($size<(1024*1024))
          {
           
          $configDatas = config();
 
          $s3 =  $configDatas['s3'];
          $bucket= $configDatas['bucket'];
           
          //Renomear nome da imagem. 
          $actual_image_name = time().".".$ext;
 
          if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
          {
          $msg = "S3 Upload Successful.";
             $s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
             $datas['foto'] = $s3file;
            
             echo "<img src='$s3file'/>";
             echo 'S3 File URL:'.$s3file;
             }
             else
             $msg = "S3 Carregar Fail.";
 
             }
             else
             $msg = "Tamanho da imagem Max 1 MB";
 
             }
             else
             $msg = "arquivo inválido, faça upload do arquivo de imagem.";
 
             }
             else
             $msg = "Por favor, selecione o arquivo de imagem.";
 
             $result = $this->student->register_studet($datas);
             echo json_encode( $result );
             
        }		

     }

    public function update_post()
 	  {
        if($this->input->post('id') == NULL){
            //não faça nada
            echo 'O parametro de id do aluno é obrigatório.';
 			      echo '<a href="/produtos/add" title="voltar">Voltar</a>';
        }else if ($this->input->post('nome') == NULL) {
            //Verifica se foi passado o campo nome vazio. 
            echo 'O campo nome do aluno é obrigatório.';
 			      echo '<a href="/produtos/add" title="voltar">Voltar</a>';
        }else if ( $this->input->post('endereco') == NULL){
            //Verifica se foi passado o campo endereço vazio.
            echo 'O compo endereço do aluno é obrigatório.';
            echo '<a href="/produtos/add" title="voltar">Voltar</a>';
        }else {

            $this->load->model('StudentModel', 'student');

            $datas['nome'] = $this->input->post('nome');
 		      	$datas['endereco'] = $this->input->post('endereco');
            $datas['id'] = $this->input->post('id');
            
            $valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
                
            $msg='';
           
            $name = $_FILES['foto']['name'];
            $size = $_FILES['foto']['size'];
            $tmp = $_FILES['foto']['tmp_name'];
            $ext = getExtension($name);

            if(strlen($name) > 0)
            {
            // Validação do formato de arquivo 
            if(in_array($ext,$valid_formats))
            {
            // validação Tamanho do arquivo 
            if($size<(1024*1024))
            {
           
            $configDatas = config();

            $s3 =  $configDatas['s3'];
            $bucket= $configDatas['bucket'];
          
            $actual_image_name = time().".".$ext;
            
            $datas['foto'] ='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;

            if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
            {
              $msg = "S3 Upload Successful.";

              //echo "<img src='$GLOBALS['s3file']'/>";
              //echo 'S3 File URL:'.$GLOBALS['s3file'];
            }
            else
              $msg = "S3 Carregar Fail.";

            }
            else
              $msg = "Tamanho da imagem Max 1 MB";

            }
            else
              $msg = "arquivo inválido, faça upload do arquivo de imagem.";

            }
            else
              $msg = "Por favor, selecione o arquivo de imagem.";
           
            //$datas['foto'] = 'http://'.getenv("AWS_BUCKET").'.s3.amazonaws.com/'.$actual_image_name;
            //medida paleativa - realizar manutenção futura 
            //$datas['foto'] = 'http://urban-mobility-files-upload.s3.amazonaws.com/'.$actual_image_name;
            
         
            
            $result = $this->student->update_student($datas);
            echo json_encode( $result ); 



        }
           	
 		}		

}

