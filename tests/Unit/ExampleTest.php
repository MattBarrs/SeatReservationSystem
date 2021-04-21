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
        $this->assertTrue(true);
        public function testApplication()
        {
            $user = factory(User::class)->create();

            $response = $this->actingAs($user)
                ->withSession(['foo' => 'bar'])
                ->get('/');
        }
    }
}
