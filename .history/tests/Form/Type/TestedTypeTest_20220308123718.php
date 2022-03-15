<?php 

namespace App\Tests\Form\Type;

$client = static::createClient();
$client->request('GET', '/post/hello-world');

class TestedTypeTest 
{
    public function testSubmitValidData()
    {
        $formData = [
            'inputUsername' => 'admin@jmail.com',
            'password' => '123456789Az.',
        ];

        $form = ;

        $form->submit($formData);

    }

    public function testSubmitInValidData()
    {
        $formData = [
            'inputUsername' => 'test',
            'password' => 'test2',
        ];

        $form = ;

        $form->submit($formData);

    }


}