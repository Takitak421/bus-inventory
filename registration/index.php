<?php
include("includes/header_template.php");
include_once(__DIR__."/includes/db.php");
include(__DIR__."/includes/validate.php");


$hasSearchQuery = false;
$searchQuery = "";
$searchResults = [];
$type_of_operation = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
/* if(isset($_GET['search-it'])) {*/ 
  // set the page number if it isn't set.
  $page = 1;
  $results_per_page = 5;
  if (isset($_GET['page'])
  && isset($_GET['results'])
  && isset($_GET['search'])
  && isset($_GET['operation'])) {
    $page = validate_number($_GET['page']);
    $results_per_page = validate_number($_GET['results']);
    $type_of_operation = validate_string($_GET['operation']);
    $searchQuery = validate_string($_GET['search']);
    // fix the result if invalid
    if ($page == false) {
      $page = 1;
    }
    if ($results_per_page == false) {
      $results_per_page = 5;
    }
    /* if ($searchQuery == false) {
      $searchQuery = "";
    }*/
    if ($type_of_operation === false || $type_of_operation === "not-valid") {
      // just make the type of operation a wild card
      $type_of_operation = "%";
    }

  }
  $results = get_search_results($searchQuery, $page, $results_per_page, $type_of_operation);
  $pageCount = get_result_page_count($results_per_page, $searchQuery, $type_of_operation);
}
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container search-form">
    <form method='get' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
      <h1>Search</h1>
      <input type="text"
              class="hidden"
              id="page"
              name="page"
              value="<?php echo $page; ?>"
              >
      <input type="text"
              class="hidden"
              id="results"
              name="results"
              value="<?php echo $results_per_page; ?>"
              >
      <div class="form-group">
        <input type="text"
              class="form-control"
              id="search-name"
              name="search"
              placeholder="eg. Search anything"
              value="<?php echo $searchQuery; ?>"
              >
      </div>

      <!-- Type of Operation -->
      <label for="type-of-operation-select">Type of Operation</label>
      <select class="form-group form-control char-input fields-input" id="type-of-operation-select" name="operation">
        <option value="not-valid"<?php if (isset($type_of_operation) && $type_of_operation == "not-valid") { echo "selected"; }?>>Select</option>
        <option value="City Operation"<?php if (isset($type_of_operation) && $type_of_operation == "City Operation") { echo "selected"; }?>>City Operation</option>
        <option value="Provincial Operation"<?php if (isset($type_of_operation) && $type_of_operation == "Provincial Operation") { echo "selected"; }?>>Provincial Operation</option>
        <option value="Inter-provincial Operation"<?php if (isset($type_of_operation) && $type_of_operation == "Inter-provincial Operation") { echo "selected"; }?>>Inter-provincial Operation</option>
        <option value="P2P Provincial Operation"<?php if (isset($type_of_operation) && $type_of_operation == "P2P Provincial Operation") { echo "selected"; }?>>Point-to-point Provincial Operation</option>
        <option value="P2P Inter-provincial Operation"<?php if (isset($type_of_operation) && $type_of_operation == "P2P Inter-provincial Operation") { echo "selected"; }?>>Point-to-point Inter-provincial Operation</option>
        <option value="P2P City Operation"<?php if (isset($type_of_operation) && $type_of_operation == "P2P City Operation") { echo "selected"; }?>>Point-to-point City Operation</option>
        <option value="Private Operation"<?php if (isset($type_of_operation) && $type_of_operation == "Private Operation") { echo "selected"; }?>>Private Operation</option>
      </select>
   

       <!-- Results per page -->
      <label for="results-page-select">Results Per Page</label>
      <select class="form-group form-control char-input fields-input" id="results-page-select" name="results">
        <option value="5"<?php if (isset($results_per_page) && $results_per_page == "5") { echo "selected"; }?>>5</option>
        <option value="10"<?php if (isset($results_per_page) && $results_per_page == "10") { echo "selected"; }?>>10</option>
        <option value="20"<?php if (isset($results_per_page) && $results_per_page == "20") { echo "selected"; }?>>20</option>
        <option value="50"<?php if (isset($results_per_page) && $results_per_page == "50") { echo "selected"; }?>>50</option>
      </select>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Search</button>
    </form>
