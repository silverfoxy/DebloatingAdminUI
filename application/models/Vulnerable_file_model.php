<?php
/*
 * Generated by CRUDigniter v3.2
 * www.crudigniter.com
 */

class Vulnerable_file_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Get vulnerable_file by id
     */
    function get_vulnerable_file($id)
    {
        return $this->db->get_where('vulnerable_files',array('id'=>$id))->row_array();
    }

    /*
     * Get all vulnerable_files
     */
    function get_all_vulnerable_files()
    {
        $this->db->select('vulnerable_files.id, vulnerabilities.cve, software.name, software_version.version, vulnerable_files.file_name, vulnerable_files.fk_vulnerability_software')
         ->from('vulnerable_files')
         ->join('vulnerability_software', 'vulnerable_files.fk_vulnerability_software = vulnerability_software.id')
         ->join('vulnerabilities', 'vulnerability_software.fk_vulnerability_id = vulnerabilities.id')
         ->join('software_version', 'vulnerability_software.fk_version_id = software_version.id')
         ->join('software', 'software_version.fk_software_id = software.id')
         ->order_by('id', 'desc');
        return $this->db->get()->result_array();
    }

    /*
     * function to add new vulnerable_file
     */
    function add_vulnerable_file($params)
    {
        $this->db->insert('vulnerable_files',$params);
        return $this->db->insert_id();
    }

    /*
     * function to update vulnerable_file
     */
    function update_vulnerable_file($id,$params)
    {
        $this->db->where('id',$id);
        return $this->db->update('vulnerable_files',$params);
    }

    /*
     * function to delete vulnerable_file
     */
    function delete_vulnerable_file($id)
    {
        return $this->db->delete('vulnerable_files',array('id'=>$id));
    }
}
