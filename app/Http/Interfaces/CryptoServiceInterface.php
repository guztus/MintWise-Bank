<?php

namespace App\Http\Interfaces;

interface CryptoServiceInterface
{
    public function getSingle(string $symbol): object;
    public function getList(): array;
}
