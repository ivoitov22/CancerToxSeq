
<!doctype html>

<?php 
$KidneyData = fopen("Kidneys.csv", "r");
if ($KidneyData !== FALSE) 
?>
<html>
<head>
<meta charset="utf-8">
<title>CancerToxSeq</title>
<h1 style="text-align: center; color:black;font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif';font-size:30pt; padding-top:80px;">CancerToxSeq</h1>
<h2 style="text-align: center; color:black;font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif';font-size:15pt; padding-top:20px;font-weight:500;">RNA-Seq Drug Toxicity Database</h2>
<table id="buttons" style="border: 0px solid white; padding-bottom:40px; padding-top:30px;">
	<tr>
		<td style="border:0px;padding-left:360px;">	
			<button type="button" name="myButton" style=>Drug Name</button>
		</td>
		<td style="border:0px;padding-left:100px;">
			<button type="button" name="myButton">Species/Model</button>
		</td>
		<td style="border:0px;padding-left:100px;">
			<button type="button" name="myButton">Organ/System</button>
		</td>
		<td style="border:0px;padding-left:100px;">
			<button type="button" name="myButton">Gene/Pathway</button>
		</td>
	</tr>
</table>


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
        	border: 1px solid black;
        }
		#wrapper{
			overflow:hidden;
			overflow-y:scroll;
			height:500px;
		}
		th{
			position:sticky;
			background-color: lightgray;
			z-index: 2;
			top: 0;
		}
		button {
			color: #ffffff;
			background-color: #2d63c8;
			font-size: 19px;
			border: 2px solid #000000;
			padding: 15px 50px;
			cursor: pointer
		}
		button:hover {
			color: #2d63c8;
			background-color: #ffffff;
		}
		.show {display: block;}
	</style>
	<div id = "wrapper">
		<table style="border:1px solid black; margin-left:auto; margin-right:auto;">
            <thead style="color:black;">
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
            <tr style="color:black;">
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
	<table style="border:0px; font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, 'sans-serif'; margin-top:-400px;padding-left:80px;width:27%;font-weight:600;font-size:10pt;">
		<thead style="border:1px solid white; margin-left:auto; margin-right:auto;">
			<tr style="text-align:center; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'; border:0px;color:white;">
				<th style="border:0px;background-color:black;"><b></b></th>
				<th style="border:0px;background-color:black;"><b>Database</b></th>
			</tr>
		</thead>
		<tr style="border:0px;background-color:#C0C0C0;height:30px;">
			<td style="border:0px;padding-right:50px;">1</td>
			<td style="border:0px;">GDS5826</td>
		</tr>
		<tr style="border:0px;background-color:#D3D3D3;height:30px;">
			<td style="border:0px;">2</td>
			<td style="border:0px;">GDS4381</td>
		</tr>
		<tr style="border:0px;background-color:#C0C0C0;height:30px;">
			<td style="border:0px;">3</td>
			<td style="border:0px;">GDS1225</td>
		</tr>
		<tr style="border:0px;background-color:#D3D3D3;height:30px;">
			<td style="border:0px;">4</td>
			<td style="border:0px;">GDS 4485</td>
		</tr>
		<tr style="border:0px;background-color:#C0C0C0;height:30px;">
			<td style="border:0px;">5</td>
			<td style="border:0px;">GDS1228</td>
		</tr>
	</table>
<img src="gKid3.png" alt="Graph 1" style="padding-top: 20px; width:450px;border:0px;display:inline-block;margin-top:-250px;padding-right:80px; float:right;">        
<body style="background-image: url('whiteBack.jpg'); background-repeat: no-repeat; background-size: cover;">

</body>
</html>
<?php
fclose($KidneyData);
?>		
