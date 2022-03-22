<?php 

namespace App\Tests\Form\Type;


class TestedTypeTest 
{

    $client = null;

    public __construct() {
        $this->client = static::createClient();        
    }

    public function testSubmitValidData()
    {
        $this->client->request('GET', '/user');
        $formData = [
            'inputUsername' => 'admin@jmail.com',
            'password' => '123456789Az.',
        ];

        $this->client->submitForm($formData);

    }

    public function testSubmitInValidData()
    {
        $formData = [
            'inputUsername' => 'test',
            'password' => 'test2',
        ];

        $client->submitForm($formData);

    }


}