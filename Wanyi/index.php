<html>
    <head>

      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <script type="text/javascript" src="Plugins/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="Plugins/jquery.lazyload.js"></script>
      <script type="text/javascript" src="Plugins/jquery.fancybox.min.js"></script>

       <link rel ="stylesheet" type="text/css" href ="index.css"/>
    </head>
    
    <body>
         

        <img id = "backgroundImage" src="background2.jpeg">
          
        <div id = "container">
           <div id = "navBar"> 
              <h1 id = "title">
                TWY PHOTOG
              </h1>

           		<ul id = "list">           			
                <?php
                  $dir = scandir("images/");
                

                  foreach($dir as $file)
                  {
                    if($file != ".."  && $file != ".")
                    {
                        if(is_dir("images/" . $file))
                        {
                            echo "<li><a id = \"" .$file. "\" href=\"" . $file . "\" onclick=\"return navBarElementPressed('".$file."');\">" . $file . "</a></li> ";
                        }                        
                    }                    
                  }
                  
                ?>           			            
           			<li><a href="about">ABOUT</a></li>
           			<li><a href="Contact">CONTACT</a></li>
           			           				
           		</ul>
           </div>
  
          <script type="text/javascript">
          document.getElementsByTagName("a")[0].style["color"] = "black";
          </script>

           <div id = "content-body">	                     
                  <div id = "images">
                    
                  </div>   
          </div>


           
        </div>
    </body>

    <footer>
      <script type="text/javascript" src="index.js"></script>
    </footer>
</html>