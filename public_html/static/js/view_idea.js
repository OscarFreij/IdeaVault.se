
var quill;
function loadDoc()
{
    quill = new Quill('#editor_container', {
        modules: {
            "toolbar": false
        },
        placeholder: 'Hmm, seems like ther is no description...',
        theme: 'snow',  // or 'bubble'
        readOnly: true
      });
}

var myContent

function setContent()
{
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const ideaId = urlParams.get('idea')

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function() {
        if (this.readyState == 4 && this.status == 200) {
            var temp = JSON.parse(atob(this.responseText));
            console.log(temp.ops);
            quill.setContents(temp.ops);
        }
    };
    xhttp.open("GET", "http://ideavault.se/callback.php?idea="+ideaId, true);
    xhttp.send();
};

function toggleFollow()
{
   const queryString = window.location.search;

   const urlParams = new URLSearchParams(queryString);

   const ideaId = urlParams.get('idea')

   var xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange=function() {
       if (this.readyState == 4 && this.status == 200) {
           console.log(this.responseText);
           window.location.replace(window.location.pathname + window.location.search + window.location.hash);
       }
   };
   xhttp.open("GET", "http://ideavault.se/callback.php?FollowAction=Toggle&TargetType=Idea&TargetID="+ideaId, true);
   xhttp.send();
}

document.addEventListener('DOMContentLoaded', function() {
    loadDoc();
    setContent();
 }, false);



