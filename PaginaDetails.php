<?php
//connect to MySQL
$db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'animesite') or die(mysqli_error($db));

$variable_id = $_GET['anime_id'];
$variable = $_GET['orden'];

// function to generate ratings
function generate_ratings($rating) {
   
    for ($i = 0; $i < $rating; $i++) {
        $anime_rating .= '<img src="star.png" alt="star"/>';
    }
    return $anime_rating;
}



// coge el id del caracter de anime y imprime su fullname
function get_caracter($caracter_id) {

    global $db;

    $query = 'SELECT 
            caracter_fullname 
       FROM
           caracter
       WHERE
           caracter_id = ' . $caracter_id;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $caracter_fullname;
}

// take in the id of a lead actor and return his/her full name
function get_leadactor($anime_leadactor) {

    global $db;

    $query = 'SELECT
            caracter_fullname
        FROM
            caracter 
        WHERE
            caracter_id = ' . $anime_leadactor;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $caracter_fullname;
}

// take in the id of a movie type and return the meaningful textual
// description
function get_animetype($animetype_id) {

    global $db;

    $query = 'SELECT 
            animetype_label
       FROM
           animetype
       WHERE
           animetype_id = ' . $animetype_id;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    $row = mysqli_fetch_assoc($result);
    extract($row);

    return $animetype_label;
}

// function to calculate if a movie made a profit, loss or just broke even
function calculate_differences($takings, $cost) {

    $difference = $takings - $cost;

    if ($difference < 0) {     
        $color = 'red';
        $difference = '$' . abs($difference) . ' million';
    } elseif ($difference > 0) {
        $color ='green';
        $difference = '$' . $difference . ' million';
    } else {
        $color = 'blue';
        $difference = 'broke even';
    }

    return '<span style="color:' . $color . ';">' . $difference . '</span>';
}



// retrieve information
$query = 'SELECT 
        anime_name, anime_year, anime_director, anime_leadactor, anime_type, anime_running_time, anime_cost, anime_takings
    FROM
        anime
    WHERE
        anime_id = '. $variable_id;
    


$result = mysqli_query($db, $query) or die(mysqli_error($db));

$row = mysqli_fetch_assoc($result);
extract($row);

$anime_name         = $anime_name;
$anime_director     = get_caracter($anime_director);
$anime_leadactor    = get_leadactor($anime_leadactor);
$anime_year         = $anime_year;
$anime_running_time = $anime_running_time .' mins';
$anime_takings      = $anime_takings . ' million';
$anime_cost         = $anime_cost . ' million';
$anime_health       = calculate_differences($anime_takings, $anime_cost);

// display the information
$table.= <<<ENDHTML
<html>
 <head>
  <title>Details and Reviews for: $anime_name</title>
  <style>
  .estiloFila table {
      border-collapse: collapse;
      border-spacing: 0px;
      width: 100%;
      border: 1px solid #ddd;
  }
  
  .estiloFila th, td {
      text-align:left;
      padding: 16px;
  }
  
  .estiloFila tr:nth-child(even) {
      background-color: #BDB76B;
  }
  </style>
 </head>
 <body>
  <div style="text-align: center;">
   <h2>$anime_name</h2>
   <h3><em>Details</em></h3>
   <table cellpadding="2" cellspacing="2"
    style="width: 70%; margin-left: auto; margin-right: auto;">
    <tr>
     <td><strong>Title</strong></strong></td>
     <td>$anime_name</td>
     <td><strong>Release Year</strong></strong></td>
     <td>$anime_year</td>
    </tr><tr>
     <td><strong>Anime Director</strong></td>
     <td>$anime_director</td>
     <td><strong>Cost</strong></td>
     <td>$anime_cost<td/>
    </tr><tr>
     <td><strong>Lead Actor</strong></td>
     <td>$anime_leadactor</td>
     <td><strong>Takings</strong></td>
     <td>$anime_takings<td/>
    </tr><tr>
     <td><strong>Running Time</strong></td>
     <td>$anime_running_time</td>
     <td><strong>Health</strong></td>
     <td>$anime_health<td/>
    </tr>
   </table>
ENDHTML;



// retrieve reviews for this movie
$query = 'SELECT
        review_anime_id, review_date, reviewer_name, review_comment, review_rating
    FROM
        reviews
    WHERE
        review_anime_id = ' . $variable_id . ' 
    ORDER BY '. $variable . ' ASC';



$result = mysqli_query($db, $query) or die(mysqli_error($db));

// display the reviews
$table.= <<<ENDHTML
   <h3><em>Reviews</em></h3>
   <table class="estiloFila" cellpadding='2' cellspacing='2'
    style="width: 90%; margin-left: auto; margin-right: auto;">
    <tr>
     <th style="width: 7em;"><a href="PaginaDetails.php?anime_id=$variable_id&orden=review_date">Date</a></th>
     <th style="width: 10em;"><a href="PaginaDetails.php?anime_id=$variable_id&orden=reviewer_name">Reviewer</a></th>
     <th><a href="PaginaDetails.php?anime_id=$variable_id&orden=review_comment">Comments</a></th>
     <th style="width: 5em;"><a href="PaginaDetails.php?anime_id=$variable_id&orden=review_rating">Rating</a></th>
    </tr>
ENDHTML;

while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['review_date'];
    $name = $row['reviewer_name'];
    $comment = $row['review_comment'];
    $rating = generate_ratings($row['review_rating']);
    $suma = $row['review_rating'];
    $cont++;
    $media += $suma;
    $resto = $cont%2;
    if($resto==0):
        $color= "#DAF7A6";
    else:
        $color= "#FFC300";
    endif;
   
    $table.= <<<ENDHTML
    <tr style="background-color:$color">
      <td style="vertical-align:top; text-align: center">$date</td>
      <td style="vertical-align:top">$name</td>
      <td style="vertical-align:top">$comment</td>
      <td style="vertical-align:top">$rating</td>
    </tr>
ENDHTML;
}

while ($row = mysqli_fetch_assoc($result)) {
    $date = $row['review_date'];
    $name = $row['reviewer_name'];
    $comment = $row['review_comment'];
    $rating = generate_ratings($row['review_rating']);

$table.= <<<ENDHTML
    <tr>
    <td style="vertical-align:top; text-align: center">$date</td>
    <td style="vertical-align:top">$name</td>
    <td style="vertical-align:top">$comment</td>
    <td style="vertical-align:top">$rating</td>
    </tr>
ENDHTML;
}

$media = ($media)/$cont;
$entero = intval($media);
$decimal = $media - $entero;
$rating = generate_ratings($entero);
$porcentaje = 0;

if($decimal>0){
    $porcentaje = $decimal*100;
    $porcentaje = intval(100-$porcentaje);
    $rating .= '<img src="star.png" alt="star" style="clip-path:inset(0%' . $porcentaje . '% 0% 0%);"/>';
}

$table .= <<<ENDHTML
<tr style="border: 2px solid black;">
   <td colspan= "3" style="vertical-align:top; text-align: center;">Media</td>
   <td style="vertical-align:top; text-align: center;">$rating</td>
</tr>
ENDHTML;

$table.= <<<ENDHTML
  </div>
 </body>
</html>
ENDHTML;

echo $table;
?>

'