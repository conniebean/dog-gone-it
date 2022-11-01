<?php

namespace App\Repositories;

use App\Models\Owner;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class OwnerRepository implements RepositoryInterface
{

    public function create(array $attributes)
    {
        $owner = new Owner($attributes);
        $owner->save();

        return $this->findById($owner->id);
    }

    public function findById(int $id): ?Owner
    {
        if(!$record = $this->getQuery()->where('id', $id)->first())
        {
            return null;
        }
        return $record;
    }

    public function findMany(array $ids): Collection
    {
        $allOwners = $this->getQuery()->whereIn('id', $ids);

        return collect($allOwners);
    }

    public function update(int $id, array $attributes)
    {
        // TODO: Implement update() method.
    }

    public function count()
    {
        // TODO: Implement count() method.
    }

    protected function getQuery(): Builder
    {
        return Owner::query();
    }
}
