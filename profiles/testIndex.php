<?php
require_once "pdo.php";
session_start();
if(isset($_SESSION['user_id'])):
$user_id_current = $_SESSION['user_id'];
endif;
?>
<!DOCTYPE html>
<html>
<head>
<title>Frank Juel Nielsen Resume Registry</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Frank Juel Nielsen's Resume Registry</h1>
<?php
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
if ( !isset($_SESSION["email"]) && !isset($_SESSION["pass"]) ) {
   echo("<p><a href='login.php'>Please log in</a></p>");
   echo('<table border="1">'."\n");
   $stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, email, headline,
      summary FROM profile");
   // if no rows
   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   if ( $row === false ) {
     echo("<p>No rows found</p>");
   } else {
     echo"<tr>
   					<th>Name</th>
   					<th>Headline</th>
   				</tr>";
   }
   $stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, email, headline,
      summary FROM profile");
   while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
       echo "<tr><td>";
       echo('<a href="view.php?profile_id='.$row['profile_id'].'">'
       .htmlentities($row['first_name'])." ".htmlentities($row['last_name']).'</a>');
       echo("</td><td>");
       echo(htmlentities($row['headline']));
       echo("</td></tr>\n");
   }

   // return;
   return;
 } else {

// if ( isset($_SESSION['error']) ) {
//     echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
//     unset($_SESSION['error']);
// }
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
echo("<p><a href='logout.php'>Logout</a></p>");
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, email, headline,
   summary FROM profile");
// if no rows
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
  echo("<p>No rows found</p>");
} else {
  echo"<tr>
         <th>Name</th>
         <th>Headline</th>
         <th>Action</th>
       </tr>";
}
$stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, email, headline,
   summary FROM profile ");


while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo('<a href="view.php?profile_id='.$row['profile_id'].'">'
    .htmlentities($row['first_name'])." ".htmlentities($row['last_name']).'</a>');
    echo("</td><td>");
    echo(htmlentities($row['headline']));
    echo("</td><td>");
    if($row['user_id'] == $user_id_current) {
    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
    echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    echo("</td></tr>\n");
  }
}

}
?>
</table>
<?php
echo("<p><a href='add.php'>Add New Entry</a></p>");
 ?>
</div>
</body>
</html>
