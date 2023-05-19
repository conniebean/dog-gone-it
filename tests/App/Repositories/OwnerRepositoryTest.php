<?php

namespace App\Repositories;

use App\Models\Owner;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OwnerRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    private OwnerRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->owner = new Owner([
            'name' => 'Jane Doe',
            'address' => '123 Fake Street',
            'email' => 'email@email.com',
            'phone_number' => '519-456-6789'
        ]);
        $this->owner->save();

        $this->repository = $this->app->get(OwnerRepository::class);
    }

    public function test_it_can_add_an_owner()
    {
        $owner = $this->owner;

        $record = DB::table('owners')
            ->where('id', $owner->id)->first();

        self::assertEquals($record->name, $owner->name);
    }
}
