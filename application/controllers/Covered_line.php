<?php
/*
 * Generated by CRUDigniter v3.2
 * www.crudigniter.com
 */

class Covered_line extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Covered_line_model');
    }

    /*
     * Listing of covered_lines
     */
    function index($id=null)
    {
        if($id==null) {
            $data['covered_lines'] = $this->Covered_line_model->get_all_covered_lines();
            $data['file_name'] = null;
        }
        else
        {
            $data['covered_lines'] = $this->Covered_line_model->get_all_covered_lines($id);
            $data['file_name'] = $this->Covered_line_model->get_file_name($id);
        }

        $data['_view'] = 'covered_line/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new covered_line
     */
    function add()
    {
        if(isset($_POST) && count($_POST) > 0)
        {
            $params = array(
				'fk_file_id' => $this->input->post('fk_file_id'),
				'line_number' => $this->input->post('line_number'),
				'run' => $this->input->post('run'),
            );

            $covered_line_id = $this->Covered_line_model->add_covered_line($params);
            redirect('covered_line/index');
        }
        else
        {
			$this->load->model('Vulnerable_file_model');
			$data['all_vulnerable_files'] = $this->Vulnerable_file_model->get_all_vulnerable_files();

            $data['_view'] = 'covered_line/add';
            $this->load->view('layouts/main',$data);
        }
    }

    /*
     * Editing a covered_line
     */
    function edit($id)
    {
        // check if the covered_line exists before trying to edit it
        $data['covered_line'] = $this->Covered_line_model->get_covered_line($id);

        if(isset($data['covered_line']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)
            {
                $params = array(
					'fk_file_id' => $this->input->post('fk_file_id'),
					'line_number' => $this->input->post('line_number'),
					'run' => $this->input->post('run'),
                );

                $this->Covered_line_model->update_covered_line($id,$params);
                redirect('covered_line/index');
            }
            else
            {
				$this->load->model('Vulnerable_file_model');
				$data['all_vulnerable_files'] = $this->Vulnerable_file_model->get_all_vulnerable_files();

                $data['_view'] = 'covered_line/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The covered_line you are trying to edit does not exist.');
    }

    /*
     * Deleting covered_line
     */
    function remove($id)
    {
        $covered_line = $this->Covered_line_model->get_covered_line($id);

        // check if the covered_line exists before trying to delete it
        if(isset($covered_line['id']))
        {
            $this->Covered_line_model->delete_covered_line($id);
            redirect('covered_line/index');
        }
        else
            show_error('The covered_line you are trying to delete does not exist.');
    }

}
