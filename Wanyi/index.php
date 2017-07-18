<html>
    <head>
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
                            echo "<li><a href=\"" . $file . "\" onclick=\"return navBarElementPressed('".$file."');\">" . $file . "</a></li> ";
                        }                        
                    }                    
                  }

                 



                  
                ?>           			            
           			<li><a href="about">ABOUT</a></li>
           			<li><a href="Contact">CONTACT</a></li>
           			           				
           		</ul>
           </div>

           

           <div id = "content-body">	
                     
                  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
                  <script type="text/javascript" src="jquery-3.2.1.js"></script>
                  <script type="text/javascript" src="jquery.lazyload.js"></script>
                  <script type="text/javascript">

                    var folder = "images/Featured/";
                    var startingIndex = 0;
                    var numberOfImages = 30;
                    var displayedImageCount = 0; 
                    var urlImagesToDisplay = new Array();
                    $(document).ready(function()
                      {                        
                        refreshImagesForRange(0,10);
                      });

                    
                    function refreshImagesForRange(startIndex, rangeLength)
                    {
                      


                      $.ajax({
                          url : folder,
                          success : function(data)
                          {                   
                                                                      
                              $(data).find("a").attr("href",function(index,value)
                                {
                                  if(index >= startingIndex && displayedImageCount < (numberOfImages))
                                  {
                                    if(value.match(/\.(jpe?g|png|gif|)$/i))
                                    {            
                                      urlImagesToDisplay.push(folder + value);
                                    }     
                                  }

                                                            
                                });

                              DisplayImageAtIndex(0);

                          }

                        });
                    }


                    function DisplayImageAtIndex(index)
                    {
                      if(index < urlImagesToDisplay.length)
                      {
                        var url = urlImagesToDisplay[index];
                        var contentView = document.getElementById("content-body");                        
                        contentView.innerHTML = contentView.innerHTML + "<img data-original=\"" + url + "\" class = \"whitebox lazy\" style=\"max-height:100\" >" ;                                            
                        $("img.lazy").lazyload({
                          effect : "fadeIn",                          
                          container: $("#content-body"),
                        });                        

                      }  

                      if(index < urlImagesToDisplay.length - 1)
                        {
                          DisplayImageAtIndex(index + 1);
                        }        

                        $(window).resize();           
                    }

                    function navBarElementPressed(pressed)
                    {
                      alert(pressed);
                      return false;
                    }

                  </script>


              </div>


           
        </div>
    </body>
</html>