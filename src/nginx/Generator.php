<?php
/**
 * Created by PhpStorm.
 * User: naffiq
 * Date: 5/25/17
 * Time: 15:51
 */

namespace naffiq\RocketTools\nginx;


class Generator
{
    private $documentRoot;

    private $serverName;

    private $port;

    private $phpFpm;

    public function __construct($documentRoot, $serverName, $port = 80, $phpFpm = [
        'isSocket' => true, 'socketPath' => 'unix:/var/run/php7.1-fpm.sock'
    ])
    {
        $this->documentRoot = $documentRoot;
        $this->serverName = $serverName;
        $this->port = $port;
        $this->phpFpm = $phpFpm;
    }

    public function getConfig()
    {
        return <<<CONF
server {
    listen $this->port;
   
    
    set \$host_path "$this->documentRoot";
    set \$yii_bootstrap "index.php";
  
    root \$host_path;


    client_max_body_size 128m;
    charset utf-8;

    server_name $this->serverName;

    location / {
        try_files \$uri \$uri/ /index.php?\$args;
        index index.php;
    }

    location ~ \.php {
        fastcgi_split_path_info  ^(.+\.php)(.*)$;

        set \$fsn /\$yii_bootstrap;
        if (-f \$document_root\$fastcgi_script_name){
            set \$fsn \$fastcgi_script_name;
        }

        fastcgi_pass unix:/var/run/php7.1-fpm.sock;
        include fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME  \$document_root\$fsn;

        fastcgi_param  PATH_INFO        \$fastcgi_path_info;
        fastcgi_param  PATH_TRANSLATED  \$document_root\$fsn;
    }

    location ~ /\.(ht|svn|git) {
        deny all;
    }
    location ~ \..*/.*\.php$ {
        return 403;
    }
}
CONF;
    }
}