<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function create(array $attributes);

    public function findById(int $id);

    public function findMany(array $ids): Collection;

    public function update(int $id, array $attributes);

    public function count();
}
