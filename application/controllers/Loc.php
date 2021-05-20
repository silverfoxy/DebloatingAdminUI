<?php
class Loc extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Loc_model');
    }

    function index($id=null)
    {
        $data['phploc_files'] = $this->Phploc_model->get_loc_file();
        $data['_view'] = 'loc/index';
        $this->load->view('layouts/main',$data);
    }

    function add($id=null)
    {	
        if(isset($_POST) && count($_POST) > 0)
        {
            $this->load->model('Loc_model');
            $software_id = $this->input->post('fk_version_id');
            $software_list = $this->Phploc_model->get_software_name($software_id); #
            $software_name = $software_list[0]['name'];
            $software_version = $software_list[0]['version'];
            $description = $this->input->post('description');
            $software_name_version = $software_name.'-'.$software_version; 
            $commandlineinput = 'php phploc-master/phploc.phar ';      
            $commandlineinput .= $software_name.'/';
            $commandlineinput .= $software_name_version;    
            exec ($commandlineinput, $commandlineoutput);
            $data = array(); 
            $totalsize = array();
            $percentagecount = array();
            for($i =2;$i<count($commandlineoutput);$i++){ 
                if (empty($commandlineoutput[$i])) continue;         #skipping empty string 
                $outputstring = explode(" ",$commandlineoutput[$i]); #Splitting based on space
                $wp = implode("",$outputstring); 
                $stringval = "";
                $intval = "";
                $percentage = "";
                $percentageflag = 0;
                $intflag = 0;
                for($j =0;$j<strlen($wp);$j++)
                {
                    $currchar = $wp[$j];
                    if($currchar == ""){
                        continue;
                    }
                    if(ctype_digit($currchar)){
                        if($percentageflag == 1){                #Meaning the value we see from hereon is percentage
                            $percentage.=$currchar;
                        }
                        else{                                   
                            $intval .= $currchar;                #Appending it to Integer string
                            $intflag = 1;
                        }
                    }
                    else
                    {
                        if($intflag == 1)
                        {
                            if($currchar == '(' || $currchar == ')')
                            {
                                $percentageflag = 1;
                            }
                            if ($percentageflag == 1)
                            {
                                if($currchar == '.')    #Appending  '.' to percentage
                                {             
                                    $percentage.=$currchar;
                                }
                            }
                            else
                            {
                                $intval .= $currchar;
                            }
                        }
                        else{
                            $stringval.=$currchar;
                        }
                    }
                }
                array_push($data,$stringval);
                array_push($totalsize,$intval);
                array_push($percentagecount,$percentage);
            }
            $params = array(
                'software_name' => $software_name,
                'version' => $software_version,
                'data_details' => serialize($data),
                'size' => serialize($totalsize),
                'percentage' => serialize($percentagecount),
                'description' => $description,
            );
            $this->Loc_model->add_loc_file($params);
            redirect('loc/index');
        }
        else{
            $this->load->model('Software_file_model');
            // array_map(function($row) { return sprintf('%s %s (%s)', $row['name'], $row['version'], $row['description']); }, $software_versions);
            $data['software_versions'] = $this->Software_file_model->get_all_software_files_descriptions();
            $data['_view'] = 'phploc/add';
            $this->load->view('layouts/main',$data);
        }
    }

    function seperate_listing($id){
        $data['loc_files'] = $this->Loc_model->get_loc_file_fromid($id);
        $data['_view'] = 'loc/seperate_listing';
        $this->load->view('layouts/main',$data);
    }

}