<html>
    <head>
	<link rel ="stylesheet" type="text/css" href ="index.css"/>
    </head>
    
    <body>
        <div id = "container">
           <div id = "navBar"> 
           		<ul>
           			<li><div></div></li>
           			<li><a href="Featured">FEATURED</a></li>
           			<li><a href="about">ABOUT</a></li>
           			<li><a href="Contact">CONTACT</a></li>
           			           				

           		</ul>
           </div>

           <div id = "content-body">	
              <div id="main_image" class="parrallax-layer-base">
                  <img id = "HomeImage" src="randomHomeImage.jpeg">
              </div>

              <div id="content_view" class="parrallax-layer-back">            
                  <?php
                    for($i = 0; $i < 10; $i++)
                    {
                        echo "<div class=whitebox> </div>";
                    };
                  ?>
              </div>

           </div>

           
        </div>
    </body>
</html>