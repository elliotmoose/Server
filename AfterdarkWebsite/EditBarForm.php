<?php
require_once("../AfterDarkServer/Database.php");
session_start();

if(isset($_SESSION['username']))
{
	CheckForLastActivity();
}
else
{
	header("location: login.html");
}
Database::BeginConnection();
$bar_ID = filter_input(INPUT_GET,"Bar_ID");

if(!isset($bar_ID))
{
    header("location: Home.php");
}


$output = Database::StatementSelectWhere("*", "bar_info",["Bar_ID"],[$bar_ID],"s");
$bar = $output[0];
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
        <title>Edit Bar</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="Plugins/jquery-3.2.1.js"></script>
    </head>
    
    <body>

    	<?php 
    		echo "Logged in as: " . $_SESSION['username'];				
    	?>
        <form id="imagesForm" method="post" action="Functions/UploadBarImages.php">
            
        </form>   
    	<form method="post" action="Functions/UpdateBar.php">
    		<table align="center">
    			<tbody>
    				<tr>
    					<th>
    						Bar Name:
    					</th>
    					<td>
    						<input id="name" name="Bar_Name" type="text" value= "<?php echo $bar["Bar_Name"];?>">	
    					</td>
    				</tr>
    				<tr>
    					<th>
    						Description:
    					</th>
    					<td>
    						<input id="description" name="Bar_Description" type="text" value="<?php echo $bar["Bar_Description"]; ?>">	
    					</td>
    				</tr>
    				<tr>
    					<th>
    						Contact:
    					</th>
    					<td>
    						<input id="contact" name="Bar_Contact" type="text" value="<?php echo $bar["Bar_Contact"]; ?>">	
    					</td>
    				</tr>
    				<tr>
    					<th>
    						Website:
    					</th>
    					<td>
    						<input id="website" name="Bar_Website" type="text" value="<?php echo $bar["Bar_Website"]; ?>">	
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
    										<input id="OH_Monday" name="OH_Monday" type="text" value="<?php echo $bar["OH_Monday"]; ?>">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Tuesday
    									</th>
    									<td>
    										<input id="OH_Tuesday" name="OH_Tuesday" type="text" value="<?php echo $bar["OH_Tuesday"]; ?>">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Wednesday
    									</th>
    									<td>
    										<input id="OH_Wednesday" name="OH_Wednesday" type="text" value="<?php echo $bar["OH_Wednesday"]; ?>">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Thursday
    									</th>
    									<td>
    										<input id="OH_Thursday" name="OH_Thursday" type="text" value="<?php echo $bar["OH_Thursday"]; ?>">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Friday
    									</th>
    									<td>
    										<input id="OH_Friday" name="OH_Friday" type="text" value="<?php echo $bar["OH_Friday"]; ?>">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Saturday
    									</th>
    									<td>
    										<input id="OH_Saturday" name="OH_Saturday" type="text" value="<?php echo $bar["OH_Saturday"]; ?>">
    									</td>
    								</tr>
    								<tr>
    									<th>
    										Sunday
    									</th>
    									<td>
    										<input id="OH_Sunday" name="OH_Sunday" type="text" value="<?php echo $bar["OH_Sunday"]; ?>">
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
    						<input id = 'location' name="Bar_Address" type="text" value="<?php echo $bar["Bar_Address"]; ?>">
    						<input id = 'lat' name="Bar_Location_Latitude" type="text" value="<?php echo $bar["Bar_Location_Latitude"]; ?>" readonly>	
    						<input id = 'long' name="Bar_Location_Longitude" type="text" value="<?php echo $bar["Bar_Location_Longitude"]; ?>" readonly>	    						
    					</td>
    				</tr>
					<tr>
    					<th>
    						Exclusive:
    					</th>
    					<td align='right'>    			
    						<select name="Exclusive">
  								<option value="true" <?php if($bar["Exclusive"] === 1){echo "selected";}?> >Exclusive</option>
  								<option value="false" <?php if($bar["Exclusive"] === 0){echo "selected";}?>>Non-Exclusive</option>
							</select>			
    						
    					</td>
    				</tr>
                    <tr>
                        <th>
                            Images:
                        </th>                        
                        <td>
                            <div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            
                        </th>
                        <td align='right'>                                          
                                <input form="imagesForm" id="chooseImageFile" type="file" multiple>
                                <input form="imagesForm" name="Bar_ID" type="text" value="<?php echo $bar["Bar_ID"]; ?>" hidden>                                

                            <script type="text/javascript">
                                
                                $('#chooseImageFile').change(function(){
                                    $('#imagesForm').submit();                                                         
                                });

                                $('#imagesForm').submit(function(e)
                                {           
                                    var data = new FormData(document.getElementById("imagesForm"));                                    
                                    var files = document.getElementById("chooseImageFile").files;
                                    for(var i=0;i<files.length;i++)
                                    {                                                                                
                                        data.append(files[i].name,files[i]);
                                    }

                                    $.ajax({
                                        url:"Functions/UploadBarImages.php",
                                        type: "POST",
                                        contentType:false,
                                        processData: false,
                                        cache: false,
                                        data: data,
                                        success: function(success)
                                        {                                         

                                            try
                                            {
                                                var successDict = JSON.parse(success);
                                                if(successDict["success"] == "false")
                                                {
                                                    alert(successDict["detail"]);
                                                }
                                                else
                                                {
                                                    alert(successDict["detail"]);
                                                }      
                                            }
                                            catch(e)
                                            {
                                                alert(success);
                                            }   
                                                                                      
                                        }

                                    });

                                    e.preventDefault();                                    
                                });
                                

                                function RefreshImagesDisplay()
                                {

                                }                               

                            </script>                        
                        </td>
                    </tr>

    				<tr>
    					<td colspan='2'>
                            <input type ="text" name="Bar_ID" value='<?php echo filter_input(INPUT_GET,"Bar_ID");?>' hidden>
    						<input id='submitButton' type="submit" name = "editBarFormSubmit" value="Update" >
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