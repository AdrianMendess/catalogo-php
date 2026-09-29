<?php

namespace App\Repositories;

use App\Database\Connection;
use App\Models\User;
use PDO;
class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Connection::get();
    }
   
    
    
}
