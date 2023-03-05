<?php
// Database credentials
$host = 'localhost:3306';
$username = 'root';
$password = '';
$dbname = 'sailor_db';

// Connect to the database

$conn = mysqli_connect($host, $username, $password);
if(! $conn ) {
    die('Could not connect: ' . mysqli_connect_error());
}

echo 'Connected successfully<br/>';

$sql = 'CREATE Database sailor_db';
if(mysqli_query( $conn,$sql)) {
    echo "Database mydb created successfully.";
}
else {
    echo "Sorry, database creation failed ".mysqli_error($conn);
}



// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to create the boats table
$sql_create_boats_table = "CREATE TABLE `boats` (
  `bid` int(11) NOT NULL,
  `bname` varchar(32) DEFAULT NULL,
  `color` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

// Execute the create table query
if (mysqli_query($conn, $sql_create_boats_table)) {
    echo "Table boats created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

// SQL query to insert data into the boats table
$sql_insert_boats_data = "INSERT INTO `boats` (`bid`, `bname`, `color`) VALUES
(101, 'Interlake', 'blue'),
(102, 'Interlake', 'red'),
(103, 'Clipper', 'green'),
(104, 'Marine', 'red');";

// Execute the insert data query
if (mysqli_query($conn, $sql_insert_boats_data)) {
    echo "Data inserted successfully<br>";
} else {
    echo "Error inserting data: " . mysqli_error($conn) . "<br>";
}


// SQL query to create the reserves table
$sql_create_reserves_table = "CREATE TABLE `reserves` (
    `sid` int(11) NOT NULL,
    `bid` int(11) NOT NULL,
    `day` datetime NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
  
  // Execute the create table query
  if (mysqli_query($conn, $sql_create_reserves_table)) {
      echo "Table boats created successfully<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn) . "<br>";
  }


// SQL query to insert data into the reserves table
$sql_insert_reserves_data = "INSERT INTO `reserves` (`sid`, `bid`, `day`) VALUES
(22, 101, '1998-10-10 22:49:02'),
(22, 102, '1998-10-10 22:49:02'),
(22, 103, '0000-00-00 00:00:00'),
(22, 103, '1998-10-08 22:49:02'),
(22, 104, '0000-00-00 00:00:00'),
(22, 104, '1998-07-10 22:49:02'),
(31, 102, '0000-00-00 00:00:00'),
(31, 102, '1998-11-10 22:49:02'),
(31, 103, '0000-00-00 00:00:00'),
(31, 103, '1998-11-06 22:49:02'),
(31, 104, '0000-00-00 00:00:00'),
(31, 104, '1998-11-12 22:49:02'),
(64, 101, '0000-00-00 00:00:00'),
(64, 101, '1998-09-05 22:49:02'),
(64, 102, '0000-00-00 00:00:00'),
(64, 102, '1998-09-08 22:49:02'),
(74, 103, '0000-00-00 00:00:00'),
(74, 103, '1998-09-08 22:49:02');";


// Execute the insert data query
if (mysqli_query($conn, $sql_insert_reserves_data)) {
    echo "Data inserted successfully<br>";
} else {
    echo "Error inserting data: " . mysqli_error($conn) . "<br>";
}

// SQL query to create the sailors table
$sql_create_sailors_table = "CREATE TABLE `sailors` (
    `sid` int(11) NOT NULL,
    `sname` varchar(32) DEFAULT NULL,
    `rating` int(11) DEFAULT NULL,
    `age` double DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
  
  // Execute the create table query
  if (mysqli_query($conn, $sql_create_sailors_table)) {
      echo "Table sailors created successfully<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn) . "<br>";
  }
  
  // SQL query to insert data into the sailors table
  $sql_insert_sailors_data = "INSERT INTO `sailors` (`sid`, `sname`, `rating`, `age`) VALUES
  (22, 'Dustin', 7, 45),
  (29, 'Brutus', 1, 33),
  (31, 'Lubber', 8, 55.5),
  (32, 'Andy', 8, 25.5),
  (58, 'Rusty', 10, 35),
  (64, 'Horatio', 7, 35),
  (71, 'Zorba', 10, 16),
  (74, 'Horatio', 9, 35),
  (85, 'Art', 3, 25.5),
  (95, 'Bob', 3, 63.5)";
  
  // Execute the insert data query
  if (mysqli_query($conn, $sql_insert_sailors_data)) {
      echo "Data inserted successfully<br>";
  } else {
      echo "Error inserting data: " . mysqli_error($conn) . "<br>";
  }
  
//-- Question 1:
//--Find the names of sailors who have reserved a red or green boat

$sql1 = "SELECT S.sname
        FROM Sailors S, Reserves R, Boats B 
        WHERE S.sid = R.sid AND R.bid = B.bid
              AND (B.color = 'red' OR B.color = 'green')";

// Execute query and fetch results
$result1 = $conn->query($sql1);

// Output results
if ($result1->num_rows > 0) {
    echo "The names of sailors who have reserved a red or green boat are:<br>";
    while($row = $result1->fetch_assoc()) {
        echo $row["sname"]. "<br>";
    }
} else {
    echo "No results found";
}


// Question 2
//Find the names of sailors who have reserved both a red and a green boat:
$sql2 = "SELECT S.sname
        FROM Sailors S, Boats B1, Reserves R1, Boats B2, Reserves R2
        WHERE S.sid=R1.sid AND R1.bid=B1.bid
        AND S.sid=R2.sid AND R2.bid=B2.bid
        AND (B1.color='red' AND B2.color='green')";

$result2 = mysqli_query($conn, $sql2);

// Checking if any rows were returned
if (mysqli_num_rows($result2) > 0) {
  // Outputting each row of data
  while($row = mysqli_fetch_assoc($result2)) {
    echo "Sailor Name: " . $row["sname"] . "<br>";
  }
} else {
  echo "No results found.";
}

//--Question 3
//--Find the names of sailors who have reserved boat 103
$sql3 = "SELECT S.sname 
        FROM Sailors S, Reserves R 
        WHERE S.sid = R.sid AND R.bid = 103";

$result3 = mysqli_query($conn, $sql3);

if (mysqli_num_rows($result3) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result3)) {
    echo "Sailor Name: " . $row["sname"] . "<br>";
  }
} else {
  echo "0 results";
}

