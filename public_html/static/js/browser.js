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
            
            console.log(jsonPostsObject);

            for (let index = 0; index < AmountToLoad; index++) {
            
                var post = document.createElement("a");
                post.id = jsonPostsObject[index].id; 
                post.className = "post";
                post.href = "";

                var title = document.createElement("p");
                title.className = "title";
                title.appendChild(document.createTextNode(jsonPostsObject[index].title));
                
                var shortDescription = document.createElement("p");
                shortDescription.className = "shortDescription";
                shortDescription.appendChild(document.createTextNode(jsonPostsObject[index].short_description))


                var creationDateTime = document.createElement("p");
                creationDateTime.className = "creationDateTime";
                creationDateTime.appendChild(document.createTextNode("Created: "+jsonPostsObject[index].creation_dateTime));


                var dateTimeBox = document.createElement("div");
                dateTimeBox.className = "dateTimeBox";

                dateTimeBox.appendChild(creationDateTime);

                if (jsonPostsObject[index].edit_dateTime != null)
                {                    
                    var editDateTime = document.createElement("p");
                    editDateTime.className = "editDateTime";
                    editDateTime.appendChild(document.createTextNode("Edited: "+jsonPostsObject[index].edit_dateTime));

                    dateTimeBox.appendChild(editDateTime);
                }


                var author = document.createElement("p");
                author.className = "author";
                author.appendChild(document.createTextNode("Author: "+jsonPostsObject[index].author));
                
                var followers = document.createElement("p");
                followers.className = "followers"
                followers.appendChild(document.createTextNode("Followers: "+jsonPostsObject[index].followers));
                
                
                // and give it some content 
                post.appendChild(title);
                post.appendChild(shortDescription);
                post.appendChild(author);
                post.appendChild(dateTimeBox);
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

