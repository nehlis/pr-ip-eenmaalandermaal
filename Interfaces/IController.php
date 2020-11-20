<?php

namespace Interfaces;

/**
 * Interface IController
 * @package Interfaces
 */
interface IController
{
    /**
     * create
     * @param   array   $data   Associative array of which the key represents the column name.
     * @return  array           Returns row when creation was successful.
     * @throws  Error           Throws error when execution failed.
     */
    public function create(array $data): array;

    /**
     * get
     * @param   int      $id    Row with ID.
     * @return  array           Returns row when fetch was successful.
     * @throws  Error           Throws error when execution failed.
     */
    public function get(int $id): array;

    /**
     * index
     * @return  array   Returns all rows when fetch was successful.
     * @throws  Error   Throws error when execution failed.
     */
    public function index(): array;

    /**
     * update 
     * @param   int     $id     Row with ID?
     * @param   array   $data   Associative array of which the key is the column name to be updated with its value.
     * @throws  Error           Throws error when execution failed.
     */
    public function update(int $id, array $data): array;

    /**
     * delete 
     * @param   int     $id     Row with ID?
     * @throws  Error           Throws error when execution failed.
     */
    public function delete(int $id): array;
}
