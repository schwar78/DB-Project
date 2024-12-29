<?php
 $host = "localhost";
 $user = "root";
 $pw = "root";
 $db = "hafh";

 $con = new mysqli($host, $user, $pw, $db);

 $query = "SELECT managerid FROM manager";
 $result = $con->query($query);
 $rows = $result->num_rows;
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Manager Search</title>
  </head>

  <body>
    <h3> HAFH Managers </h3>
    <?php echo "There are $rows managers."; ?>

    <h4>Information for: </h4>
    <form method="get" action="manView.php">
      <select name="managerid">
	<?php
	 while ($managerid = $result->fetch_assoc()) {
	echo "<option>".$managerid['managerid'];
	  }
	  ?>
      </select>

      <input type="submit" value="Get Manager Information">
    </form>

    <p><br>
    <a href="addMan.php">Add a New Manager</a>

    <?php
     $result->free();
    $con->close(); ?>

  </body>
</html>