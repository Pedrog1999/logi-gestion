<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Jwt extends BaseConfig
{
    public string $secret = '';
    public int $ttl = 7200;
    public string $issuer = 'app-backend';
}