<?php
session_start();
if (isset($_SESSION['GWENITAKITAK']))
{
  
}
else
{
  header("Location:login2.php");
}

include(__DIR__."/../includes/header_template.php");
include_once(__DIR__."/../includes/db.php");
include(__DIR__."/../includes/validate.php");

$busNotFound = true;
$busListDetails = [];
// we need our service to be a get request.
$isPostRequest = false;
$isValidForm = false;
$successfulSave = false;
$bus_results = get_all_bus();

// everything in the get is the same as our "list.php"
if ($_SERVER['REQUEST_METHOD'] === "GET") {
  if (isset($_GET['id'])) {
    $bus_id = validate_number($_GET['id']);

    if ($bus_id != false) {
      $busListDetails = get_bus_by_id($bus_id);
    }
  }

// use a post to read the cat editing.
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $isPostRequest = true;
    $company_owner = "";
    $fleet_number = "";
    $coachbuilder = "";
    $bus_model = ""; 
    $seat_config = "";
    $seat_cap = "";
    $bus_fare_class = "";
    $route = "";
    $type_of_operation = "";
    $bus_id = null;
        
    // check if variables are set
     // check if variables are set
     if (isset($_POST['bus_owner'])
     && isset($_POST['bus_number'])
     && isset($_POST['coachbuilder'])
     && isset($_POST['body_model'])
     && isset($_POST['seating_config'])
     && isset($_POST['seating_capacity'])
     && isset($_POST['fare_class'])
     && isset($_POST['route'])
     && isset($_POST['operation'])
     && isset($_POST['busid'])) {
         // validate the form fields
         $company_owner = validate_string($_POST['bus_owner']);
         $fleet_number = validate_string($_POST['bus_number']);
         $coachbuilder = validate_string($_POST['coachbuilder']);
         $bus_model = validate_string($_POST['body_model']);
         $seat_config = validate_string($_POST['seating_config']);
         $seat_cap = validate_number($_POST['seating_capacity']);
         $bus_fare_class = validate_string($_POST['fare_class']);
         $route = validate_string($_POST['route']);
        $type_of_operation = validate_string($_POST['operation']);
         $bus_id = validate_number($_POST['busid']);

        // ensure that the fields in the form are valid
        if ($company_owner != false
        && $fleet_number != false
        && $coachbuilder != false
        && $bus_model != false
        && $seat_config != false
        && $seat_cap != false
        && $bus_fare_class != false
        && $route != false
        && $type_of_operation != false
        && $bus_id != false) {
            //the form is true is its' valid
            $isValidForm = true;
        }

    }

    // save the form if the information is valid/
    if ($isValidForm) {
      $successfulSave = update_bus_by_id($bus_id, $company_owner, $fleet_number, $coachbuilder, $bus_model, $seat_config, $seat_cap, $bus_fare_class, $route, $type_of_operation);
    }
}

?>
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/main.css">

