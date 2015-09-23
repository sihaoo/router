<?php

namespace access\classes\template;

require_once('tools/constants/constants.php');
require_once('tools/constants/limits.php');
require_once('tools/database/helper.php');
require_once('tools/database/formatter.php');
require_once('tools/object/classes.php');
require_once('tools/validation/enforcer.php');
require_once('tools/writer/writer.php');

use tools\constants\Constants as Constants;
use tools\constants\Limits as Limits;
use tools\database\DatabaseHelper as DatabaseHelper;
use tools\database\Formatter as Formatter;
use tools\object\Classes as Classes;
use tools\writer\Writer as Writer;

class Accessor extends Classes {
	
	var $helper = null;
	
	public function __construct($route) { 
		parent::__construct($route); 
		$this->helper = new DatabaseHelper($this->route);
	}
	
	/*  retrieves data based on $param 
	    get_accessor(null): retrieves all records of accessor
		get_accessor(id:int): retrieves all records with the corresponding
		get_accessor(search_term:string): retrieves all record that correspond with the search term given
		get_accessor(search_term:variable, row_name:string): retrieves all records with the match row data
	*/
	public function get_accessor($param, $post_params) { 
		 
		//define tags for parent tags and child tag
		$parent_tag = 'accessors'; $child_tag = 'accessor';
		
		//handle authentication
		
		//initalizing and set default for params
		$statement = ''; $param[0] = set_default($param[0], '');
		
		//handle $param parsing	
		if(is_ready($param[0]) == false) { //retrieve all records
			$statement = 'SELECT * FROM accessor';
		} else if(count($param) == 1) {  
			if (is_numeric($param[0])) { //retrieve record based on the id
				$statement = 'SELECT * FROM accessor WHERE _id = ' .$param[0];
			} else if(is_string($param[0])) {  //retrieve record based on the search term on all columns
				
			}
		} else if(count($param) == 2) { //retrieve and search on column data
			
		}
		
		//connect to database to retrieve records
		$this->helper->query($statement);
		$results = $this->helper->execute(); $post = array();
		foreach($results as $result) { $post[][$child_tag] = $result; }
		Writer::write(200, $post, $parent_tag, $this->route->get_return_type());
	}
	
	 /* passing in required varables to be updated to the particular object
	 	the id to be affected by can passed by $param or as _id in $post_params['_id']
		$post_params['_id'] takes precedence
		id is required*
		returns boolean to indicate if rows were affected
	 */
	 public function update_accessor($param, $post_params) {
	 	
		//define tags for parent tags and child tag
		$parent_tag = 'results'; $child_tag = 'result';
	
		$id_limit = Limits::get('id_limit');
		$param[0] = set_default($param[0], '');
		$_id = set_default($post_params['_id'], $param[0]);
		$enforcement = enforce_inputs(array($_id, 'numeric', $id_limit['min'], $id_limit['max'], false), $this->route->get_return_type());
		
	 }
	
	/* passing in required variables to be used to create object
	   read only the post params variables (key value pair)
	   $post_params['_id'] takes precedence
	   id is required*
	   returns boolean to indicate if rows were affected
	*/   
	public function create_accessor($param, $post_params) {
		
		//define tags for parent tags and child tag
		$parent_tag = 'results'; $child_tag = 'result';
	
		$id_limit = Limits::get('id_limit');
		$param[0] = set_default($param[0], '');
		$_id = set_default($post_params['_id'], $param[0]);
		enforce_inputs(array($_id, 'numeric', $id_limit['min'], $id_limit['max'], false), $this->route->get_return_type());
	}
	
	/*  retrieves data based on $param 
	    delete_accessor(null): (NOT IMPLEMENTED)
		delete_accessor(id:int): delete record with the corresponding id
		delete_accessor(search_term:string): delete all records that correspond with the search term given
		delete_accessor(search_term:variable, row_name:string): retrieves all records with the match row data
	*/
	public function delete_accessor($param, $post_params) {
		
		//define tags for parent tags and child tag
		$parent_tag = 'results'; $child_tag = 'result';
		
		//handle authentication
		
		//initalizing and set default for params
		$statement = ''; $param[0] = set_default($param[0], '');
		
		//handle $param parsing	
		if(is_ready($param[0]) == false) { //delete all records
			Writer::write(501, 'Method not implemented.', Constants::get('error_tag'), parent::get_route()->get_return_type());
		} else if(count($param) == 1) {  
			if (is_numeric($param[0])) { //delete record based on the id
				$statement = 'DELETE FROM accessor WHERE _id = ' .$param[0];
			} else if(is_string($param[0])) {  //delete record based on the search term on all columns
				
			}
		} else if(count($param) == 2) { //delete record based on the search term on a row column			
		}
		
		
	}
}

?>