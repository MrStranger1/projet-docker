<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Test haproxy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="assets/bootstrap.css">
        <style>
            *{
                box-sizing: border-box;
            }
            body, html{
                padding: 0; margin: 0;
                border: 0;
                height: 100%; width: 100%;
            }
            .container{
                font-size:1.4em;margin:80px auto;
            }
            .add-srv{
                cursor: pointer; font-size:1.2rem;
            }
            span[class!='add-srv']{
                display: none;
            }
        </style>
    </head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href=".">Home</a>
    <a class="navbar-brand" href="fichier.php">Voir fichier</a>
</nav>
<?php require 'Haproxy.php'; ?>

<main role="main" class="container">
    <div class="row">
        <h1>Ajouter une nouvelle redirection...</h1><br><br>
        <form action="#" class="col-sm-12" method="post" id="form-send">
            <div id="site_message"></div>
            <div class="form-group">
                <label for="site_nom_0">Nom de domaine de votre site</label>
                <input type="text" class="form-control" id="site_nom_0" name="site_nom_0" placeholder="votressite.com">
                <span id="help-site_nom_0"></span>
            </div>
            <div class="form-group">
                <label for="site_nom_serveur_0">Nom de votre serveur</label>
                <input type="text" class="form-control" id="site_nom_serveur_0" name="site_nom_serveur_0" placeholder="nomserveur">
                <span id="help-site_nom_serveur_0"></span>
            </div>
            <div class="form-group add-srv-form">
                <div class="site_ajouter_adresse">
                    <label for="site_adresse_ip_0">Adresse IP du container et port d'écoute de l'application</label>
                    <input type="text" class="form-control" id="site_adresse_ip_0" name="site_adresse_ip_0" placeholder="172.18.0.15:80">
                    <span id="help-site_adresse_ip_0"></span>
                </div>
                <span class="add-srv">+ Ajouter un autre serveur</span>
            </div>
            <div class="form-group">
                <label for="site_nombre_connexion_0">Nombre de connexion maximum</label>
                <input type="number" class="form-control" id="site_nombre_connexion_0" name="site_nombre_connexion_0" placeholder="300">
                <span id="help-site_nombre_connexion_0"></span>
            </div>
            <div class="form-group">
                <button type="submit" name="send" class="btn btn-primary btn-lg">Créer la rédirection</button>
            </div>
        </form>
    </div>
</main>

<script src="assets/jquery.js"></script>
<script src="assets/bootstrap.js"></script>
<script src="assets/index.js"></script>
</body>
</html>