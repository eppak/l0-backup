<?php namespace Eppak\Contracts;


interface Dumper
{
    public function dump(string $filename): bool;
    public function name(): string;
}
