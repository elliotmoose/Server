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
        <form id="imagesForm" method="post" action="Functions/UploadBarImages.php" enctype="multipart/form-data">
            
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
                        <td align='right'>
                            <table>
                                <tbody id="barImagesContainer" >
                                    
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            
                        </th>
                        <td align='right'>                                          
                                <button onclick="return AddImageButtonClicked();">Add Images</button>
                                <input form="imagesForm" id="chooseImageFile" type="file" multiple hidden>
                                <input form="imagesForm" name="Bar_ID" type="text" value="<?php echo $bar["Bar_ID"]; ?>" hidden>                                                        
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Discounts:
                        </th>
                        <td align="right">
                            <table>
                                <tbody id="discountsTableContainer">
                                   
                                </tbody>
                            </table>
                        </td>
                    </tr>

    				<tr>
    					<td colspan='2'>
                            <input type ="text" name="Bar_ID" value='<?php echo filter_input(INPUT_GET,"Bar_ID");?>' hidden>
    						<input id='submitButton' type="submit" name = "editBarFormSubmit" value="Update" >
    					</td>    					
    				</tr>

                    <script type="text/javascript">

                        RefreshImagesDisplay();
                        RefreshDiscountsDisplay();

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
                                success: function(data)
                                {                                         
                                    RefreshImagesDisplay();
                                    try
                                    {                                                                                            
                                        var successDict = JSON.parse(data);
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
                                        alert(data);
                                    }                                                                                                               
                                }

                            });

                            e.preventDefault();                                    
                        });

                        function AddImageButtonClicked()
                        {
                            document.getElementById('chooseImageFile').click();
                            return false;
                        }

                        function RefreshImagesDisplay()
                        {                                                                       
                            var container = document.getElementById("barImagesContainer");                                    
                            var urlImagesToDisplay = new Array();
                            var folder = "../../AfterDarkServer/Bar_Images/" + <?php echo $bar["Bar_ID"];?>;
                            container.innerHTML = "";

                            $.ajax({
                                url : folder,
                                cache: false,
                                success : function(data)
                                {                   

                                    $(data).find("a").attr("href",function(index,value)
                                    {                                                    
                                        if(value.match(/\.jpg$/i))
                                        {                        
                                            urlImagesToDisplay.push(value);                                      
                                        }                                                 
                                    });                                        

                                    for(var i=0;i<urlImagesToDisplay.length;i++)
                                    {
                                        var url = urlImagesToDisplay[i];                                              
                                        var d = new Date();
                                        var n = d.getTime();                                                  
                                        var uniqueID = n + i;
                                        //container.innerHTML = container.innerHTML + "<tr><td'><img class='BarImageClass' src='"+folder+"/"+url+"?uniqueID="+uniqueID+"'></td></tr><tr><td align='right'><button onclick='return RemoveImage(\""+url+"\");'>REMOVE</button></td></tr>";

                                        //Image display row ==================================
                                        var imageRow = document.createElement('tr');                                        

                                        var imageCell = document.createElement('td');
                                        imageRow.appendChild(imageCell);

                                        var img = document.createElement('img');
                                        img.src = folder+"/"+url+"?uniqueID="+uniqueID;
                                        img.className ='BarImageClass';
                                        imageCell.appendChild(img);


                                        //Remove button row ==================================                                        
                                        var removeButtonRow = document.createElement('tr');

                                        var removeButtonCell = document.createElement('td');
                                        removeButtonCell.align = 'right';
                                        removeButtonRow.appendChild(removeButtonCell);

                                        var removeButton = document.createElement('button');
                                        removeButtonCell.appendChild(removeButton);
                                        removeButton.innerHTML = "REMOVE";
                                        removeButton.name = url;
                                        removeButton.onclick = function(){
                                            RemoveImage(this.name);
                                            //alert("removing: " + this.name);
                                            return false;
                                        }                                        

                                        container.appendChild(imageRow);
                                        container.appendChild(removeButtonRow)
                                    }
                                }

                            });
                            
                        }   

                        function RemoveImage(imageFileName)
                        {                                              
                            var formData = new FormData();
                            formData.append("Bar_ID",<?php echo $bar["Bar_ID"];?>);
                            formData.append("Image_Name",imageFileName);

                            $.ajax(
                            {
                                url: "Functions/RemoveImage.php",
                                type : "POST",
                                data: formData, 
                                contentType:false,
                                processData: false,     
                                cache: false,                                  
                                success: function(data)
                                {
                                    alert(data);

                                    RefreshImagesDisplay();
                                },
                                error: function(error)
                                {
                                    alert(error);
                                }
                            });

                            return false;
                        }

                        function RefreshDiscountsDisplay()
                        {
                            var url = "Functions/GetDiscountsForBar.php?Bar_ID="+<?php echo $bar["Bar_ID"]?>;
                            var discountContainer = document.getElementById("discountsTableContainer");
                            discountContainer.innerHTML = "";

                            $.ajax(
                            {
                                url: url,              
                                cache: false,                                  
                                success: function(data)
                                {
                                    if(data == "null")
                                    {
                                        return;
                                    }
                                    else
                                    {                                    
                                        var discounts = JSON.parse(data);

                                        for(var i=0;i<discounts.length;i++)
                                        {
                                            var discount = discounts[i];
                                            var discountName = discount["discount_name"];
                                            var discountID = discount["discount_ID"];                                  

                                            //one row per attribute
                                            var nameRow = document.createElement('tr');
                                            var descriptionRow = document.createElement('tr');
                                            var amountRow = document.createElement('tr');
                                            var exclusiveRow = document.createElement('tr');                                        

                                            //one header per row
                                            var nameHeader = document.createElement('th');
                                            nameHeader.innerHTML = "Name:"; 
                                            var descriptionHeader = document.createElement('th');
                                            descriptionHeader.innerHTML = "Description:";
                                            var amountHeader = document.createElement('th');
                                            amountHeader.innerHTML = "Discount:";
                                            var exclusiveHeader = document.createElement('th');
                                            exclusiveHeader.innerHTML = "Exclusive:";

                                            //one cell per row
                                            var nameCell = document.createElement('td');                                    
                                            var descriptionCell = document.createElement('td');
                                            var amountCell = document.createElement('td');
                                            var exclusiveCell = document.createElement('td');                                    
                                            exclusiveCell.align = "right";
                                            
                                            //one input per cell                             
                                            var nameInput = document.createElement('input');
                                            nameInput.type = "text";
                                            nameInput.value = discountName;
                                            nameInput.name = discountID + "_name";
                                            
                                            var descriptionInput = document.createElement('input');
                                            descriptionInput.type = "text";
                                            descriptionInput.value = discount["discount_description"];
                                            descriptionInput.name = discountID + "_description";

                                            var amountInput = document.createElement('input');
                                            amountInput.type = "text";
                                            amountInput.value = discount["discount_amount"];
                                            amountInput.name = discountID + "_amount";

                                            var exclusiveInput = document.createElement('select');
                                            var exclusiveOption = document.createElement('option');
                                                exclusiveOption.value="1";
                                                exclusiveOption.innerHTML="Exclusive";
                                            var nonexclusiveOption = document.createElement('option');                                        
                                                nonexclusiveOption.value="0";
                                                nonexclusiveOption.innerHTML="Non-Exclusive";

                                            exclusiveInput.appendChild(exclusiveOption);
                                            exclusiveInput.appendChild(nonexclusiveOption);                                        
                                            exclusiveInput.name = discountID + "_exclusive";               

                                            if(discount["Exclusive"] == 1)
                                            {
                                                exclusiveOption.selected = true;
                                                nonexclusiveOption.selected = false;
                                            }
                                            else
                                            {
                                                exclusiveOption.selected = false;
                                                nonexclusiveOption.selected = true;
                                            }


                                            //append children
                                            discountContainer.appendChild(nameRow);
                                            nameRow.appendChild(nameHeader);                                                                                
                                            nameRow.appendChild(nameCell);
                                            nameCell.appendChild(nameInput);

                                            discountContainer.appendChild(descriptionRow);
                                            descriptionRow.appendChild(descriptionHeader);                                                                                
                                            descriptionRow.appendChild(descriptionCell);
                                            descriptionCell.appendChild(descriptionInput);

                                            discountContainer.appendChild(amountRow);
                                            amountRow.appendChild(amountHeader);                                                                                
                                            amountRow.appendChild(amountCell);
                                            amountCell.appendChild(amountInput);

                                            discountContainer.appendChild(exclusiveRow);
                                            exclusiveRow.appendChild(exclusiveHeader);                                                                                
                                            exclusiveRow.appendChild(exclusiveCell);
                                            exclusiveCell.appendChild(exclusiveInput);

                                                                                   
                                            

                                        }

                                    }
                                    // for(var i=0;i<discounts.length;i++)
                                    // {
                                    //     var discount = discounts[i];
                                        
                                    //     discountContainer.innerHTML = discountContainer.innerHTML + "";
                                    // }                                        
                                }
                            });
                        }                         


                    </script>                        
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

.BarImageClass
{
    width: 300px;
    height: 200px;
    object-fit:cover;
}
</style>