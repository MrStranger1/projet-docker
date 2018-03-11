<html>
<head>
    <title>Test haproxy</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        body, html{
            padding: 0; margin: 0;
            border: 0;
            height: 100%; width: 100%;
        }
        .container{
            font-size:1.4em;margin:80px auto;
        }
        #show_file{
            border:1px solid grey;
            border-radius:5px;
            overflow: auto;
            height:80%;
        }
    </style>
</head>
<body>
<main role="main" class="container">
    <?php require 'Haproxy.php'; ?>
    <div class="row">
        <div id="show_file" class="col-sm-6">
            <h4>Voir le contenu du fichier</h4>
            <?php
            $haproxy = new Haproxy('haproxy.local');
            echo nl2br($haproxy->getcontent());
            ?>
        </div>
        <div class="col-sm-6">
            reste
        </div>
    </div>
</main>

<div id="show_file" class="col-sm-6">
    <h4>Voir le contenu du fichier</h4>
    <?php
    $haproxy = new Haproxy('haproxy.local');
    //echo nl2br($haproxy->getcontent());
    echo $haproxy->getFront();
    ?>
</div>
<div class="col-sm-6">
    reste
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>