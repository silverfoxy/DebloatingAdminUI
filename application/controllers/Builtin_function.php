<?php
class Builtin_function extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Builtin_model');
    }
    function index($id=null){
            $data['builtin_files'] = $this->Builtin_model->get_builtin_file();
            $data['_view'] = 'builtin_function/index';
            $this->load->view('layouts/main',$data);
        
        
    }
     function add($id=null)
    {   
        if(isset($_POST) && count($_POST) > 0)
        {
            
            $this->load->model('Phploc_model');
            $software_id = $this->input->post('fk_version_id');
            $software_list = $this->Phploc_model->get_software_name($software_id); #
            $software_name = $software_list[0]['name'];
            $software_version = $software_list[0]['version'];
            $description = $this->input->post('description');
            $software_name_version = $software_name.'-'.$software_version; 
            $commandlineinput = 'php builtin_functions_usage/analyze.php ';        
            $commandlineinput .= $software_name.'/';
            $commandlineinput .= $software_name_version;             
            exec ($commandlineinput, $commandlineoutput);
            $data = array();    //data[0] = total, data[1] = Command execution....
            for($i =0;$i<count($commandlineoutput);$i++){ 
             $data[$i] = $commandlineoutput[$i];
            }
             $params = array(
                'total' => $data[0],
                'command_execution' => $data[1],
                'code_execution' => $data[2],
                'callbacks' => $data[3],
                'information_disclosure' => $data[4],
                'software_name' => $software_name,
                'version' => $software_version,
                'description' => $description,
            );
            $this->load->model('Builtin_model');
            $this->Builtin_model->add_builtin_file($params);
            redirect('builtin_function/index');

        }
        else{
            $this->load->model('Software_version_model');
            $data['software_versions'] = $this->Software_version_model->get_all_software_version();
            $data['_view'] = 'builtin_function/add';
            $this->load->view('layouts/main',$data);
        }
    }
    function seperate_listing($id){
        $data['builtin_files']= $this->Builtin_model-> get_phploc_file_fromid($id);
        $data['_view'] = 'builtin_function/seperate_listing';
        $this->load->view('layouts/main',$data);
    }
}
?>