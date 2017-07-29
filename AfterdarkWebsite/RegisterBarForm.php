<?php
session_start();

if(isset($_SESSION['username']))
{
	CheckForLastActivity();
}
else
{
	header("location: login.html");
}


function CheckForLastActivity()
{
	//last ativity
		if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) 
		{
    		// last request was more than 30 minutes ago
    		session_unset();     // unset $_SESSION variable for the run-time 
    		session_destroy();   // destroy session data in storage
    		header("location: timeout.php");
		}

		//echo "lastActivity:" . $_SESSION['LAST_ACTIVITY'];
		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
}
?>

<html>
    <head>
        <title>Register New Bar</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="Plugins/jquery-3.2.1.js"></script>
    </head>
    
    <body>

    	<?php 
    		echo "Logged in as: " . $_SESSION['username'];				
    	?>

    	<form method="post" action="Functions/RegisterBar.php">
    		<table align="center">
    			<tbody>
    				<tr>
    					<th>
    						Bar Name:
    					</th>
    					<td>
    						<input id="name" name="Bar_Name" type="text">	
    					</td>
    				</tr>
    				<tr>
    					<th>
    						Description:
    					</th>
    					<td>
    						<input id="description" name="Bar_Description" type="text">	
    					</td>
    				</tr>
    				<tr>
    					<th>
    						Contact:
    					</th>
    					<td>
    						<input id="contact" name="Bar_Contact" type="text">	
    					</td>
    				</tr>
    				<tr>
    					<th>
    						Website:
    					</th>
    					<td>
    						<input id="website" name="Bar_Website" type="text">	
    					</td>
    				</tr>
    				<tr>
    					<th>
    						Opening Hours:
    					</th>
    					<td align='right'>
    						<table>
    							<tbody>
    								<tr>
    									<th>
    										Monday
    									</th>
    									<td>
    										<input id="OH_Monday" name="OH_Monday" type="text">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Tuesday
    									</th>
    									<td>
    										<input id="OH_Tuesday" name="OH_Tuesday" type="text">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Wednesday
    									</th>
    									<td>
    										<input id="OH_Wednesday" name="OH_Wednesday" type="text">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Thursday
    									</th>
    									<td>
    										<input id="OH_Thursday" name="OH_Thursday" type="text">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Friday
    									</th>
    									<td>
    										<input id="OH_Friday" name="OH_Friday" type="text">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Saturday
    									</th>
    									<td>
    										<input id="OH_Saturday" name="OH_Saturday" type="text">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Sunday
    									</th>
    									<td>
    										<input id="OH_Sunday" name="OH_Sunday" type="text">
    									</td>
    								</tr>

    							</tbody>
    						</table>	
    					</td>
    				</tr>
					<tr>
    					<th>
    						Location:
    					</th>
    					<td>
    						<iframe src="PlacesSelector.html"></iframe>
    						<input id = 'location' name="Bar_Address" type="text">
    						<input id = 'lat' name="Bar_Location_Latitude" type="text">	
    						<input id = 'long' name="Bar_Location_Longitude" type="text">	    						
    					</td>
    				</tr>
					<tr>
    					<th>
    						Exclusive:
    					</th>
    					<td align='right'>    			
    						<select name="Exclusive">
  								<option value="true">Exclusive</option>
  								<option value="false">Non-Exclusive</option>
							</select>			
    						
    					</td>
    				</tr>


    				<tr>
    					<td colspan='2'>
    						<input id='submitButton' type="submit" value="submit" >
    					</td>    					
    				</tr>
    			</tbody>
    		</table>    	
    	</form>
           
    </body>
</html>

<style type="text/css">

td
{
	border: 1px solid black;	
}

input
{
	width: 100%;
	text-align: right;
}

#submitButton
{
	text-align: center;
}

iframe
{
	width: 100%;
	height: 400px;
}

</style>