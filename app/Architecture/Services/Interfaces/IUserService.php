<?php

namespace App\Architecture\Services\Interfaces;

interface IUserService
{
    public function index();
    public function list();
    public function store(array $data);

}
