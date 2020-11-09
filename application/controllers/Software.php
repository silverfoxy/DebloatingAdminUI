<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Software extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Software_model');
    } 

    /*
     * Listing of software
     */
    function index()
    {
        $data['software'] = $this->Software_model->get_all_software();
        
        $data['_view'] = 'software/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new software
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'name' => $this->input->post('name'),
            );
            
            $software_id = $this->Software_model->add_software($params);
            redirect('software/index');
        }
        else
        {            
            $data['_view'] = 'software/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a software
     */
    function edit($id)
    {   
        // check if the software exists before trying to edit it
        $data['software'] = $this->Software_model->get_software($id);
        
        if(isset($data['software']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'name' => $this->input->post('name'),
                );

                $this->Software_model->update_software($id,$params);            
                redirect('software/index');
            }
            else
            {
                $data['_view'] = 'software/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The software you are trying to edit does not exist.');
    } 

    /*
     * Deleting software
     */
    function remove($id)
    {
        $software = $this->Software_model->get_software($id);

        // check if the software exists before trying to delete it
        if(isset($software['id']))
        {
            $this->Software_model->delete_software($id);
            redirect('software/index');
        }
        else
            show_error('The software you are trying to delete does not exist.');
    }
    
}