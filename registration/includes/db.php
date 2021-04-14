<?php 
include_once(__DIR__."/db_config.php");


// This is important in order to change the links when navigating
define("THIS_URL", "http://rbondoc3.dmitstudent.ca/dmit2025/registration/");

$db = mysqli_connect($server, $username, $password, $database) or die(mysqli_connect_error($db));
// Check connection
$error = null;
if (mysqli_connect_errno()) {
  $error = "Failed to connect to MySQL: " .mysqli_connect_errno();
}

//This stops SQL Injection in POST vars
foreach ($_POST as $key => $value) { 
	$_POST[$key] = mysqli_real_escape_string($db, $value); 
} 

//This stops SQL Injection in GET vars 
foreach ($_GET as $key => $value) { 
	$_GET[$key] = mysqli_real_escape_string($db, $value); 
}



// define("APP_NAME", "Registration");



// for inserting a new entry
 function insert_new_bus($company_owner, $fleet_number, $coachbuilder, $bus_model, $seat_config, $seat_cap, $bus_fare_class, $route, $type_of_operation) {
	global $db;
	$query = "INSERT INTO bus_inventory (owner, bus_number, builder, model, seating_configuration, seat_capacity, fare_class, route, type_of_operation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_prepare($db, $query);
	/* bind variables to prepared statement */

	mysqli_stmt_bind_param($stmt, 'sssssisss', $company_owner, $fleet_number, $coachbuilder, $bus_model, $seat_config, $seat_cap, $bus_fare_class, $route, $type_of_operation);
	// execute the statement.
	mysqli_stmt_execute($stmt);

	// ensure that we matched a row successfully
	// and the statement affected a row.
	if (mysqli_stmt_affected_rows($stmt) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
} 

// update query - update the data information
function update_bus_by_id($id, $company_owner, $fleet_number, $coachbuilder, $bus_model, $seat_config, $seat_cap, $bus_fare_class, $route, $type_of_operation) {
	global $db;
	$query = "UPDATE bus_inventory SET owner = ?, bus_number = ?, builder = ?, model = ?, seating_configuration = ?, seat_capacity = ?, fare_class = ?, route = ?, type_of_operation = ? WHERE bus_id = ?";
	$stmt = mysqli_prepare($db, $query);
	/* bind variables to prepared statement */
	mysqli_stmt_bind_param($stmt, 'sssssisssi', $company_owner, $fleet_number, $coachbuilder, $bus_model, $seat_config, $seat_cap, $bus_fare_class, $route, $type_of_operation, $id);
	// execute the statement.
	mysqli_stmt_execute($stmt);

	// ensure that we matched a row successfully
	// and the statement affected a row.
	if (mysqli_stmt_affected_rows($stmt) > 0) {
        return true;
    } else {
    	return false;
    }
}

// delete query - removing the data information
function delete_bus_by_id($id)
{
	global $db;
	$query = "DELETE FROM bus_inventory WHERE bus_id = ?";
	$stmt = mysqli_prepare($db, $query);
	/* bind variables to prepared statement
	if you want to take a look at the types go to the following
	link: https://www.php.net/manual/en/mysqli-stmt.bind-param.php
	we're going to bind with 'ss' because we want two strings
     */
	mysqli_stmt_bind_param($stmt, 'i', $id);
	// execute the statement.
	mysqli_stmt_execute($stmt);

	// ensure that we matched a row successfully
	// and the statement affected a row.
	if (mysqli_stmt_affected_rows($stmt) > 0) {
        return true;
    } else {
    	return false;
    }
}

// show the results when you edit
function get_all_bus()
{
	global $db;
	$query = "SELECT owner, bus_number, builder, model, seating_configuration, seat_capacity, fare_class, route, type_of_operation, bus_id from bus_inventory";

	// prepare the query.
	$stmt = mysqli_prepare($db, $query);
	if ($stmt)
	{
		// execute the query
		mysqli_stmt_execute($stmt);

		// bind the result of the executed query.
		mysqli_stmt_bind_result($stmt, $company_owner, $fleet_number, $coachbuilder, $bus_model, $seat_config, $seat_cap, $bus_fare_class, $route, $type_of_operation, $id);

		// fetch the values
		$result = [];
		while (mysqli_stmt_fetch($stmt)) {
			array_push($result, 
				[
					'owner' => $company_owner,
					'bus_number' => $fleet_number,
					'builder' => $coachbuilder,
					'model' => $bus_model,
					'seating_configuration' => $seat_config,
					'seat_capacity' => $seat_cap,
					'fare_class' => $bus_fare_class,
					'route' => $route,
					'type_of_operation' => $type_of_operation,
					'bus_id' => $id
				]
			);
		}
		mysqli_stmt_close($stmt);
		return $result;
	}
	else
	{
		//this is if the query has failed.
		return false;
	}
} 

// select query
function get_bus_by_id($id) {
	global $db;
	$query = "SELECT owner, bus_number, builder, model, seating_configuration, seat_capacity, fare_class, route, type_of_operation FROM bus_inventory WHERE bus_id = ?";
	//prepare the query.
	$stmt = mysqli_prepare($db, $query);

	if ($stmt) {
	    /* bind variables to prepared statement
		if you want to take a look at the types go to the following
		link: https://www.php.net/manual/en/mysqli-stmt.bind-param.php
		we're going to bind with 'i' because we want an integar.
	     */
	  mysqli_stmt_bind_param($stmt, 'i', $id); //i

		// execute the query
		mysqli_stmt_execute($stmt);

		// bind the result of the executed query.
		mysqli_stmt_bind_result($stmt, $company_owner, $fleet_number, $coachbuilder, $bus_model, $seat_config, $seat_cap, $bus_fare_class, $route, $type_of_operation);

		// fetch the values
		$result = [];
		while (mysqli_stmt_fetch($stmt)) {
			$result = [
				'owner' => $company_owner,
				'bus_number' => $fleet_number,
				'builder' => $coachbuilder,
				'model' => $bus_model,
				'seating_configuration' => $seat_config,
				'seat_capacity' => $seat_cap,
				'fare_class' => $bus_fare_class,
				'route' => $route,
				'type_of_operation' => $type_of_operation
			];
		}
		mysqli_stmt_close($stmt);
		return $result;

	} else {
		//this is if the query has failed.
		return false;
	}

}

/* Here, for search, we must apply the pagination */

// to get the search result that you inputed
function get_search_results($searchQuery, $page, $results_per_page = 5, $type_of_operation = "%"){
	global $db;
	$query = "SELECT bus_id, owner, bus_number, builder, model, seating_configuration, seat_capacity, fare_class, route, type_of_operation FROM bus_inventory WHERE (owner LIKE ? OR builder LIKE ? OR model LIKE ? OR fare_class LIKE ? OR route LIKE ?) AND type_of_operation LIKE ? ORDER BY bus_id LIMIT ?, ?";
	//prepare the query.
	$stmt = mysqli_prepare($db, $query);
	if ($stmt) {
		// get the starting row
		$starting_row = ($page - 1)* $results_per_page;
		$searchValue = "%".$searchQuery."%";

		mysqli_stmt_bind_param($stmt, 'ssssssss', 
			$searchValue,
			$searchValue,
			$searchValue,
			$searchValue,
			$searchValue,
			$type_of_operation,
			$starting_row,
			$results_per_page);
		// execute the query
		mysqli_stmt_execute($stmt);

		// bind the result of the executed query.
		mysqli_stmt_bind_result(
			$stmt,
			$id,
			$company_owner,
			$fleet_number,
			$coachbuilder,
			$bus_model,
			$seat_config,
			$seat_cap,
			$bus_fare_class,
			$route,
			$type_of_operation,
		);

		// fetch the values
		$result = [];
		while (mysqli_stmt_fetch($stmt)) {
			array_push($result, 
				[
					'bus_id' => $id,
					'owner' => $company_owner,
					'bus_number' => $fleet_number,
					'builder' => $coachbuilder,
					'model' => $bus_model,
					'seating_configuration' => $seat_config,
					'seat_capacity' => $seat_cap,
					'fare_class' => $bus_fare_class,
					'route' => $route,
					'type_of_operation' => $type_of_operation,
				]
			);
		}
		mysqli_stmt_close($stmt);
		return $result;

	}
	else {
		//this is if the query has failed.
		return false;
	}
} // end get_search results

// result for pagination
function get_result_page_count($results_per_page, $searchQuery = "", $type_of_operation = "%") {
	global $db;
	// Check if we're doing for all pages or search pages.
	if ($searchQuery != ""){

		$query = "SELECT count(*) FROM bus_inventory owner WHERE (owner LIKE ? OR builder LIKE ? OR model LIKE ? OR fare_class LIKE ? OR route LIKE ?) AND type_of_operation LIKE ?";
	} else {
		$query = "SELECT count(*) FROM bus_inventory owner";
	}

	//prepare the query.
	$stmt = mysqli_prepare($db, $query);
	if ($stmt) {

		if ($searchQuery != ""){
			$searchValue = "%".$searchQuery."%";
			mysqli_stmt_bind_param($stmt, 'ssssss',
			$searchValue,
			$searchValue,
			$searchValue,
			$searchValue,
			$searchValue,
			$type_of_operation);
		}

		// execute the query
		mysqli_stmt_execute($stmt);

		// bind the result of the executed query.
		mysqli_stmt_bind_result($stmt,$count);

		// fetch the number of rows.
		$result = [];
		while (mysqli_stmt_fetch($stmt)) {
			$rowCount = $count;
		}
		// we're going to divide the row count by the results per page, to get the total
		// number of pages, we're going to use ceil as well to get the full count.

		return ceil($rowCount / $results_per_page);
	} else {
		return 0;
	}
}

// all results for pagination
/* function get_all_results_bus($page, $results_per_page) {
	global $db;
	$query = "SELECT owner, bus_number, builder, model, seating_configuration, seat_capacity, fare_class, route, type_of_operation, bus_id from bus_inventory FROM child_care ORDER BY bus_id LIMIT ?, ?";
	//prepare the query.
	$stmt = mysqli_prepare($db, $query);
	if ($stmt) {
		// get the starting row becaus
		$starting_row = ($page - 1)* $results_per_page;

		mysqli_stmt_bind_param($stmt, 'ss', $starting_row, $results_per_page);
		// execute the query
		mysqli_stmt_execute($stmt);

		// bind the result of the executed query.
		mysqli_stmt_bind_result($stmt,
		$id,
		$company_owner,
		$fleet_number,
		$coachbuilder,
		$bus_model,
		$seat_config,
		$seat_cap,
		$bus_fare_class,
		$route,
		$type_of_operation
		);

		// fetch the values
		$result = [];
		while (mysqli_stmt_fetch($stmt)) {
			array_push($result, 
				[
					'bus_id' => $id,
					'owner' => $company_owner,
					'bus_number' => $fleet_number,
					'builder' => $coachbuilder,
					'model' => $bus_model,
					'seating_configuration' => $seat_config,
					'seat_capacity' => $seat_cap,
					'fare_class' => $bus_fare_class,
					'route' => $route,
					'type_of_operation' => $type_of_operation
				]
			);
		}
		mysqli_stmt_close($stmt);
		return $result;

	} else {
		//this is if the query has failed.
		return false;
	}
} */