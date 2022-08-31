<!-- PHP code to establish connection with the localserver -->
<?php

# DB Credentials 
$config = parse_ini_file("config.ini");

$mysqli = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

// SQL query to select data from database for jobs
$sql = " SELECT * FROM jobs ORDER BY job_identifier ASC ";
$result = $mysqli->query($sql);
$mysqli->close();
?>
<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tradie Job Details</title>
    <!-- CSS FOR STYLING THE PAGE -->
    <style>
		body{
				font-family:calibri;
				background-color: #efefef;
		}
		header{
				height:200px;
		}
		footer{
				height:200px;
				margin-top:30px;
		}	

		#myInput {
			background-image: url(https://www.w3schools.com/css/searchicon.png);
			background-position: 10px 12px;
			background-repeat: no-repeat;
			width: 390px;
			font-size: 16px;
			padding: 12px 20px 12px 40px;
			border: 1px solid #ddd;
			margin-bottom: 12px;
			display: inline-block;
			margin: 20px auto;
			border-radius: 5px;
		}
		
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
            border-collapse:collapse;
        }

        h1 {
            text-align: center;
            color: #006600;
            font-size: xx-large;
            font-family: 'Gill Sans', 'Gill Sans MT',
            ' Calibri', 'Trebuchet MS', 'sans-serif';
        }

        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }

        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        td {
            font-weight: lighter;
        }
    </style>
</head>

<body>
	<header>
			<img style="width:100%; height:200px;" src="header.jpg">
	</header>
    <section>
        <h1>TRADIE JOBS Details</h1>
		<div style="width:450px; margin:0 auto;">
		<input type="text" id="myInput" onkeyup="mySearchFunction()" placeholder="Search for job identifier.." title="Type in a name">
		<br>
		<button id="sortJob" style="padding: 7px 15px; font-size:16px; margin-left:40px;background: #91d4ca;border-radius: 5px;border: 2px solid #222;" onclick="sortTable(this.id)">Sort Jobs</button>
		<button id="sortStatus" style="padding: 7px 15px; font-size:16px; margin-left:10px;background: #91d4ca;border-radius: 5px;border: 2px solid #222;" onclick="sortTable(this.id)">Sort Status</button>
		<button id="sortDate" style="padding: 7px 15px; font-size:16px; margin-left:10px;background: #91d4ca;border-radius: 5px;border: 2px solid #222;" onclick="sortTable(this.id)">Sort Date</button>		
		</div>
		<!-- TABLE CONSTRUCTION -->
		<br>
       <table id="myTable">
            <tr>
                <th style="background: #dae29b;">Unique job identifier</th>
                <th aria-sort="ascending" style="background: #dae29b;">Status</th>
                                <th style="background: #dae29b;">Creation Date Time</th>
                                <!-- <th>Client Name</th>
                                <th>Client Email</th>
                                <th>Client Contact</th>
                                <th>Notes</th> -->
            </tr>
            <!-- PHP CODE TO FETCH DATA FROM ROWS -->
            <?php
                // LOOP TILL END OF DATA
				echo $rows;
				
                while($rows=$result->fetch_assoc())
                {

            ?>
            <tr>
                <!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->

				<?php

				if( empty(session_id()) && !headers_sent()){
					session_start();
				}
				$_SESSION['job_identifier'] = $rows['job_identifier'];

				?>
                <td><a href="notes.php?<?php echo $_SESSION['job_identifier'];?>"><?php echo $rows['job_identifier'];?></a></td>

                <td><?php echo $rows['status'];?></td>
                <td><?php echo $rows['creation_datetime'];?></td>
				<!--<td><?php echo $rows['client_name'];?></td>
				<td><?php echo $rows['client_email'];?></td>
				<td><?php echo $rows['contact_details'];?></td> -->

				<!-- <td><a href="notes.php?<?php echo $_SESSION['job_identifier'];?>">View <?php echo $_SESSION['job_identifier'];?></a></td>
				<td><a href="notes.php?<?php echo $_SESSION['job_identifier'];?>">View</a></td> -->


            </tr>
            <?php
                }
            ?>
        </table>
    </section>
	<footer>
			<img style="width:100%; height:200px;" src="footer.jpg">
	</footer>
</body>

<script>

function mySearchFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function sortTable(id) {
  //alert(id);
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("myTable");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
	  if (id == "sortJob") {
		    x = rows[i].getElementsByTagName("TD")[0];
			y = rows[i + 1].getElementsByTagName("TD")[0];
	  } else if (id == "sortStatus") {
			x = rows[i].getElementsByTagName("TD")[1];
			y = rows[i + 1].getElementsByTagName("TD")[1];
	  } else {
			x = rows[i].getElementsByTagName("TD")[2];
			y = rows[i + 1].getElementsByTagName("TD")[2];
	  }

      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}

</script>

</html>