</head>
<body>
<div class="logout-button"><a class="btn btn-lg btn-danger btn-block" href="logout.php">Logout</a></div>
	<div class="container centered-field" style="max-width: 400px;">
		<?php if($busNotFound && $busListDetails == [] && !$isPostRequest) {?>
      <div class ="alert alert-warning edit-first">
        <h2>Click the bus company (from below) to edit the fields.</h2>
      </div>
    <?php } else if (!$isPostRequest){ ?>
    <form class="form-char" method='post' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>'>
      <h1>Edit Bus Data</h1>
      <!-- id is hidden to avoid editing -->
      <input type="number"
             class="hidden"
             name="busid"
             value="<?php echo $bus_id?>"
             >
      <div class="bus-owner">
        <label for="bus-owner">Company/Owner</label>
        <input type="text"
              class="form-control char-inputfields-input"
              id="bus-owner"
              name="bus_owner"
              placeholder="Victory Liner"
              value="<?php echo $busListDetails['owner']?>"
              >
      </div>

      <!-- Bus/Fleet Number -->
      <div class="form-group">
        <label for="unit-number">Bus/Fleet Number</label>
        <input type="text"
              class="form-control char-inputfields-input"
              id="unit-number"
              name="bus_number"
              placeholder="e.g. 7101"
              value="<?php echo $busListDetails['bus_number']?>"
              >
      </div>

      <!-- Coachbuilder -->
      <div class="form-group">
        <label for="char-year-intro">Coachbuilder</label>
        <input type="text"
              class="form-control char-inputfields-input"
              id="coachbuilder"
              name="coachbuilder"
              placeholder="Santarosa Motor Works, Inc."
              value="<?php echo $busListDetails['builder']?>"
              >
      </div>

      <!-- Body Model -->
      <div class="form-group">
        <label for="body-model">Body Model</label>
        <input type="text"
              class="form-control char-inputfields-input"
              id="body-model"
              name="body_model"
              placeholder="MAN/Santarosa Modulo R39"
              value="<?php echo $busListDetails['model']?>"
              >
      </div>


      <!-- Seating Configuration -->
      <label for="configuration-select">Seating Configuration</label>
      <select class="form-group form-control char-input fields-input" id="configuration-select" name="seating_config"
      value="<?php echo $busListDetails['seating_configuration'];?>">
      <option value="no seating configuration"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "no seating configuration") { echo "selected"; }?>>No Seating Configuration</option>
        <option value="1x1"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "1x1") { echo "selected"; }?>>1x1</option>
        <option value="1x1x1"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "1x1x1") { echo "selected"; }?>>1x1x1</option>
        <option value="2x1"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "2x1") { echo "selected"; }?>>2x1</option>
        <option value="2x2"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "2x2") { echo "selected"; }?>>2x2</option>
        <option value="2x2 plus jumpseat"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "2x2 plus jumpseat") { echo "selected"; }?>>2+1x2</option>
        <option value="3x2"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "3x2") { echo "selected"; }?>>3x2</option>
        <option value="3x2 plus jumpseat"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "3x2 plus jumpseat") { echo "selected"; }?>>3+1x2</option>
        <option value="mixed configuration"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "mixed configuration") { echo "selected"; }?>>Mixed Seating Configuration</option>
        <option value="side seats configuration"<?php if (isset($busListDetails['seating_configuration']) && $busListDetails['seating_configuration'] == "side seats configuration") { echo "selected"; }?>>Side Seats Configuration</option>
      </select>

      <!-- Seating Capacity -->
      <div class="form-group">
        <label for="seat-cap">Seating Capacity</label>
        <input type="number"
              min="15"
              max="100"
              class="form-control char-inputfields-input"
              id="seat-cap"
              name="seating_capacity"
              placeholder="29"
              value="<?php echo $busListDetails['seat_capacity']?>"
              >
      </div>

       <!-- Fare Class -->
       <label for="fare-class-select">Fare Class</label>
      <select class="form-group form-control char-input fields-input" id="fare-class-select" name="fare_class">
        <option value="Cargo Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "Cargo Class") { echo "selected"; }?>>Cargo Class</option>
        <option value="Ordinary Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "Ordinary Class") { echo "selected"; }?>>Ordinary Class</option>
        <option value="Economy Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "Economy Class") { echo "selected"; }?>>Economy Class</option>
        <option value="Regular Class"<?php if (isset($busListDetails['seat_capacity']) && $busListDetails['fare_class'] == "Regular Class") { echo "selected"; }?>>Regular Class</option>
        <option value="Deluxe Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "Deluxe Class") { echo "selected"; }?>>Deluxe Class</option>
        <option value="First Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "First Class") { echo "selected"; }?>>First Class</option>
        <option value="Mixed Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "Mixed Class") { echo "selected"; }?>>Mixed Class</option>
        <option value="Tourist Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "Tourist Class") { echo "selected"; }?>>Tourist Class</option>
        <option value="Shuttle Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "Shuttle Class") { echo "selected"; }?>>Shuttle Class</option>
        <option value="Sleeper Class"<?php if (isset($busListDetails['fare_class']) && $busListDetails['fare_class'] == "Sleeper Class") { echo "selected"; }?>>Sleeper Class</option>
      </select>

       <!-- Route -->
       <div class="form-group">
        <label for="bus-route">Route</label>
        <input type="text"
              class="form-control char-inputfields-input"
              id="bus-route"
              name="route"
              placeholder="Kamias, Quezon City–Tuguegarao City, Cagayan"
              value="<?php echo $busListDetails['route']?>"
              >
      </div>

       <!-- Type of Operation -->
       <label for="type-of-operation-select">Type of Operation</label>
      <select class="form-group form-control char-input fields-input" id="type-of-operation-select" name="operation">
        <option value="City Operation"<?php if (isset($busListDetails['type_of_operation']) && $busListDetails['type_of_operation'] == "City Operation") { echo "selected"; }?>>City Operation</option>
        <option value="Provincial Operation"<?php if (isset($busListDetails['type_of_operation']) && $busListDetails['type_of_operation'] == "Provincial Operation") { echo "selected"; }?>>Provincial Operation</option>
        <option value="Inter-provincial Operation"<?php if (isset($busListDetails['type_of_operation']) && $busListDetails['type_of_operation'] == "Inter-provincial Operation") { echo "selected"; }?>>Inter-provincial Operation</option>
        <option value="P2P Provincial Operation"<?php if (isset($busListDetails['type_of_operation']) && $busListDetails['type_of_operation'] == "P2P Provincial Operation") { echo "selected"; }?>>Point-to-point Provincial Operation</option>
        <option value="P2P Inter-provincial Operation"<?php if (isset($busListDetails['type_of_operation']) && $busListDetails['type_of_operation'] == "P2P Inter-provincial Operation") { echo "selected"; }?>>Point-to-point Inter-provincial Operation</option>
        <option value="P2P City Operation"<?php if (isset($busListDetails['type_of_operation']) && $busListDetails['type_of_operation'] == "P2P City Operation") { echo "selected"; }?>>Point-to-point City Operation</option>
        <option value="Private Operation"<?php if (isset($busListDetails['type_of_operation']) && $busListDetails['type_of_operation'] == "Private Operation") { echo "selected"; }?>>Private Operation</option>
      </select>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
      <a class="btn btn-lg btn-danger btn-block" href="delete.php?id=<?php echo $bus_id;?>">DELETE</a>
    </form>
  
    <?php } else { ?>
    <!-- This will be the post request -->

    <div>
  

      <?php if ($successfulSave) {
        echo "<div class=\"heylert alert alert-success\" role=\"alert\">";
         echo "Information successfully saved!";
        echo "</div>";
      } else {
        echo "<div class=\"heylert alert alert-danger\" role=\"alert\">";
          echo "Nothing has been changed in your edited input. Please try again.";
        echo "</div>";
      }?>
    </div>
    <?php }?>

  </div>

    <div class="show-char-list">
      <div class="show-char-name">
        <h1>List of Company</h1>
        <!-- selecting from dropbox -->
        <!-- <select name="bus_owner"> 
          </*?php foreach ($bus_results as $bus_data) { 
            echo "<option value=\"" if isset(.$bus_data['bus_id']). && .$bus_data['bus_id']. == "$bus_id") { "selected"; })."\">".$bus_data['owner']."</option>";
          }?>\
        </select>  -->

        <!-- by clicking the link -->
         <?php foreach ($bus_results as $bus_data)
         {
           echo "<a href=\"edit.php?id=".$bus_data['bus_id']."\">• ".$bus_data['owner']."<br></a>"; 
        } ?>  
       
   
      </div>
    </div>
</body>

</html>