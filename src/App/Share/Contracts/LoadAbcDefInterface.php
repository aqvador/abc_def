<?php

namespace App\Share\Contracts;

interface LoadAbcDefInterface
{
    public function handle(string $parseUrl): void;
}