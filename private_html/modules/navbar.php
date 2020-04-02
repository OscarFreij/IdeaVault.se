<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="?page=home">IdeaVault</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="<?=$isActive[0]?> "><a href="?page=home">Home</a></li>
            <li class="<?=$isActive[1]?> "><a href="?page=browseIdeas">Browse Ideas</a></li>
            <li class="<?=$isActive[2]?> "><a href="?page=postIdea">Post Idea!</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <?php
        if (isset($_SESSION['email']))
        {
            echo('<li class""><a href=?user='.$_SESSION['nickname'].'>'.$_SESSION['nickname'].'</a></li>');
            echo('<li class""><a href=logout.php>Logout</a></li>');
        }
        else
        {
            echo('<li class=""><a href="'.$client->createAuthUrl().'">Login with Google!</a></li>');
        }

        ?>

        </ul>
    </div>
</nav>

