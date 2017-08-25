<?php
session_start();

if(isset($_SESSION['username']))
{
	CheckForLastActivity();
}
else
{
	header("location: Login.html");
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
        <title>Home</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="Plugins/jquery-3.2.1.js"></script>
    </head>
    
    <body>

    	<?php 
    		echo "Logged in as: " . $_SESSION['username'];				
    	?>

        <div id = "container">
            <table id="table" cellspacing="5" align="center">
                <tr>
                	<td colspan='2'>
                		<h3 align="center" style="line-height:30px;height:30px;margin:0;">
	                    	Edit bars
                		</h3>
                	</td>    	            
                </tr>            
                
                <table id = 'barContainer'>
                    <tbody id='barContainerBody'>

                    </tbody>
                </table>
                <?php
                echo "
                        <script type='text/javascript' src='Home.js'></script>
                        ";  
                ?>
            </table>

        </div>

           
    </body>
</html>

<style type="text/css">
	body, table
    {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    td {
   		border: 1px solid black;
   		padding: 0px;
   		margin: 0px;
        height: 100%;
	}
	td button
	{        
        padding: 0;
        margin: 0;
		width: 100%;
		height: 100px;
	}

    tr td h1
    {
        line-height: 80px;
        height: 80px;
        padding: 0;
        margin: 0;
    }

    #EditButtonCell
    {
        display: table-cell;
        padding: 0;
    }

    .RegisterBarButtonRow{
        height: 50px;
    }    
    
    h1,h3
    {
        font-family: helvetica;
    }


    
</style>