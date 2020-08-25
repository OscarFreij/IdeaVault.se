<?php

if (isset($_SESSION['id']))
{
    echo('
    <div>
        <div id="info_box" class="post">
            <input id="title" placeholder="Title"><br>
            <input id="short_description" placeholder="Short description"><br>
            <p>Idea is public: <input type="checkbox" name="is_public" id="is_public" checked></p>
            <div id="container">
                <p>Description</p>
                <div id="editor_container">
                
                </div>
            </div>
        </div>
        <div id="button_panel">
            <button id="saveBTN" class="btn btn-success" onclick="createContent()">Create</button>
            <a id="exitBTN" class="btn btn-danger" href="?idea=">Exit</a>
        </div>
    </div>
    ');
}
else
{
    echo('
    <div>
    <h2>To share an idea you need to be logged in!</h2>
    <div>
    ');
}
