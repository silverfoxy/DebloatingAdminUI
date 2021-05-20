<?php

class Loc_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function get_software_name($id)
    {
        $this->db->select('software_version.id, software.name, software_version.version, software_version.fk_software_id')
         ->from('software_version')
         ->join('software', 'software_version.fk_software_id = software.id')
         ->order_by('id', 'desc')
         ->where('software_version.id',$id);
        return $this->db->get()->result_array();
    }
    function add_loc_file($params){
        $this->db->insert('lines_of_code',$params);
        return $this->db->insert_id();
    }
    function get_loc_file(){
         return $this->db->get('lines_of_code')->result_array();
    }
    function get_loc_file_fromid($id){
         if ($id == null)
          return null;
        else
        {
             return $this->db->get_where('lines_of_code', array('ID'=>$id))->result_array();
        }
    }

}