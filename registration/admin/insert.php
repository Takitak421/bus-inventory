<?php
session_start();
if (isset($_SESSION['GWENITAKITAK']))
{
  
}
else
{
  header("Location:login.php");
}

include(__DIR__."/../includes/header_template.php");
include_once(__DIR__."/../includes/db.php");
include(__DIR__."/../includes/validate.php");

$isPostRequest = false;
$isValidForm = false;
$successfulSave = false;
$hasFieldErrors = false;
/* if ($_SERVER['REQUEST_METHOD'] == "POST") */
if(isset($_POST['submit'])) {
    $isPostRequest = true;
    $rbid = null;
    $company_owner = "";
    $fleet_number = "";
    $coachbuilder = "";
    $bus_model = ""; 
    $seat_config = "";
    $seat_cap = "";
    $bus_fare_class = "";
    $route = "";
    $type_of_operation = "";

    // error fields
    $errorMessageOwner = "";
    $errorMessageOwnerLengthName = "";
    $errorMessageFleetNo = "";
    $errorMessageBuilder = "";
    $errorMessageBusModel = "";
    $errorMessageDescription = "";
    $errorMessageSeatCapacity = "";
    $errorMessageRoute = "";

    // check if variables are set
    if (isset($_POST['bus_owner'])
    && isset($_POST['bus_number'])
    && isset($_POST['coachbuilder'])
    && isset($_POST['body_model'])
    && isset($_POST['seating_config'])
    && isset($_POST['seating_capacity'])
    && isset($_POST['fare_class'])
    && isset($_POST['route'])
    && isset($_POST['operation'])) {
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

        // ensure that the fields in the form are valid
        if ($company_owner != false
        && $fleet_number != false
        && $coachbuilder != false
        && $bus_model != false
        && $seat_config != false
        && $seat_cap != false
        && $bus_fare_class != false
        && $route != false
        && $type_of_operation != false) {
            //the form is true is its' valid
            $isValidForm = true;
        }
      }
        // error if no company/owner indicated
        if ($company_owner == "") {
          $hasFieldErrors = true;
          $errorMessageOwner .= "Enter a/an company/owner name.";
        }
        // error if company name is less than 3
        if ((strlen($company_owner) < 3)) {
          $hasFieldErrors = true;
          $errorMessageOwnerLengthName .= "Must enter at least three characters.";
        }
        // error if no bus/fleet number indicated
        if ($fleet_number == "") {
          $hasFieldErrors = true;
          $errorMessageFleetNo .= "Enter a bus number. If not applicable, put 'N/A'.";
        }

        // error if no coachbuilder indicated
        if ($coachbuilder == "") {
          $hasFieldErrors = true;
          $errorMessageBuilder .= "Enter the coachbuilder.";
        }

         // error if no model indicated
         if ($bus_model == "") {
          $hasFieldErrors = true;
          $errorMessageBusModel .= "Enter the bus model.";
        }

        // error if no seating capacity indicated
        if ($seat_cap == "") {
          $hasFieldErrors = true;
          $errorMessageSeatCapacity .= "Must put the number of seating capacity.";
        }

        // error if no seating capacity indicated
        if ($route == "") {
          $hasFieldErrors = true;
          $errorMessageRoute .= "Enter the route. If no route, please put 'N/A'.";
        }
    }
    // save the form if the information is valid/
    if ($isValidForm)
    {
      $successfulSave = insert_new_bus($company_owner, $fleet_number, $coachbuilder, $bus_model, $seat_config, $seat_cap, $bus_fare_class, $route, $type_of_operation);
    }
    
  // } // end submit 

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
  <div class="container centered-field">
    <?php if (!$isPostRequest) { ?>
    <form class="form-char" method='post' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>'>
      <h1>Register a new unit</h1>
      <!-- Company/Owner -->
      <div class="bus-owner">
        <label for="bus-owner">Company/Owner</label>
        <input type="text"
              class="form-control char-inputfields-input"
              id="bus-owner"
              name="bus_owner"
              placeholder="Victory Liner"
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
              >
      </div>

      <!-- Seating Configuration -->
      <label for="configuration-select">Seating Configuration</label>
      <select class="form-group form-control char-input fields-input" id="configuration-select" name="seating_config">
        <option value="no seating configuration"<?php if (isset($seat_config) && $seat_config == "no seating configuration") { echo "selected"; }?>>No Seating Configuration</option>
        <option value="1x1"<?php if (isset($seat_config) && $seat_config == "1x1") { echo "selected"; }?>>1x1</option>
        <option value="1x1x1"<?php if (isset($seat_config) && $seat_config == "1x1x1") { echo "selected"; }?>>1x1x1</option>
        <option value="2x1"<?php if (isset($seat_config) &&$seat_config == "2x1") { echo "selected"; }?>>2x1</option>
        <option value="2x2"<?php if (isset($seat_config) &&$seat_config == "2x2") { echo "selected"; }?>>2x2</option>
        <option value="2x2 plus jumpseat"<?php if (isset($seat_config) && $seat_config == "2x2 plus jumpseat") { echo "selected"; }?>>2+1x2</option>
        <option value="3x2"<?php if (isset($seat_config) &&$seat_config == "3x2") { echo "selected"; }?>>3x2</option>
        <option value="3x2 plus jumpseat"<?php if (isset($seat_config) && $seat_config == "3x2 plus jumpseat") { echo "selected"; }?>>3+1x2</option>
        <option value="mixed configuration"<?php if (isset($seat_config) && $seat_config == "mixed configuration") { echo "selected"; }?>>Mixed Seating Configuration</option>
        <option value="side seats configuration"<?php if (isset($seat_config) && $seat_config == "side seats configuration") { echo "selected"; }?>>Side Seats Configuration</option>
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
              >
      </div>

      <!-- Fare Class -->
      <label for="fare-class-select">Fare Class</label>
      <select class="form-group form-control char-input fields-input" id="fare-class-select" name="fare_class">
        <option value="Cargo Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Cargo Class") { echo "selected"; }?>>Cargo Class</option>
        <option value="Ordinary Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Ordinary Class") { echo "selected"; }?>>Ordinary Class</option>
        <option value="Economy Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Economy Class") { echo "selected"; }?>>Economy Class</option>
        <option value="Regular Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Regular Class") { echo "selected"; }?>>Regular Class</option>
        <option value="Deluxe Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Deluxe Class") { echo "selected"; }?>>Deluxe Class</option>
        <option value="First Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "First Class") { echo "selected"; }?>>First Class</option>
        <option value="Mixed Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Mixed Class") { echo "selected"; }?>>Mixed Class</option>
        <option value="Tourist Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Tourist Class") { echo "selected"; }?>>Tourist Class</option>
        <option value="Shuttle Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Shuttle Class") { echo "selected"; }?>>Shuttle Class</option>
        <option value="Sleeper Class"<?php if (isset($bus_fare_class) && $bus_fare_class == "Sleeper Class") { echo "selected"; }?>>Sleeper Class</option>
      </select>

       <!-- Route -->
       <div class="form-group">
        <label for="bus-route">Route</label>
        <input type="text"
              class="form-control char-inputfields-input"
              id="bus-route"
              name="route"
              placeholder="Kamias, Quezon City–Tuguegarao City, Cagayan"
              >
      </div>

      <!-- Type of Operation -->
      <label for="type-of-operation-select">Type of Operation</label>
      <select class="form-group form-control char-input fields-input" id="type-of-operation-select" name="operation">
        <option value="City Operation"<?php if (isset($type_of_operation) && $type_of_operation == "City Operation") { echo "selected"; }?>>City Operation</option>
        <option value="Provincial Operation"<?php if (isset($type_of_operation) && $type_of_operation == "Provincial Operation") { echo "selected"; }?>>Provincial Operation</option>
        <option value="Inter-provincial Operation"<?php if (isset($type_of_operation) && $type_of_operation == "Inter-provincial Operation") { echo "selected"; }?>>Inter-provincial Operation</option>
        <option value="P2P Provincial Operation"<?php if (isset($type_of_operation) && $type_of_operation == "P2P Provincial Operation") { echo "selected"; }?>>Point-to-point Provincial Operation</option>
        <option value="P2P Inter-provincial Operation"<?php if (isset($type_of_operation) && $type_of_operation == "P2P Inter-provincial Operation") { echo "selected"; }?>>Point-to-point Inter-provincial Operation</option>
        <option value="P2P City Operation"<?php if (isset($type_of_operation) && $type_of_operation == "P2P City Operation") { echo "selected"; }?>>Point-to-point City Operation</option>
        <option value="Private Operation"<?php if (isset($type_of_operation) && $type_of_operation == "Private Operation") { echo "selected"; }?>>Private Operation</option>
      </select>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name='submit'>Register</button>
    </form>
 
    <!-- This will be the post request -->
    <div class= "error-field" style="background-color: pink;">
      
      <?php
             } if ($hasFieldErrors && $isPostRequest && !$successfulSave) { ?>
                <h2 style="text-align: center;
                            font-size: 21px;
                            font-family: Rockwell;
                            color: #9c1616;
                            width: 350px;
                            margin: 0 auto;">Sorry, your data is not successfully saved. Check the following errors below:</h2>
                <?php if($company_owner == "") { ?>
                <div class="heylert alert alert-danger" role="alert">
                  <?php echo $errorMessageOwner; ?>
                </div>
      <?php }
                 if (strlen($company_owner) < 3) { ?>
                <div class="heylert alert alert-danger" role="alert">
                  <?php echo $errorMessageOwnerLengthName; ?>
                </div>
      <?php    }
                if($fleet_number == "") { ?>
                <div class="heylert alert alert-danger" role="alert">
                  <?php echo $errorMessageFleetNo; ?>
                </div>
      <?php    }
                if ($coachbuilder == "") { ?>
                <div class="heylert alert alert-danger" role="alert">
                  <?php echo $errorMessageBuilder; ?>
                </div>  
      <?php    }
                if ($bus_model == "") { ?>
                <div class="heylert alert alert-danger" role="alert">
                  <?php echo $errorMessageBusModel; ?>
                </div>  
      <?php    }
                if ($seat_cap == "") { ?>
                <div class="heylert alert alert-danger" role="alert">
                  <?php echo $errorMessageSeatCapacity; ?>
                </div>  
      <?php    }
                if ($route == "") { ?>
                <div class="heylert alert alert-danger" role="alert">
                  <?php echo $errorMessageRoute; ?>
                </div>  
      <?php    }
              }
              else if ($successfulSave && !$hasFieldErrors && $isValidForm && $isPostRequest)
              { ?>
        <div class="heylert alert alert-success" role="alert">
          "New bus has been added to the list!"
        </div>
      <?php  } ?>
    </div>
  </div>
 
</body>

</html>