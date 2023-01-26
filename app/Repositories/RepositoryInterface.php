<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getItems();
    public function setItems($items);
    public function setMessage(String $message);
    public function getMessage();
    public function hasError(): Bool;
}
