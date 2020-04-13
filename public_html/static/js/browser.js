amountLoaded = 0;
maxPerPage = 10;

currentURL = window.location.href;

try
{
    pageNr = parseInt(currentURL.substring(currentURL.search("pagenr=")+"pagenr=".length));
}
catch
{
    pageNr = 1;
}

if(currentURL.search("pagenr=") == -1)
{
    pageNr = 1;
}

amountLoaded = ((pageNr*10)-maxPerPage);
loadDoc(10)

/* TEMP? */
/*
window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        //alert("you're at the bottom of the page, Loading more!");
        loadDoc(5)
    }
};
*/


function loadDoc(AmountToLoad) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200 && AmountToLoad > 0) {
            
            jsonPostsObject = JSON.parse(this.responseText)
            
            //console.log(jsonPostsObject);

            for (let index = 0; index < AmountToLoad; index++) {
            
                var post = document.createElement("div");
                post.id = jsonPostsObject[index].id; 

                var title = document.createElement("h2");
                title.appendChild(document.createTextNode(jsonPostsObject[index].title));
                
                var shortDescription = document.createElement("p");
                shortDescription.appendChild(document.createTextNode(jsonPostsObject[index].short_description))

                var creationDateTime = document.createElement("p");
                creationDateTime.appendChild(document.createTextNode("Creation date: "+jsonPostsObject[index].creation_dateTime));

                var editDateTime = document.createElement("p");
                editDateTime.appendChild(document.createTextNode("edit_date: "+jsonPostsObject[index].edit_dateTime));
                
                var author = document.createElement("p");
                author.appendChild(document.createTextNode("Author: "+jsonPostsObject[index].author));
                
                var followers = document.createElement("p");
                followers.appendChild(document.createTextNode("Folowers: "+jsonPostsObject[index].followers));
                
                
                // and give it some content 
                post.appendChild(title);
                post.appendChild(shortDescription);
                post.appendChild(author);
                post.appendChild(creationDateTime);
                
                if (jsonPostsObject.edit_dateTime != null)
                {
                    post.appendChild(editDateTime);
                }
                
                post.appendChild(followers);
        
                // add the newly created element and its content into the DOM 
                var bottomLine = document.getElementById("bottom"); 
                var ideaNode = document.getElementById("bottom").parentNode;

                ideaNode.insertBefore(post,bottomLine);
            }
        }
        else if (AmountToLoad <= 0)
        {
            console.error("Can't load 0 or negative amount of posts");
        }
    };
    xhttp.open("GET", "http://ideavault.se/callback.php?LastPostLimit="+amountLoaded+"&AmountToLoad="+AmountToLoad, true);
    xhttp.send();
    amountLoaded += 10;


}

