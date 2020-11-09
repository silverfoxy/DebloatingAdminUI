<?php
/*
 * Generated by CRUDigniter v3.2
 * www.crudigniter.com
 */

class Covered_line_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get covered_line by id
     */
    function get_covered_line($id)
    {
        return $this->db->get_where('covered_lines',array('id'=>$id))->row_array();
    }

    /*
     * Get covered_line filtered by file_name and test_group
     */
    function get_covered_lines_by_filename_and_testgroup($file_name, $test_group)
    {
        $this->db->distinct();
        $this->db->select('covered_lines.line_number')
         ->from('tests')
         ->where_in('tests.test_group', $test_group)
         ->join('covered_files', 'covered_files.fk_test_id = tests.id')
         ->where('covered_files.file_name', $file_name)
         ->join('covered_lines', 'covered_lines.fk_file_id = covered_files.id');
        $result = $this->db->get()->result_array();
        //print_r($this->db->last_query());
        return $result;
    }

    /*
     * Get covered_line filtered by file_name
     */
    function get_covered_lines_by_filename($file_name)
    {
        $this->db->distinct();
        $this->db->select('covered_lines.line_number')
         ->from('tests')
         ->join('covered_files', 'covered_files.fk_test_id = tests.id')
         ->where('covered_files.file_name', $file_name)
         ->join('covered_lines', 'covered_lines.fk_file_id = covered_files.id');
        $result = $this->db->get()->result_array();
        //print_r($this->db->last_query());
        return $result;
    }

    /*
     * Get all covered_lines filtered by fk_file_id
     */
    function get_all_covered_lines($id=null)
    {
        $this->db->order_by('id', 'desc');
        if ($id == null)
          return $this->db->get('covered_lines')->result_array();
        else
          return $this->db->get_where('covered_lines', array('fk_file_id'=>$id))->result_array();
    }

    /*
     * Get file name for fk_file_id
     */
    function get_file_name($id)
    {
        $this->db->select('file_name');
        return $this->db->get_where('covered_files',array('id'=>$id))->row()->file_name;
    }

    /*
     * function to add new covered_line
     */
    function add_covered_line($params)
    {
        $this->db->insert('covered_lines',$params);
        return $this->db->insert_id();
    }

    /*
    * function to add covered_lines in batch
    */
    function add_batch_covered_lines($params)
    {
        $this->db->insert_batch('covered_lines',$params);
        return true;
    }

    /*
     * function to update covered_line
     */
    function update_covered_line($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('covered_lines',$params);
    }

    /*
     * function to delete covered_line
     */
    function delete_covered_line($id)
    {
        if(is_array($id)){
            $this->db->where_in('id', $id);
        }else{
            $this->db->where('id', $id);
        }
        $delete = $this->db->delete('covered_lines');
        return $delete?true:false;
    }
}
