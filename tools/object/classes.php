<?php

namespace tools\object;

require_once('tools/object/tool.php');
require_once('tools/constants/constants.php');

use tools\constants\Constants as Constants;
use tools\object\Tool as Tool;

/** tools/object/class.php 
 *  contains the methods and constructor that every class require
 */
class Classes {
	
	var $route = null;
	
	public function __construct($route) {
		$function = array('class_name'=>__NAMESPACE__, 'method_name'=>__METHOD__);	
		//validate if route is valid else throw error
		if(is_ready($route)) { $this->route = $route; 
		} else { //route is invalid, throw error
			$error = Tool::prepare('Route is invalid, unable to process routing request.', 'Route is null, verify that index router has parsed the information correctly.', __LINE__, $this->route->get_return_type(), Constants::get('default_error_code'));
			Tool::error($function, $error, false);
		}
	} 
	
	public function get_route() { return $this->route;}
}