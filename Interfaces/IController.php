<?php

namespace Interfaces;

/**
 * Interface IController
 */
interface IController
{
    public function create(array $data): void;


    public function get(int $id): array;


    public function index(): array;


    public function update(int $id, array $data): void;


    public function delete(int $id): void;
}
