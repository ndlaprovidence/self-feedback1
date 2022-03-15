<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testValidData(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $formData = [
            'inputUsername' => 'admin@jmail.com',
            'password' => '123456789Az.',
        ];

        $this->client->submitForm($formData);

        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Hello World');
    }

    public function testValidData(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $formData = [
            'inputUsername' => 'admin@jmail.com',
            'password' => '123456789Az.',
        ];

        $this->client->submitForm($formData);

        $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Hello World');
    }
    
}
