
<!doctype html>

<?php 
$KidneyData = fopen("Cortex.csv", "r");
if ($KidneyData !== FALSE) 
?>
<html>
<head>
<meta charset="utf-8">
<title>Gene Database</title>
<h1 style="text-align: center; color:white;">Gene Data</h1>
	<div class="dropdown">
  <button onclick="myFunction()" class="dropbtn">Part of Body</button>
  <div id="myDropdown" class="dropdown-content">
    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
    <a href="marrow.php">Bone Marrow</a>
    <a href="cortex.php">Cortex</a>
    <a href="drg.php">DRG</a>
    <a href="fat.php">Fat</a>
    <a href="heart.php">Heart</a>
    <a href="hypothalamus.php">Hypothalamus</a>
    <a href="index.php">Kidneys</a>
	<a href="muscle.php">Muscle</a>
  </div>
</div>
	<script>
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  const input = document.getElementById("myInput");
  const filter = input.value.toUpperCase();
  const div = document.getElementById("myDropdown");
  const a = div.getElementsByTagName("a");
  for (let i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>
	</head>
	<style>
    	table,th,td {
        	border: 1px solid white;
        }
		#wrapper{
			overflow:hidden;
			overflow-y:scroll;
			height:500px;
		}
		th{
			position:sticky;
			background-color: gray;
			z-index: 2;
			top: 0;
		}
		.dropbtn {
  			background-color: gray;
  			color: white;
 			padding: 16px;
  			font-size: 16px;
  			border: none;
  			cursor: pointer;
		}

		.dropbtn:hover, .dropbtn:focus {
  			background-color: lightgrey;
		}

		#myInput {
  			box-sizing: border-box;
  			background-image: url('searchicon.png');
  			background-position: 14px 12px;
  			background-repeat: no-repeat;
  			font-size: 16px;
	  		padding: 14px 20px 12px 45px;
  			border: none;
  			border-bottom: 1px solid #ddd;
		}

		#myInput:focus {outline: 3px solid #ddd;}

		.dropdown {
  			position: relative;
  			display: inline-block;
		}

		.dropdown-content {
  			display: none;
  			position: absolute;
  			background-color: #f6f6f6;
  			min-width: 230px;
  			overflow: auto;
  			border: 1px solid #ddd;
  			z-index: 1;
		}

		.dropdown-content a {
  			color: black;
  			padding: 12px 16px;
  			text-decoration: none;
  			display: block;
		}

		.dropdown a:hover {background-color: #ddd;}

		.show {display: block;}
	</style>
	<div id = "wrapper">
		<table style="border:1px solid black; margin-left:auto; margin-right:auto;">
            <thead style="color:white;">
                <tr style="text-align:center; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif';">
                    <th><b>Symbol</b></th>
                    <th><b>Name</b></th>
					<th><b>P Value</b></th>
                    <th><b>FDR Step Up</b></th>
					<th><b>Ratio</b></th> 
					<th><b>Fold Change</b></th>  
					<th><b>LS Mean</b></th> 
					<th><b>LS Mean Control</b></th> 
                </tr>
            </thead>
				<?php
    				while (! feof($KidneyData)) {
        				$data = fgetcsv($KidneyData, 1000, ",");
        					if (! empty($data)) {
            	 ?>
            <tr style="color:white;">
                <td><?php echo $data[0];  ?></td>
                <td><div> <?php echo $data[1]?></td>
				<td><div> <?php echo $data[2]?></td>
				<td><div> <?php echo $data[3]?></td>
				<td><div> <?php echo $data[4]?></td>
				<td><div> <?php echo $data[5]?></td>
				<td><div> <?php echo $data[6]?></td>
                <td><div><?php echo $data[7]; ?></div></td>
            </tr>
 			<?php } ?>
			<?php } ?>
   				 
    
        </table>
	</div>
        
<body style="background-color:black;">

	

</body>
</html>
<?php
fclose($KidneyData);
?>		
