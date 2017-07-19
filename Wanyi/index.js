

var folder = "images/";
var displayedFolder = "Featured"
var startingIndex = 0;
var urlImagesToDisplay = new Array();

$(window).on("load",function()
{                 
  refreshImagesForRange(0,15);
});


function refreshImagesForRange(startIndex, rangeLength)
{
  $.ajax({
    url : folder+displayedFolder,
    success : function(data)
    {                   

      $(data).find("a").attr("href",function(index,value)
      {
        if(index >= startingIndex && urlImagesToDisplay.length < (rangeLength))
        {
          
          if(value.match(/\.(jpe?g|png|gif|)$/i))
          {                        
            urlImagesToDisplay.push(value);                                      
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
    var fileFullName = urlImagesToDisplay[index];
    var url = folder + displayedFolder + "/" + fileFullName;
    var imageContainer = document.getElementById("images");                                              

    var removeString = fileFullName.match(/\.(jpe?g|png|gif|)$/i);
    

    //if there is a reference 
    if(removeString != null && removeString != "")
    {


      var imageName = fileFullName.replace(removeString[0],"");   
      imageContainer.innerHTML = imageContainer.innerHTML + "<div id= \""+imageName+"Container\" class=\"whiteboxGroup\" onclick=\"ImageClicked('"+imageName+"')\" ><img data-original=\"" + url + "\" class = \"whitebox lazy\" style=\"max-height:100\"><div id=\""+imageName+"Overlay\" class=\"whiteboxOverlay\">TEST</div></div>" ;                                                
                     
    }
    else
    {
      imageContainer.innerHTML = imageContainer.innerHTML + "<img data-original=\"" + url + "\" class = \"whiteboxContainer lazy\" style=\"max-height:100\" >" ;                                                      
    }



    $("img.lazy").lazyload({
      effect : "fadeIn",                          
      container: $("#content-body"),
    });                        

  }  

  if(index < urlImagesToDisplay.length - 1)
  {
    DisplayImageAtIndex(index + 1);
  }        

         
}

function ImageClicked(imageName)
{
  document.getElementById(imageName+"Container").style["width"] = "100%";
  document.getElementById(imageName+"Container").style["min-width"] = "100%";
  document.getElementById(imageName+"Container").style["height"] = "100%";
  document.getElementById(imageName+"Container").style["min-height"] = "100%";
}

function navBarElementPressed(folderPressed)
{

  document.getElementById(displayedFolder).style["color"] = "grey";

  if(displayedFolder != folderPressed)
  {
      var imageContainer = document.getElementById("images");  
  imageContainer.innerHTML = "";
  urlImagesToDisplay.length = 0;

  displayedFolder = folderPressed;  

  refreshImagesForRange(0,15);
  }




  document.getElementById(folderPressed).style["color"] = "black";

  return false;
}


