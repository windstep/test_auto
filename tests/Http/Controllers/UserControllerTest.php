<?php

namespace Http\Controllers;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        User::factory()->create();
    }

    public function testGet()
    {
        $response = $this->get('/api/users');
        $response->seeJsonStructure(["data" => [['id', 'name', 'created_at', 'updated_at']]]);
    }
}