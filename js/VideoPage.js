
function loadVideoPreview(id){
    
    var api_path = "api_public.php?a=video/" + id;
    
     $.ajax({
         url: api_path, 
         async: true, 
         success: function(data){
            document.getElementById("video-preview-section").innerHTML = template(data);
    }});
    
    
    
}


