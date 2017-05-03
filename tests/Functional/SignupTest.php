<?php

namespace Tests\Functional;

class SignupTest extends BaseTestCase
{
    /**
     * Test that a user can succesfully be created
     */
    public function testCreateUser()
    {
        $response = $this->runApp('POST', '/user/signup', [ 
            'username' => 'unittester',
            'email' => 'unt@tester.com',
            'password' => '1234567'
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals("/user", $response->getHeaderLine("Location"));
    }

    /**
     * Test that a user is not succesfully created when there is an error.
     */
    public function testFailCreateUser()
    {
        $response = $this->runApp('POST', '/user/signup', [ 
            'username' => 'unittester',
            'email' => 'unt@tester.com',
            'password' => '123'
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertContains('must have a length greater than 7', (string)$response->getBody());
    }
}