<?php
$query = $_GET['q'];
if (!empty($query)):

include_once('stanford.person.php');

$directory = new StanfordDirectory();
$sunetids = explode(',', $query);
$results = array();

foreach ($sunetids as $sunetid) {
  $person = new StanfordPerson($sunetid, $directory);
  if (is_null($person->get_email())) continue;
  $results[] = array(
    'sunetid' => $person->get_sunetid(),
    'email' => $person->get_email(),
    'first_name' => $person->get_first_name(),
    'last_name' => $person->get_last_name(),
    'full_name' => $person->get_full_name(),
    'middle_name' => $person->get_middle_name(),
    'home_phone' => $person->get_home_phone(),
    'mobile_phone' => $person->get_mobile_phone(),
    'work_phone' => $person->get_work_phone(),
    'pager_number' => $person->get_pager_number(),
    'pager_email' => $person->get_pager_email(),
    'home_postal_address' => $person->get_home_postal_address(),
    'work_postal_address' => $person->get_work_postal_address(),
    'permanent_postal_address' => $person->get_permanent_postal_address(),
    'job_title' => $person->get_job_title(),
    'primary_affiliation' => $person->get_primary_affiliation(),
    'is_a_student' => $person->is_a_student(),
    'is_faculty' => $person->is_faculty(),
    'is_staff' => $person->is_staff(),
    'is_affiliate' => $person->is_affiliate(),
  );
}

$directory->disconnect();

$output = array(
  'count' => sizeof($results),
  'results' => $results,
);

$json_string = json_encode($output, JSON_PRETTY_PRINT);

header('Content-Type: application/json');
echo $json_string;

else: ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Stanford People Unofficial API</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href='//fonts.googleapis.com/css?family=Cinzel+Decorative|Hammersmith+One' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<style>
body {
  background-color: #555;
}

.container {
  position: relative;
  top: 50%;
  transform: translateY(-50%);
}

.box {
  padding: 40px;
  padding-bottom: 50px;
  background-color: #ECECEA;
  border-radius: 10px;
  text-align: center;
  box-shadow: 15px 15px 0px rgba(0, 0, 0, 0.5);
}

body, html {
  height: 100%;
  -webkit-transform-style: preserve-3d;
  -moz-transform-style: preserve-3d;
  transform-style: preserve-3d;
}

h1 span {
  font-family: 'Cinzel Decorative', serif;
  display: block;
  font-size: 2em;
}

h1 small {
  font-family: 'Hammersmith One', sans-serif;
  text-transform: uppercase;
}

label {
  font-family: 'Hammersmith One', sans-serif;
  color: #777;
  font-weight: normal;
  font-size: 1.2em;
}

h1 {
  margin-bottom: 30px;
}

.btn-black {
  background-color: #3B3738;
  color: #ccc;
}

.btn-black:hover {
  background-color: rgb(140, 21, 21);
  color: #fff;
}

input, label, button {
  margin-bottom: 20px !important;
}

input:focus {
  border-color: rgba(140, 21, 21, 0.8) !important;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(140, 21, 21, 0.6) !important;
  outline: 0 none !important;
}

</style>

</head>

<body>
<div class="container">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">

<div class="box">
<h1><span>Stanford People</span><small>unofficial API</small></h1>

<form>
<div class="row">
  <div class="col-sm-6 col-sm-offset-2">
  <input id="sunetids" class="form-control input-lg" placeholder="hennessy, sahami, poohbear">
  </div>
  <div class="col-sm-2">
  <button name="search" class="btn btn-black btn-lg">Search</button>
  </div>
</div>

  <label for="sunetids">SUNet IDs seperated by commas</label>
</form>

</div>

</div>
</div>
</div>

<script>
$(document).ready(function() {
  $('button[name=search]').click(function(e) {
    window.location.href = './' + $('input#sunetids').val().replace(' ', '');
    e.preventDefault();
  });
});
</script>
</body>
</html>
<?php endif; ?>