</div>
    <?php if ($results != []) { ?>
    <div class="show-bus">
      <?php
          foreach($results as $bus_result) {
            echo "<div class=\"form-check\" style=\"background: #879ec5; margin: 2rem; padding: 1.5rem; font-family: 'Trebuchet MS'; border-radius: 25px; box-shadow: -3px 16px 4px 2px #095a8a; color: #8e410a; width: 420px;\">";
            echo "<div class=\"bus-owner\" style=\"font-size: 16px; \">Company/Owner: <b>".$bus_result['owner']."</b></div>";
            echo "<div class=\"bus-number\" style=\"font-size: 16px; \">Bus/Fleet Number: <b>".$bus_result['bus_number']."</b></div>";
            echo "<div class=\"bus-builder\" style=\"font-size: 16px; \">Coachbuilder: <b>".$bus_result['builder']."</b></div>";
            echo "<div class=\"bus-model\" style=\"font-size: 16px; \">Body Model: <b>".$bus_result['model']."</b></div>";
            echo "<div class=\"bus-seat-config\" style=\"font-size: 16px; \">Seating Configuration: <b>".$bus_result['seating_configuration']."</b></div>";
            echo "<div class=\"bus-seat-cap\" style=\"font-size: 16px; \">Seating Capacity: <b>".$bus_result['seat_capacity']."</b></div>";
            echo "<div class=\"bus-class\" style=\"font-size: 16px; \">Fare Class: <b>".$bus_result['fare_class']."</b></div>";
            echo "<div class=\"bus-route\" style=\"font-size: 16px; \">Route: <b>".$bus_result['route']."</b></div>";
            echo "<div class=\"bus-type-of-operation\" style=\"font-size: 16px; \">Type of Operation: <b>".$bus_result['type_of_operation']."</b></div>";
            echo "</div>";
        }
      ?>

    </div>
    <?php } else if ($hasSearchQuery) { ?>
      <div class="alert alert-danger heylert" role="alert">
        <p>Sorry, no search results.</p>
      </div>
    <?php } else { ?>
      <div class="alert alert-warning heylert" role="alert">
        <p>Use the "search bar" to get results.</p>
      </div>
    <?php } ?>

    </div>

    </div>

    <!-- navigating page -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <?php for ($i = 1; $i <= $pageCount; $i++) { ?>

          <?php if ($i < $page + 5 && $i > $page - 5) { ?>
          
          <li class="page-item  <?php if ($i == $page) { echo "active"; } ?>">
            <a class="page-link" href="index.php?results=<?php echo $results_per_page; ?>&page=<?php echo $i?>&search=<?php echo $searchQuery?>&operation=<?php $type_of_operation; ?>">
            <?php echo $i?><br/>
            </a>
          </li>

          <?php } else if ($i == $pageCount) { ?>
          
          <li class="page-item  <?php if ($i == $page) { echo "active"; } ?>">
            <a class="page-link" href="index.php?results=<?php echo $results_per_page; ?>&page=<?php echo $i?>&search=<?php echo $searchQuery?>&operation=<?php $type_of_operation; ?>">
            Last
            </a>
          </li>
          
          <?php } else if ($i == 1) { ?>
          
          <li class="page-item  <?php if ($i == $page) { echo "active"; } ?>">
            <a class="page-link" href="index.php?results=<?php echo $results_per_page; ?>&page=<?php echo $i?>&search=<?php echo $searchQuery?>&operation=<?php $type_of_operation; ?>">
            First
            </a>
          </li>  
          <?php } ?>
        
        <?php } ?>
      </ul>
    </nav>
    </div>
</body>

</html>