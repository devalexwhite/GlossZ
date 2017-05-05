<?php

namespace Tests\Functional;

class GlossaryTest extends BaseTestCase
{
    /**
     * Test that a user can succesfully be created
     */
    public function testLogin()
    {
        $response = $this->runApp('POST', '/user/signup', [ 
            'username' => 'unittester',
            'email' => 'unt@tester.com',
            'password' => '1234567'
        ]);

        $response = $this->runApp('POST', '/user/login', [ 
            'username' => 'unittester',
            'password' => '1234567'
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('logout', (string)$response->getBody());
    }
}