<!-- PHP code to establish connection with the localserver -->
<?php

$currentPageUrl = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
#echo "Current page URL " . $currentPageUrl;
list($url, $value) = explode("?", $currentPageUrl);
#echo $url;
#echo $value;

# DB Credentials 
$config = parse_ini_file("config.ini");

$mysqli = new mysqli($config['servername'], $config['username'],
                $config['password'], $config['dbname']);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

// SQL query to select data from jobs and notes

$sql = " SELECT jobs.job_identifier, jobs.client_name, jobs.client_email, jobs.contact_details, notes.notes_id, jobs.status, notes.description from jobs INNER JOIN notes ON notes.jobs_id=jobs.job_identifier where notes.jobs_id='$value' ; ";
$result = $mysqli->query($sql);
$mysqli->close();
?>
<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tradie Details</title>
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
	label{width: 160px;
       display: inline-block;}	
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
.flex-parent {
  display: flex;
}

.jc-center {
  justify-content: center;
}

button.margin-right {
  margin-right: 20px;
}

.center {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 20px; 
  color: #F00;
}
    
    </style>


<script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>  
<script type="text/javascript" language="javascript"> 
 
 function myDescriptionFocus(descId) {
  descId.style.background = "green";
}

function addNotesShow() {
      var x = document.getElementById("myDIV");
	  //alert(x);
	  //alert(x.style.display);
	  if (x.style.display == "none") {
		x.style.display = "block";
	  } else {
		x.style.display = "none";
	  }
}

function addNotesHide() {
      var x = document.getElementById("myDIV");
	  //alert(x);
	  //alert(x.style.display);
	  if (x.style.display == "block") {
		x.style.display = "none";
	  } else {
		x.style.display = "block";
	  }
	  
	  document.getElementById('descriptionId').value = ''
	  //document.getElementById('statusId').value = 'Select Status'
}

  function noteChanged(desc,noteId) {
	//alert(noteId);
	//alert(desc);
	//descId.style.background = "green";
	var retVal = confirm("Do you want to continue to update notes ?");
	if( retVal == true ) {
	  //document.write ("User wants to continue!");
			   
		  if (desc == "") {
			  //alert("Hi");
			document.getElementById("description").innerHTML = "";
			return;
		  } else {
			  
			$.ajax({            
			type:"POST",  
			url:"updateDB.php",  
			data:"description="+desc+'&note='+noteId,  
			success:function(data){  
				//alert(data);  
				document.getElementById("updateFields").innerHTML += data;

			}  
			  
			});
			
		  }
		  
	}
  
}

function statusFunction(jobId) {
	//alert(status);
	//alert(jobId);
	var status = document.getElementById("jobStatusId").value;
	//alert(status);
	//descId.style.background = "green";
	var retVal = confirm("Do you want to continue to update status ?");
	if( retVal == true ) {
	  //document.write ("User wants to continue!");
			   
		  if (status == "") {
			  //alert("Hi");
			document.getElementById("jobStatusId").innerHTML = "";
			return;
		  } else {
			  
			$.ajax({            
			type:"POST",  
			url:"updateStatus.php",  
			data:"statusVal="+status+'&jobIdVal='+jobId,  
			success:function(data){  
				//alert(data);  
				document.getElementById("updateFields").innerHTML += data;

			}  
			  
			});
			
		  }
	}
  
}

function createFunction() {
	//alert(status);
	//alert(jobId);
	var jobId = document.getElementById("jobId").value;
	var statusId = document.getElementById("statusId").value;
	var descriptionId = document.getElementById("descriptionId").value;
	//alert(jobId);
	//alert(statusId);
	//alert(descriptionId);
	//descId.style.background = "green";
	var retVal = confirm("Do you want to continue to update status ?");
	if( retVal == true ) {
		   
		  if (statusId == "") {
			  //alert("Hi");
			document.getElementById("descriptionId").innerHTML = "";
			return;
		  } else {
			  //alert('Hi');
			$.ajax({            
			type:"POST",  
			url:"createNotes.php",  
			data:"statusVal="+statusId+"&jobIdVal="+jobId+"&noteDescription="+descriptionId,
			success:function(data){
				//alert(data);  
				document.getElementById("addNoteMsg").innerHTML += data;
				

			}  
			  
			});
			
			$(document).ajaxStop(function(){
				window.location.reload();
			});
			
		  }
	}
  
}
  
 </script>
 
</head>

