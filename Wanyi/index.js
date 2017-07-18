

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
            urlImagesToDisplay.push(folder + displayedFolder + "/" + value);                                      
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
    var imageContainer = document.getElementById("images");                                              
    imageContainer.innerHTML = imageContainer.innerHTML + "<img data-original=\"" + url + "\" class = \"whitebox lazy\" style=\"max-height:100\" >" ;                                            
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


