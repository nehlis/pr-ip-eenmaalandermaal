<?php

namespace App\Interfaces;

use Error;

/**
 * Interface IController
 * @package Interfaces
 */
interface IController
{
    /**
     * Creates an entry in the specified resource.
     * @param  array $data Associative array of which the key represents the column name.
     * @return array       Returns row when creation was successful.
     * @throws Error       Throws error when execution failed.
     */
    public function create(array $data): ?array;

    /**
     * Gets an entry in the specified resource.
     * @param  int   $id ID of the column to get.
     * @return array     Returns row when fetch was successful.
     * @throws Error     Throws error when execution failed.
     */
    public function get(int $id): ?array;

    /**
     * Indexes all of specified resource.
     * @return  array|null All rows or null.
     */
    public function index(): ?array;
    
    /**
     * Updates an entry in the specified resource.
     * @param int   $id   ID of the column to update.
     * @param array $data Associative array of which the key is the column name to be updated with its value.
     * @return array|null The updated resource or null on fail.
     */
    public function update(int $id, array $data): ?array;
    
    /**
     * Deletes an entry in the specified resource.
     * @param int $id     ID of the column to delete.
     * @return array|null The result or null.
     */
    public function delete(int $id): ?array;
}