//--Question 4
//--Find the sailors with the highest rating
$sql4 = "SELECT S.sid, S.sname, S.rating 
        FROM Sailors S
        WHERE S.rating>=ALL(SELECT S2.rating FROM Sailors S2 )";

$result4 = mysqli_query($conn, $sql4);

if (mysqli_num_rows($result4) > 0) {
  // Output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "Sailor ID: " . $row["sid"] . " - Sailor Name: " . $row["sname"] . " - Rating: " . $row["rating"] . "<br>";
  }
} else {
  echo "0 results";
}


//Question 5
//Find the sailors who have reserved all boats.
$sql5 = "SELECT S.sname
FROM Sailors S
WHERE NOT EXISTS
(SELECT B.bid
FROM Boats B
WHERE NOT EXISTS ( SELECT R.bid
FROM Reserves R
WHERE R.bid=B.bid
AND R.sid=S.sid))";

$result5 = mysqli_query($conn, $sql5);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result5)) {
    echo "Sailor Name: " . $row["sname"] . "<br>";
  }
} else {
  echo "0 results";
}


//Question 6
//Find the name and age of the oldest sailor.
$sql6 = "SELECT S.sname, S.age
        FROM Sailors S
        WHERE S.age=(SELECT MAX(S2.age)
                     FROM Sailors S2 )";

$result6 = mysqli_query($conn, $sql6);

// Check if there are any rows returned
if (mysqli_num_rows($result6) > 0) {
  // Output data of each row
  while($row = mysqli_fetch_assoc($result6)) {
    echo "Sailor Name: " . $row["sname"]. " - Age: " . $row["age"]. "<br>";
  }
} else {
  echo "0 results";
}

//Question 7
//Find the average of sailors for each rating level that has at least two sailors
$sql7 = "SELECT S.rating, AVG(S.age) AS avgage
        FROM Sailors S
        GROUP BY S.rating
        HAVING COUNT(*) > 1;";
$result7 = mysqli_query($conn, $sql7);

// display results
if (mysqli_num_rows($result7) > 0) {
  while($row = mysqli_fetch_assoc($result7)) {
    echo "Rating: " . $row["rating"] . " | Average Age: " . $row["avgage"] . "<br>";
  }
} else {
  echo "No results found.";
}

//Question 8
//For each red boat, find the number of reservations for this boat
$sql8 = "SELECT B.bid, COUNT (*) AS scount
        FROM Sailors S, Boats B, Reserves R 
        WHERE S.sid=R.sid AND R.bid=B.bid AND B.color='red'
        GROUP BY B.bid";
$result8 = mysqli_query($conn, $sql8);
if (mysqli_num_rows($result8) > 0) {
    while ($row = mysqli_fetch_assoc($result8)) {
        echo "Boat ID: " . $row["bid"] . " - Reservation Count: " . $row["scount"] . "<br>";
    }
} else {
    echo "No results found.";
}


// Close the database connection
mysqli_close($conn);
?>
