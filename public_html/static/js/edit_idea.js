var quill;
function loadDoc()
{
    quill = new Quill('#editor_container', {
        modules: {
          toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block']
          ]
        },
        placeholder: 'Add a description here!',
        theme: 'snow'  // or 'bubble'
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
}

function deletePost()
{
  const queryString = window.location.search;

  const urlParams = new URLSearchParams(queryString);

  const ideaId = urlParams.get('idea')

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText);
          window.location.href = "http://ideavault.se/?page=home";
          
      }
  };
  xhttp.open("GET", "http://ideavault.se/callback.php?remove="+ideaId, true);
  xhttp.send();
}


function saveContent()
{
    myContent = quill.getContents();
    console.log(myContent);

    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const ideaId = urlParams.get('idea')

    
    var array = JSON.stringify(myContent);


    var title = btoa(encodeURIComponent(document.getElementById("title").value));
    var short = btoa(encodeURIComponent(document.getElementById("short_description").value));
    var long = btoa(array);
    var is_public = document.getElementById("is_public").checked;

    if (is_public)
    {
      is_public = "1";
    }
    else
    {
      is_public = "0";
    }

    var text = '{ "id":"'+ideaId+'", "title":"'+title+'", "short":"'+short+'", "long":"'+long+'", "is_public":"'+is_public+'" }';

    var jsonObject = JSON.parse(text);

    console.log(jsonObject);
    console.log(JSON.stringify(jsonObject));

    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            window.location.href = "http://ideavault.se/?idea="+ideaId;
        }
    };
    xhttp.open("POST", "http://ideavault.se/callback2.php", true);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send(JSON.stringify(jsonObject));
}

document.addEventListener('DOMContentLoaded', function() {
  loadDoc();
  setContent();
}, false);