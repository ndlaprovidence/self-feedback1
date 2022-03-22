<?php 

namespace App\Tests\Form\Type;

$client = static::createClient();
$client->request('GET', '/user/');

class TestedTypeTest 
{
    public function testSubmitValidData()
    {
        $formData = [
            'inputUsername' => 'admin@jmail.com',
            'password' => '123456789Az.',
        ];

        $client->submitForm($formData);

    }

    public function testSubmitInValidData()
    {
        $formData = [
            'inputUsername' => 'test',
            'password' => 'test2',
        ];

        $client->submitForm($formData);($formData);

    }


}