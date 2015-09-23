<?php

namespace tools\database;

require_once('tools/constants/constants.php');
require_once('tools/constants/limits.php');
require_once('tools/validation/validator.php');

use tools\constants\Constants as Constants;
use tools\constants\Limits as Limits;

/** tools/database/formatter.php 
 * generate sql statements and query for request
 */
class Formatter {
	
	/* return the statement to be requested to the database based on the indicated conditions
	   $statement_type: 'select, 'insert', 'update', 'delete' - verified against defined constants
	   $list: array(key=>value, key=>value)
	   $list_type: include\exclude
	   include and exclude are exclusive, choose the situable one
	   $tables: tables required in this query
	   $conditions: (table_one._id=table_two._id, table_three._id=table_four.id) 
	*/
	public static function generate_statement($statement_type, $list, $list_type, $tables, $conditions, $return_type = 'json') {
	
		//sets list to select all if not provided
		$list = set_default($list, '*');
		$conditions = set_default($conditions, '');
		
		//retrieve limits for shorthand
		$zero_minimium = Limits::get('zero_minimium');
		$text_limit = Limits::get('text_limit');
		
		//validate statement type
		$statement_types = Constants::get('statement_types');
		enforce_inputs(array($statement_type, 'string', $statement_types, null, false), //statement must be within thesallowed list
					   array($list, 'array', null, null, true), //if list is null, default is select all
					   array($list_type, 'string', Constants::get('statement_list_types'), null, false),
					   array($tables, 'string', $text_limit['min'], $text_limit['max'], false), //table name is required
					   array($conditions, 'string', $zero_minimium, $text_limit['max'], true), $return_type); //conditions are optional
					   
		$statement = '';			   
		if(compare_string($statement, 'SELECT', false)) { $statement = format_select($list, $list_type, $tables, $conditions);
		} else if (compare_string($statement, 'INSERT', false)) { $statement = format_insert($list, $list_type, $tables, $conditions);
		} else if(compare_string($statement, 'UPDATE', false)) { $statement = format_update($list, $tables, $list_type, $conditions);
		} else if(compare_string($statement, 'DELETE', false)) { $statement = format_delete($list, $tables, $list_type, $conditions); }
	}
	
	public static function format_select($list, $list_type, $tables, $conditions) {
		$statement_type = 'SELECT'; $statement = $statement_type;
		if($list == null) { $statement .= ' *'; }	
	}
	
	public static function format_insert($list, $list_type, $tables, $conditions) {
		$statement_type = 'INSERT';
	}
	
	public static function format_update($list, $list_type, $tables, $conditions) {
		$statement_type = 'UPDATE';
	}
	
	public static function format_delete($list, $list_type, $tables, $conditions) {
		$statement_type = 'DELETE';
		
		
	}
}
	
?>