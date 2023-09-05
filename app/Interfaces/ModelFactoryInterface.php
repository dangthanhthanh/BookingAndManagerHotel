<?php

namespace App\Interfaces;
interface ModelFactoryInterface
{
    public function createModel(string $table);
}