<body>
	<header>
			<img style="width:100%; height:200px;" src="header.jpg">
	</header>

	<div id="updateFields" style="color: blue; font-size: 18px; text-align:center; padding: 40px 20px 0px;"></div>
	<div id="addNoteMsg" style="color: blue; font-size: 18px; text-align:center; padding: 40px 20px 0px;"></div>
    <section>
        <h1>JOB <?php echo $value;?> Details</h1>
		 
        <!-- TABLE CONSTRUCTION -->
        <table>
            <tr>
				<th>Unique job identifier</th>
				<th>Status</th>
				<th>Client Name</th>
				<th>Client Email</th>
				<th>Client Contact</th>
				<th>Edit Notes</th>
				<!--<th>Action</th>-->
            </tr>
            <!-- PHP CODE TO FETCH DATA FROM ROWS -->
            <?php
                // LOOP TILL END OF DATA
				
				static $number = 0;
				
                while($rows=$result->fetch_assoc())
                {
					$number++;
					$rowcount = mysqli_num_rows( $result );
					//echo $number;
					//echo $rowcount;
				
				if( empty(session_id()) && !headers_sent()){
					session_start();
				}
			    $_SESSION['status'] = $rows['status'];
				$_SESSION['job_identifier'] = $rows['job_identifier'];
            ?>
            <tr>
                <!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->
                <td><?php echo $rows['job_identifier'];?></td>
				
				<?php
						if ($number == $rowcount) {  						
				?>
				  
				  <td>
				  <select id="jobStatusId" onchange="statusFunction('<?php echo $_SESSION['job_identifier'];?>')">				 
						<option value="Select Status" <?php if($_SESSION['status'] == "Select Status") echo 'selected = "selected"'; ?>>Select Status</option>						
						<option value="scheduled" <?php if($_SESSION['status'] == "scheduled") echo 'selected = "selected"'; ?> >scheduled</option>
						<option value="active" <?php if($_SESSION['status'] == "active") echo 'selected = "selected"'; ?> >active</option>
						<option value="invoicing" <?php if($_SESSION['status'] == "invoicing") echo 'selected = "selected"'; ?> >invoicing</option>
						<option value="to priced" <?php if($_SESSION['status'] == "to priced") echo 'selected = "selected"'; ?> >to priced</option>
						<option value="completed" <?php if($_SESSION['status'] == "completed") echo 'selected = "selected"'; ?> >completed</option>
					</select>
					</td>
				<?php	
						} else {						
				?>
						<td><?php echo $rows['status'];?></td>
				
				
				<?php
						}
				?>
				
				
                
                <td><?php echo $rows['client_name'];?></td>
                <td><?php echo $rows['client_email'];?></td>
				<td><?php echo $rows['contact_details'];?></td>
				<!--<td><?php echo $rows['description'];?></td>-->
				
				<?php
						if ($number == $rowcount) {  						
				?>
						<td><input type="text" id="description" name="description" value="<?php echo $rows['description'];?>" onchange="noteChanged(this.value,<?php echo $rows['notes_id'];?>)"></td>
		  
				<?php	
						} else {						
				?>
						<td><?php echo $rows['description'];?></td>
				
				
				<?php
						}
				?>

            </tr>
           <?php
                }
            ?>
        </table><p></p><p></p>
		<div class="flex-parent jc-center">
				<button class="green margin-right" onclick="history.go(-1);">Back </button>	
				<button style="margin-right: 20px;" onclick="addNotesShow()">Add New Notes</button>
				<!--<button onclick="update()">Update Status & Notes</button>-->
		</div>
		
		
		<div class="toshow" style="width:500px;margin: 40px auto;border: 1px solid;padding: 20px;background: #d2eff6;" id="myDIV">	
					<h3 style="margin:0 0 20px; text-align:center; font-weight:bold; color:#006600;">Add New Notes</h3>		
					<label>Unique job identifier</label>
					<input type="text" name="jobId" id="jobId" class="form-control" readonly value="<?php echo $_SESSION['job_identifier'];?>" >
					<br><br>
					<label>Job Status</label>			 
						
					<select id="statusId">
						<option value="Select Status" <?php if($_SESSION['status'] == "Select Status") echo 'selected = "selected"'; ?>>Select Status</option>						
						<option value="scheduled" <?php if($_SESSION['status'] == "scheduled") echo 'selected = "selected"'; ?>>scheduled</option>
						<option value="active" <?php if($_SESSION['status'] == "active") echo 'selected = "selected"'; ?>>active</option>
						<option value="invoicing" <?php if($_SESSION['status'] == "invoicing") echo 'selected = "selected"'; ?>>invoicing</option>
						<option value="to priced" <?php if($_SESSION['status'] == "to priced") echo 'selected = "selected"'; ?>>to priced</option>
						<option value="completed" <?php if($_SESSION['status'] == "completed") echo 'selected = "selected"'; ?>>completed</option>
					</select>
					<br><br>
					<label>Note Description</label>
					<input type="text" name="description" id="descriptionId" class="form-control">
					<br><br>
					<label></label>
					<button style="margin-right:10px;" onclick="createFunction();">Create Notes</button>
					<button onclick="addNotesHide()">Cancel</button>
				
			</div>
		
    </section>
		<footer>
			<img style="width:100%; height:200px;" src="footer.jpg">
	</footer>

</body>

</html>