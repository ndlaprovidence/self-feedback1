// tests/Form/Type/TestedTypeTest.php
namespace App\Tests\Form\Type;

use App\Form\Type\TestedType;
use App\Model\TestObject;
use Symfony\Component\Form\Test\TypeTestCase;

class TestedTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'test' => 'test',
            'test2' => 'test2',
        ];

        $model = new TestObject();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TestedType::class, $model);

        $expected = new TestObject();
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }

    public function testCustomFormView()
    {
        $formData = new TestObject();
        // ... prepare the data as you need

        // The initial data may be used to compute custom view variables
        $view = $this->factory->create(TestedType::class, $formData)
            ->createView();

        $this->assertArrayHasKey('custom_var', $view->vars);
        $this->assertSame('expected value', $view->vars['custom_var']);
    }
}