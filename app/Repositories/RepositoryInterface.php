<?php
namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get all
     * @param $limit
     * @return mixed
     */
    public function getLimitList($limit = 15);

    public function getItem($id);

    public function getFillable();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = []);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, $attributes = []);

    /**
     * Upsert: Create and Update
     * @param array $attributes
     * @param $id
     * @return mixed
     */
    public function upsert($attributes = [], $id = null);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);

    public function userAdmin();
    public function user();
}
