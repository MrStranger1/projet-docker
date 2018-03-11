<?php

/**
 * Class Haproxy
 */
class Haproxy
{
    /**
     * @var string nom du site
     */
    private $site_nom;
    /**
     * @var string nom du serveur
     */
    private $site_nom_serveur;
    /**
     * @var string adresse ip du serveur
     */
    private $site_adresse_ip;
    /**
     * @var int nombre de connexion maximum accepter
     */
    private $site_nombre_connexion;
    /**
     * @var string nom du fichier a remplir
     */
    private $filename;
    /**
     * @var adresse ip serveur de backup
     */
    private $srv_ip_backup;

    /**
     * @var backup active
     */
    private $backup_bool;


    /**
     * Haproxy constructor.
     * @param string $filename
     * @param string $site_nom
     * @param string $site_nom_serveur
     * @param string $site_adresse_ip
     * @param int $site_nombre_connexion
     */
    public function __construct(string $filename, string $site_nom, string $site_nom_serveur, string $site_adresse_ip, int $site_nombre_connexion)
    {
        $this->filename                 =  $filename;
        $this->site_nom                 = $site_nom;
        $this->site_nom_serveur         = $site_nom_serveur;
        $this->site_adresse_ip          = $site_adresse_ip;
        $this->site_nombre_connexion    = $site_nombre_connexion;
    }

    /**
     * @param string $backend
     */
    public function addBackendFile(string $backend)
    {
        file_put_contents($this->filename, $backend, FILE_APPEND);
    }


    /**
     * @return bool|string
     */
    private function getcontent()
    {
        return file_get_contents($this->filename);
    }


    /**
     * @return string
     */
    public function getFront()
    {
        $data = array();
       if(preg_match_all("/#addfr/",  $this->getcontent(), $matches)){
           $data['e'] = preg_replace("/#addfr/", "tamere la pute", $this->getcontent());
           return $data['e'];
       }
        return false;
        //if(preg_replace("/#addfr/", "tamere la pute", $this->getcontent())){
        //}

        //return $this->getcontent();
    }

    /**
     * @return string
     */
    public function createFrontend()
    {
        $acl = "\n\t\tacl " .$this->createAcl($this->site_nom). '_acl hdr(host) ' .$this->site_nom."\n\t\t";
        $acl .= 'use_backend '.$this->createAcl($this->site_nom).'_http if '.$this->createAcl($this->site_nom)."_acl \n\t\t";
        return $acl;
    }

    /**
     * @param string $nom_serveur
     * @param string $socket_serveur
     * @param int $maxconn_serveur
     * @param $backup_serveur
     * @return string
     */
    public function createServer(string $nom_serveur, string $socket_serveur, int $maxconn_serveur, $backup_serveur = null)
    {
        return "server $nom_serveur $socket_serveur maxconn $maxconn_serveur $backup_serveur";
    }

    /**
     * @param string $server_ip
     * @param string|null $server_backup
     * @return string
     */
    public function createBackupServer(string $server_ip, string $server_backup = null)
    {
        if (isset($server_backup)){
            $this->backup_bool = 'backup';
        }
        $this->srv_ip_backup =  $server_ip;
        $nbr_srv = rand(1, 5);
        return "server " .$this->site_nom_serveur.$nbr_srv." " . $this->srv_ip_backup . " maxconn " .$this->site_nombre_connexion . " " .$this->backup_bool ;
    }

    /**
     * @return string
     */
    public function createBackend()
    {
        $back = " \n\n backend ".$this->createAcl($this->site_nom)."_http
        mode http
        option httpchk
        option forwardfor except 127.0.0.1
        http-request add-header X-Forwarded-Proto https if { ssl_fc } \n\t\t" .
            $this->createServer($this->site_nom_serveur, $this->site_adresse_ip, $this->site_nombre_connexion);
        return $back;
    }


    /**
     * @param string $site_nom_domain
     * @return mixed
     */
    private function createAcl(string $site_nom_domain)
    {
        preg_match('/^[a-z-_]+/', $site_nom_domain, $matches);
        return $matches[0];
    }

    /**
     * @param string $adress_ip
     * @return bool
     */
    private function checkIP(string $adress_ip)
    {
        if (!preg_match('/^[0-9]{3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{2,}$/', $adress_ip)){
            return false;
        }
        return true;
    }

    /**
     * @param string $site_ip
     * @return bool
     */
    public function checkSrvBackup(string $site_ip)
    {
        if (isset($_POST[$site_ip])){
            if(empty($_POST[$site_ip]) || !$this->checkIP($_POST[$site_ip])) {
                return false;
            }
            return true;
        }
    }


}