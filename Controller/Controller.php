<?php

namespace Flux\Controller;
use Flux\Core\Database\QueryBuilder as DB;


class Controller
{
    public function __construct()
    {
        $this->db = new DB;
    }
}