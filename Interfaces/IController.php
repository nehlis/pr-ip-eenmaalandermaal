<?php

namespace Interfaces;

/**
 * Interface IController
 */
interface IController
{
    /**
     * Returns a list of the resource.
     * @return array
     */
    public function index(): array;
    
    /**
     * Creates an entry for the model.
     * @param array $model
     * @return void
     */
    public function create(array $model): void;
    
    /**
     * Gets the selected ID from the model.
     * @param int $id
     * @return IModel
     */
    public function get(int $id);
    
    /**
     * Put's the selected ID from the model.
     * @param array $args
     * @param int $id
     * @return IModel
     */
    public function put(array $args, int $id);
    
    /**
     * Removes a certain index from the model.
     * @param int $id
     */
    public function delete(int $id): void;
}