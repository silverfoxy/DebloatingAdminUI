<?php

require_once FCPATH.'/vendor/geshi/geshi/src/geshi.php';

class Report extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Report_model');
    }

    /*
     * Listing of tests
     */
    function index($id=null)
    {
        $this->load->model('Test_model');
        if($id==null) {
            // return test groups
            $data['tests'] = $this->Test_model->get_all_test_groups();
            $data['_view'] = 'report/groups';
        }
        else {
            // return all tests within a category
            $data['tests'] = $this->Test_model->get_all_tests_by_group($id);
            $data['_view'] = 'report/index';
        }
        $this->load->view('layouts/main',$data);
    }

    /*
     * Listing of covered vulnerabilities by a test group
     */
     function covered_vulnerabilities($id=null)
     {
       $test_groups = $this->_get_test_groups_from_url();
       $this->load->model('Vulnerability_software_model');
       if($id==null) {
         $data['vulnerability_software'] = array();
       }
       elseif (sizeof($test_groups) > 1) {
         $data['vulnerability_software'] = $this->Report_model->get_all_vulnerabilities_by_test_group_array($test_groups);
         $data['trigerred_vulnerability_ids'] = $this->Report_model->get_covered_vulnerabilities_id_by_test_group_array($test_groups);;
       }
       else {
         $data['vulnerability_software'] = $this->Report_model->get_all_vulnerabilities_by_test_group($id);
         $data['trigerred_vulnerability_ids'] = $this->Report_model->get_covered_vulnerabilities_id_by_test_group($id);;
       }
       $data['_view'] = 'report/covered_vulnerabilities';
       $this->load->view('layouts/main',$data);
     }

     /*
      * Listing of covered vulnerabilities by a test group as CSV
      */
      function covered_vulnerabilities_csv($id=null)
      {
        $test_groups = $this->_get_test_groups_from_url();
        $this->load->model('Vulnerability_software_model');
        if($id==null) {
          $data['vulnerability_software'] = array();
        }
        elseif (sizeof($test_groups) > 1) {
          $data['vulnerability_software'] = $this->Report_model->get_all_vulnerabilities_by_test_group_array($test_groups);
          $data['trigerred_vulnerability_ids'] = $this->Report_model->get_covered_vulnerabilities_id_by_test_group_array($test_groups);;
        }
        else {
          $data['vulnerability_software'] = $this->Report_model->get_all_vulnerabilities_by_test_group($id);
          $data['trigerred_vulnerability_ids'] = $this->Report_model->get_covered_vulnerabilities_id_by_test_group($id);;
        }
        $data['test_groups'] = $test_groups;
        //$data['_view'] = 'report/covered_vulnerabilities';
        header('Content-Type: text/csv');
        header('Content-Disposition: inline; filename="covered_vulns_'.implode("_",$test_groups).'.csv"');
        $this->load->view('report/covered_vulnerabilities_csv',$data);
      }

      /*
       * Listing of covered vulnerable files by a test group
       */
      function covered_vulnerable_files($id=null)
      {
        $test_groups = $this->_get_test_groups_from_url();
        if($id==null) {
          $data['vulnerable_files'] = array();
        }
        elseif (sizeof($test_groups) > 1) {
          $data['vulnerable_files'] = $this->Report_model->get_all_vulnerable_files_by_test_group_array($test_groups);
          $data['trigerred_vulnerable_file_ids'] = $this->Report_model->get_covered_vulnerable_files_id_by_test_group_array($test_groups);;
        }
        else {
           $data['vulnerable_files'] = $this->Report_model->get_all_vulnerable_files_by_test_group($id);
           $data['trigerred_vulnerable_file_ids'] = $this->Report_model->get_covered_vulnerable_files_id_by_test_group($id);;
        }
        $data['_view'] = 'report/covered_vulnerable_files';
        $this->load->view('layouts/main',$data);
      }

      /*
       * Listing of covered vulnerable files by a test group as CSV
       */
      function covered_vulnerable_files_csv($id=null)
      {
        $test_groups = $this->_get_test_groups_from_url();
        if($id==null) {
          $data['vulnerable_files'] = array();
        }
        elseif (sizeof($test_groups) > 1) {
          $data['vulnerable_files'] = $this->Report_model->get_all_vulnerable_files_by_test_group_array($test_groups);
          $data['trigerred_vulnerable_file_ids'] = $this->Report_model->get_covered_vulnerable_files_id_by_test_group_array($test_groups);;
        }
        else {
           $data['vulnerable_files'] = $this->Report_model->get_all_vulnerable_files_by_test_group($id);
           $data['trigerred_vulnerable_file_ids'] = $this->Report_model->get_covered_vulnerable_files_id_by_test_group($id);;
        }
        $data['test_groups'] = $test_groups;
        header('Content-Type: text/csv');
        header('Content-Disposition: inline; filename="covered_vuln_files_'.implode("_",$test_groups).'.csv"');
        $this->load->view('report/covered_vulnerable_files_csv',$data);
      }

      /*
       * Listing of covered vulnerable functions by a test group
       */
      function covered_vulnerable_functions($id=null)
      {
        $test_groups = $this->_get_test_groups_from_url();
        if($id==null) {
          $data['vulnerable_functions'] = array();
        }
        elseif (sizeof($test_groups) > 1) {
          $data['vulnerable_functions'] = $this->Report_model->get_all_vulnerable_functions_by_test_group_array($test_groups);
          $data['trigerred_vulnerable_function_ids'] = $this->Report_model->get_covered_vulnerable_function_ids_by_test_group_array($test_groups);;
        }
        else {
           $data['vulnerable_functions'] = $this->Report_model->get_all_vulnerable_functions_by_test_group($id);
           $data['trigerred_vulnerable_function_ids'] = $this->Report_model->get_covered_vulnerable_function_ids_by_test_group($id);
        }
        $data['_view'] = 'report/covered_vulnerable_functions';
        $this->load->view('layouts/main',$data);
      }

      /*
       * Listing of covered vulnerable functions by a test group as CSV
       */
      function covered_vulnerable_functions_csv($id=null)
      {
        $test_groups = $this->_get_test_groups_from_url();
        if($id==null) {
          $data['vulnerable_functions'] = array();
        }
        elseif (sizeof($test_groups) > 1) {
          $data['vulnerable_functions'] = $this->Report_model->get_all_vulnerable_functions_by_test_group_array($test_groups);
          $data['trigerred_vulnerable_function_ids'] = $this->Report_model->get_covered_vulnerable_function_ids_by_test_group_array($test_groups);;
        }
        else {
           $data['vulnerable_functions'] = $this->Report_model->get_all_vulnerable_functions_by_test_group($id);
           $data['trigerred_vulnerable_function_ids'] = $this->Report_model->get_covered_vulnerable_function_ids_by_test_group($id);
        }
        $data['test_groups'] = $test_groups;
        header('Content-Type: text/csv');
        header('Content-Disposition: inline; filename="covered_vuln_functions_'.implode("_",$test_groups).'.csv"');
        $this->load->view('report/covered_vulnerable_functions_csv',$data);
      }

      /*
       * Listing of covered vulnerable functions by a test group
       */
      function covered_vulnerable_lines($id=null)
      {
        $test_groups = $this->_get_test_groups_from_url();
        if($id==null) {
          $data['vulnerable_functions'] = array();
        }
        elseif (sizeof($test_groups) > 1) {
          $data['vulnerable_lines'] = $this->Report_model->get_all_vulnerable_lines_by_test_group_array($test_groups);
          $data['trigerred_vulnerable_line_ids'] = $this->Report_model->get_covered_vulnerable_line_ids_by_test_group_array($test_groups);;
        }
        else {
           $data['vulnerable_lines'] = $this->Report_model->get_all_vulnerable_lines_by_test_group($id);
           $data['trigerred_vulnerable_line_ids'] = $this->Report_model->get_covered_vulnerable_line_ids_by_test_group($id);
        }
        $data['_view'] = 'report/covered_vulnerable_lines';
        $this->load->view('layouts/main',$data);
      }

      /*
       * Listing of covered vulnerable functions by a test group as CSV
       */
      function covered_vulnerable_lines_csv($id=null)
      {
        $test_groups = $this->_get_test_groups_from_url();
        if($id==null) {
          $data['vulnerable_functions'] = array();
        }
        elseif (sizeof($test_groups) > 1) {
          $data['vulnerable_lines'] = $this->Report_model->get_all_vulnerable_lines_by_test_group_array($test_groups);
          $data['trigerred_vulnerable_line_ids'] = $this->Report_model->get_covered_vulnerable_line_ids_by_test_group_array($test_groups);;
        }
        else {
           $data['vulnerable_lines'] = $this->Report_model->get_all_vulnerable_lines_by_test_group($id);
           $data['trigerred_vulnerable_line_ids'] = $this->Report_model->get_covered_vulnerable_line_ids_by_test_group($id);
        }
        $data['test_groups'] = $test_groups;
        header('Content-Type: text/csv');
        header('Content-Disposition: inline; filename="covered_vuln_lines_'.implode("_",$test_groups).'.csv"');
        $this->load->view('report/covered_vulnerable_lines_csv',$data);
      }

     /*
     * Used to parse multiple parameters passed in url separated by / and return an array
     */
     function _get_test_groups_from_url()
     {
       $segments = $this->uri->total_segments();
       $test_groups = array();
       for ($i=3; $i <= $segments; $i++) {
         array_push($test_groups, $this->uri->segment($i));
       }
       return $test_groups;
     }

     function delete_testgroup($id) {
         $this->load->model('Test_model');
         $this->load->model('Covered_file_model');
         $this->load->model('Covered_line_model');
         $test_ids = array_map(
             function($entry) {return $entry['id'];},
             $this->Test_model->get_all_tests_by_group($id)
         );
         $covered_file_ids = [];
         $covered_line_ids = [];
         foreach ($test_ids as $test_id) {
             $covered_file_ids =  array_map(
                 function($entry) {return $entry['id'];},
                 $this->Covered_file_model->get_all_covered_files($test_id)
             );
         }
         foreach ($covered_file_ids as $covered_file_id) {
             $covered_line_ids = array_map(
                 function($entry) {return $entry['id'];},
                 $this->Covered_line_model->get_all_covered_lines($covered_file_id)
             );
         }
         $this->Covered_line_model->delete_covered_line($covered_line_ids);
         $this->Covered_file_model->delete_covered_file($covered_file_ids);
         $this->Test_model->delete_test($test_ids);

         $this->load->helper('url');
         redirect('/report', 'refresh');
     }

      /*
       * Show a diff of covered files between two test groups
       */
      function diff($id=null)
      {
		  $test_groups = $this->_get_test_groups_from_url();
		  // $data['software_files'] = $this->Software_file_model->get_all_software_files($id);
          if($id==null) {
			$data['test_groups'] = array();
			$data['software_files'] = array();
          }
          elseif (sizeof($test_groups) > 1) {
            $data['test_groups'] = $test_groups;
            $test_group_software_info = [];
            $this->load->model('Test_model');
            $this->load->model('Covered_file_model');
            $this->load->model('Covered_line_model');
			$test_ids = [];
			foreach ($test_groups as $test_group) {
				$test_info = $this->Test_model->get_test_by_test_group($test_group)[0];
				$test_ids[] = $test_info['id'];
				$covered_files = $this->Covered_file_model->get_all_covered_files($test_info['id']);
				foreach ($covered_files as $file) {
				    if (!array_key_exists($file['file_name'], $test_group_software_info)) {
                        $test_group_software_info[$file['file_name']] = array(
                            'id' => array($file['id']),
                            'test_group_coverage' => array( $test_info['test_group']),
                            'covered_lines' => array(
                                $test_info['test_group'] => array_map(
                                    function($entry) {return $entry['line_number'];},
                                    $this->Covered_line_model->get_all_covered_lines($file['id']))
                            ),
                            'software' => $test_info['name'],
                            'version' => $test_info['version'],
                            'file_name' => $file['file_name'],
                        );
                    }
                    else {
                        $test_group_software_info[$file['file_name']]['id'][] = $file['id'];
                        $test_group_software_info[$file['file_name']]['test_group_coverage'][] = $test_info['test_group'];
                        $test_group_software_info[$file['file_name']]['covered_lines'][$test_info['test_group']] = array_map(
                                function($entry) {return $entry['line_number'];},
                                $this->Covered_line_model->get_all_covered_lines($file['id'])
                        );
                    }
                }
			}
			$data['test_ids'] = $test_ids;
			$mismatch = 0;
			foreach ($test_group_software_info as $file_name => $entry) {
			    if (sizeof($entry['test_group_coverage']) < sizeof($test_groups)) {
			        $mismatch++;
                }
            }
			foreach ($test_group_software_info as $filename => $entry) {
			    $matched = 0;
			    $unmatched = 0;
			    $test_groups = array_keys($entry['covered_lines']);
			    if (sizeof($test_groups) === 2) {
                    if (sizeof($entry['covered_lines'][$test_groups[0]]) <= sizeof($entry['covered_lines'][$test_groups[1]])) {
                        $shorter_lines_array = $entry['covered_lines'][$test_groups[0]];
                        $longer_lines_array = $entry['covered_lines'][$test_groups[1]];
                    }
                    else {
                        $shorter_lines_array = $entry['covered_lines'][$test_groups[1]];
                        $longer_lines_array = $entry['covered_lines'][$test_groups[0]];
                    }
                    foreach ($shorter_lines_array as $line_number) {
                        if (in_array($line_number, $longer_lines_array)) {
                            $matched++;
                        }
                        else {
                            $unmatched++;
                        }
                    }
                    $unmatched += sizeof($longer_lines_array) - sizeof($shorter_lines_array);
                }
			    else {
			        $unmatched += sizeof($entry['covered_lines'][$test_groups[0]]);
                }
                $test_group_software_info[$filename]['matched_coverage'] = $matched;
                $test_group_software_info[$filename]['unmatched_coverage'] = $unmatched;
            }
			$data['mismatch'] = $mismatch . '/' . sizeof($test_group_software_info);
            $data['software_files'] = $test_group_software_info;
          }
          else {
            $data['vulnerable_files'] = $this->Report_model->get_all_vulnerable_files_by_test_group($id);
            $data['trigerred_vulnerable_file_ids'] = $this->Report_model->get_covered_vulnerable_files_id_by_test_group($id);;
          }
          $data['_view'] = 'report/diff_list';
          $this->load->view('layouts/main',$data);
      }

    /*
     * Show a diff of lines within a specific file between two test groups
     */
    function diff_files($file_id_1=null, $file_id_2=null, $testgroup_1=null, $testgroup_2=null)
    {
        if (!isset($file_id_1) || !isset($file_id_2) || !isset($testgroup_1) || !isset($testgroup_2)) {
            echo 'here';
        }
        else {
            $this->load->model('Test_model');
            $this->load->model('Covered_file_model');
            $this->load->model('Covered_line_model');
            $test_group[0] = $this->Test_model->get_test($testgroup_1)['test_group'];
            $test_group[1] = $this->Test_model->get_test($testgroup_2)['test_group'];
            $data['test_group'] = $test_group;
            if ($file_id_1 != -1) {
                $file_path = $this->Covered_file_model->get_covered_file($file_id_1)['file_name'];
            }
            else {
                $file_path = $this->Covered_file_model->get_covered_file($file_id_2)['file_name'];
            }
            $data['file_path'] = $file_path;
            $covered_lines_1 = array_map(
                function($entry) {return $entry['line_number'];},
                $this->Covered_line_model->get_all_covered_lines($file_id_1)
            );
            $covered_lines_2 = array_map(
                function($entry) {return $entry['line_number'];},
                $this->Covered_line_model->get_all_covered_lines($file_id_2)
            );
            $php_code = '';
            try {
                $file_contents = @file_get_contents($file_path);
                if ($file_contents === false) {
                    $data['error_messages'][] = 'File not found';
                    $data['php_code'] = '';
                    $data['_view'] = 'report/diff_files';
                    $this->load->view('layouts/main',$data);
                    return;
                }
                $geshi = new Geshi(file_get_contents($file_path), 'php');
                $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS );
                $geshi->set_line_style('background: #fcfcfc;');
                $lines_in_both = [];
                $lines_only_in_1 = [];
                foreach ($covered_lines_1 as $line) {
                    if (!in_array($line, $covered_lines_2)) {
                        $lines_only_in_1[] = $line;
                    }
                    else {
                        $lines_in_both[] = $line;
                    }
                }
                $lines_only_in_2 = [];
                foreach ($covered_lines_2 as $line) {
                    if (!in_array($line, $covered_lines_1)) {
                        $lines_only_in_2[] = $line;
                    }
                }
                $geshi->highlight_lines_extra($lines_only_in_1, 'background: #f0a0a0');
                $geshi->highlight_lines_extra($lines_only_in_2);
                $geshi->highlight_lines_extra($lines_in_both, 'background: #b0f0a0');
                $php_code = $geshi->parse_code();
            }
            catch(\Exception $e) {
                $data['error_messages'][] = $e->getMessage();
            }
            $data['php_code'] = $php_code;
        }
        $data['_view'] = 'report/diff_files';
        $this->load->view('layouts/main',$data);
    }
}
