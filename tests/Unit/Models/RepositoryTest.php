<?php

namespace Tests\Unit\Models;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

     use RefreshDatabase;

    public function test_belongs_to_user()
    {
       $repository = Repository::factory()->create();
       $this->assertInstanceOf(User::class, $repository->user);

    }

    
}
