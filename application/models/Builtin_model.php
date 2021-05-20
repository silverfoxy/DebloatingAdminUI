<?php

class Builtin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function add_builtin_file($params){
        $this->db->insert('builtin_stats',$params);
        return $this->db->insert_id();
    }
    function get_builtin_file(){
         return $this->db->get('builtin_stats')->result_array();
    }
    function get_phploc_file_fromid($id){
         if ($id == null)
          return null;
        else
        {
             return $this->db->get_where('builtin_stats', array('ID'=>$id))->result_array();
        }
    }

}

?>