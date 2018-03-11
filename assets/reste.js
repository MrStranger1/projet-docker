
#fin_f
^[a-z-_]+\n+\t+[a-z -_().]+

if (isset($_POST['site_adresse_ip_1']) && $haproxy->checkIP($_POST['site_adresse_ip_1'])){
    $data['1'] = $haproxy->createBackupServer($_POST['site_adresse_ip_1'], $_POST['backup_1']);
}else{
    $data['champ'] = 'site_adresse_ip_1';
    $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip et son port</div>';
}
if (isset($_POST['site_adresse_ip_2']) && $haproxy->checkIP($_POST['site_adresse_ip_2'])){
    $data['2'] = $haproxy->createBackupServer($_POST['site_adresse_ip_2'], $_POST['backup_2']);
}else{
    $data['champ'] = 'site_adresse_ip_2';
    $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip et son port</div>';
}
if (isset($_POST['site_adresse_ip_3']) && $haproxy->checkIP($_POST['site_adresse_ip_3'])){
    $data['3'] = $haproxy->createBackupServer($_POST['site_adresse_ip_3'], $_POST['backup_3']);
}else{
    $data['champ'] = 'site_adresse_ip_3';
    $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip et son port</div>';
}


if (empty($_POST['site_adresse_ip_1']) || !preg_match('/^[0-9]{3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{2,}$/', $_POST['site_adresse_ip_1'])){
    $data['champ'] = 'site_adresse_ip_87';
    $data['error'] = '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip et son port</div>';
}else {
    $data['error'] = 'j c pas';
}

if ($haproxy->checkSrvBackup('site_adresse_ip_2')){ // premier input ip 2
    $data['sueper'] = $haproxy->createBackupServer($_POST['site_adresse_ip_2'], $_POST['backup_2'] ?? null );
}else{
    $data['champ']  =    "site_adresse_ip_2";
    $data['error']  =    '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip et son port</div>';
}
if ($haproxy->checkSrvBackup('site_adresse_ip_3')){ // premier input ip 3
    $data['sueper'] = $haproxy->createBackupServer($_POST['site_adresse_ip_3'], $_POST['backup_3'] ?? null );
}else{
    $data['champ']  =    "site_adresse_ip_3";
    $data['error']  =    '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip et son port</div>';
}

if ($haproxy->checkSrvBackup('site_adresse_ip_1')){ // premier input ip 1
    $data['code'] = 'Ok';
    $backends['0'] = $haproxy->createBackupServer($_POST['site_adresse_ip_1'], $_POST['backup_1'] ?? null );
}else{
    $data['code'] = 'de';
    $data['champ']  =    "site_adresse_ip_1";
    $data['error']  =    '<div class="alert alert-warning">Ce champs ne correspond à une adresse ip et son port</div>';
}


global
log /dev/log    local0
log /dev/log    local1 notice
chroot /var/lib/haproxy
stats socket /run/haproxy/admin.sock mode 660 level admin
stats timeout 30s
user haproxy
group haproxy
daemon
        # Default SSL material locations
ca-base /etc/ssl/certs
crt-base /etc/ssl/private

        # Default ciphers to use on SSL-enabled listening sockets.
        # For more information, see ciphers(1SSL). This list is from:
    #  https://hynek.me/articles/hardening-your-web-servers-ssl-ciphers/
    # An alternative list with additional directives can be obtained from
        #  https://mozilla.github.io/server-side-tls/ssl-config-generator/?server=haproxy
    ssl-default-bind-ciphers ECDH+AESGCM:DH+AESGCM:ECDH+AES256:DH+AES256:ECDH+AES128:DH+AES:RSA+AESGCM:RSA+AES:!aNULL:!MD5:!DSS
ssl-default-bind-options no-sslv3

defaults
log     global
mode    http
option  httplog
option  dontlognull
stats enable
stats uri /stats
stats auth silence:silence
timeout connect 500000
timeout client  500000
timeout server  500000
errorfile 400 /etc/haproxy/errors/400.http
errorfile 403 /etc/haproxy/errors/403.http
errorfile 408 /etc/haproxy/errors/408.http
errorfile 500 /etc/haproxy/errors/500.http
errorfile 502 /etc/haproxy/errors/502.http
errorfile 503 /etc/haproxy/errors/503.http
errorfile 504 /etc/haproxy/errors/504.http

#front
frontend http
bind *:80
mode http
option httplog
acl nom_acl hdr(host) notresite.com
use_backend nom_backend if  nom_acl
    #addfr

#back
backend nom_backend
mode http
option httpchk
option forwardfor except 127.0.0.1
http-request add-header X-Forwarded-Proto https if { ssl_fc }
    server nom_serveur 192.168.1.12:80 maxconn 32backend mon-site_http