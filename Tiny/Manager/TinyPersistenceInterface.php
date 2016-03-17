<?php

namespace Tiny\Manager;

use \Exception;

/**
 * Interface TinyPersistenceInterface
 * @package Tiny\Manager
 *
 * Interface for datas persistence operations.
 */

interface TinyPersistenceInterface {
	
	/**
	* @param String $table the table where to launch query
	* @param Array $filter parameters for the query
	*
	* Select all elements in $table which match with $filter
	*/
	function get($table, $filter);
	
	/**
	* @param String $table the table where to launch query
	*
	* Select all elements in $table
	*/
	function getAll($table);
	
	/**
	* @param String $table the table where to launch query
	* @param Array $values parameters for the query
	*
	* Insert an element in $table with $values
	*/
	function post($table, $values);
	
	/**
	* @param String $table the table where to launch query
	* @param Array $values parameters for the query
	* @param Array $filter parameters for the query
	*
	* Update an element in $table with $values which match with $filter
	*/
	function put($table, $values, $filter);
	
	/**
	* @param String $table the table where to launch query
	* @param Array $values parameters for the query
	*
	* Update all elements in $table with $values
	*/
	function putAll($table, $values);
	
	/**
	* @param String $table the table where to launch query
	* @param Array $filter parameters for the query
	*
	* Delete all elements in $table which match with $filter
	*/
	function delete($table, $filter);
	
	/**
	* @param String $table the table where to launch query
	*
	* Delete all elements in $table
	*/
	function deleteAll($table);

	/**
	* @param Object $connection connection to close
	*
	* Close the connection
	*/
	function close($connection);
}