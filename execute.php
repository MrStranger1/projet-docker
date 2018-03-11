<?php
//Recuperation des donnée
$site_nom_0                  = trim($_POST['site_nom_0']);
$site_nom_serveur_0          = trim($_POST['site_nom_serveur_0']);
$site_adresse_ip_0           = trim($_POST['site_adresse_ip_0']);
$site_nombre_connexion_0     = (int) trim($_POST['site_nombre_connexion_0']);
$data = array();
$backends = [];
$frontends = [];

// vérification du nom de domaine
if (empty($site_nom_0) || !preg_match('/^[a-z0-9-_\.]+.(com|fr|net|org)$/i', $site_nom_0)){
    $data['champ'] = 'site_nom_0';
    $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond pas à un nom nom de domaine valide</div>';
}else {
    // vérification du nom du serveur
    if (empty($site_nom_serveur_0) || !preg_match('/^[a-z_-]+$/' , $site_nom_serveur_0)) { // nom_serveur
        $data['champ'] = 'site_nom_serveur_0';
        $data['error'] = '<div class="alert alert-warning">Seul des caractères alphabétiques, tirets et underscores sont autorisés</div>';
    } else {
        // verification de l'adresse ip
        if (empty($site_adresse_ip_0) || !preg_match('/^[0-9]{3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{2,}$/' , $site_adresse_ip_0)) {
            $data['champ'] = 'site_adresse_ip_0';
            $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip et son port</div>';
        } else {

            // vérification du nombre maximum de connexion
            if (empty($site_nombre_connexion_0) || !filter_var($site_nombre_connexion_0 , FILTER_VALIDATE_INT)) {
                $data['champ'] = 'site_nombre_connexion_0';
                $data['error'] = '<div class="alert alert-warning">Le nombre maximum de connexion doit être un nombre entier</div>';
            } else {
                require 'Haproxy.php';
                $haproxy = new Haproxy('haproxy.local' , $site_nom_0 , $site_nom_serveur_0 , $site_adresse_ip_0 , $site_nombre_connexion_0);
                $data['code'] = 'ok';
                $backends[0] = $haproxy->createBackend();
                $frontends[0] = $haproxy->createFrontend();

                // quand c'est bon
                $data['0'] = $haproxy->getFront();
                $haproxy->addBackendFile($backends[0]);
                //$haproxy->addBackendFile($frontends[0]);
                $data['error'] = '<div class="alert alert-success">Tous est bon</div>';            }
        }
    }
}
echo json_encode($data);