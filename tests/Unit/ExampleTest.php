<?php

namespace Tests\Unit;
use App\User;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = \App\Models\User::factory()->make();
//
//        $response = $this->actingAs($user)
//        $response = $this->actingAs($user)
//            ->withSession(['foo' => 'bar'])
//            ->get('/');
        $this->actingAs(\App\Models\User::factory()->make());
        $this->assertTrue(true);
//        $this->assertResponseOk();
//        $user = factory(User::class)->create();
    }
}
