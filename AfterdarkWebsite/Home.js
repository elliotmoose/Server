
// $(window).on("load",function()
// {                 
//   	RefreshBarDisplay();
// });

RefreshBarDisplay();

function RefreshBarDisplay()
{	
	var container = document.getElementById("barContainerBody");

	container.innerHTML = "";
	$.ajax(
	{
		url: '/AfterDarkServer/HardLoadAllBars.php',
		success: function(data)
	    {                         
	    	var bars = JSON.parse(data);
	    	for(var i = 0; i < bars.length; i++)
	    	{
	    		var bar = bars[i];
	    		var barName = bar["Bar_Name"];
	    		var barStatus = false;	    		
	    		if(bar["Enabled"] == 1)
	    		{
	    			barStatus = true;
	    		}
	    		var barID = bar["Bar_ID"];

	    		container.innerHTML = container.innerHTML + "<tr><td><table><tbody><tr><td><h1 style='text-align:center;'>"+barName+"</h1></td></tr><tr><td>Enabled:"+barStatus+"</td></tr></tbody></table></td><td id='EditButtonCell'><button align='center' onclick='EditBar("+barID+");'>EDIT</button></td></tr>";
			}

			container.innerHTML = container.innerHTML + "<tr class='RegisterBarButtonRow' ><td class='RegisterBarButtonRow' colspan='2'><button onclick='RegisterBar()'>Register New Bar</button></td></tr>" 
	    }

	});
}

function RegisterBar()
{
	window.location.href = "RegisterBarForm.php";
}

function EditBar(barID)
{
	window.location.replace("EditBarForm.php?Bar_ID="+barID);
}
