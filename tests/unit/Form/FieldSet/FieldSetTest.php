<?php


	namespace LiftKit\Tests\Unit\Form\FieldSet;

	use LiftKit\Form\FieldSet\FieldSet;
	use LiftKit\Form\Field\Field;
	use LiftKit\Request\Http as Request;

	use PHPUNIT_Framework_TestCase;


	class FieldSetTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var FieldSet
		 */
		protected $fieldSet;



		public function setUp ()
		{
			$this->fieldSet = new FieldSet;
		}


		public function testAddRemoveElement ()
		{
			$element = new Field;

			$this->fieldSet->addElement('element', $element);

			$this->assertSame(
				$this->fieldSet->getElement('element'),
				$element
			);

			$this->assertEquals(
				$this->fieldSet->getElements(),
				array('element' => $element)
			);

			$this->fieldSet->removeElement('element');

			$this->assertEquals(
				$this->fieldSet->getElements(),
				array()
			);
		}


		public function testAttachClearElements ()
		{
			$field1 = new Field;
			$this->fieldSet->attachElement($field1);

			$field2 = new Field;
			$field3 = new Field;

			$this->fieldSet->attachElements($field2, $field3);

			$this->assertEquals(
				array_values($this->fieldSet->getElements()),
				array(
					$field1,
					$field2,
					$field3
				)
			);

			$this->fieldSet->clearElements();

			$this->assertEquals(
				$this->fieldSet->getElements(),
				array()
			);
		}


		public function testExecute ()
		{
            $input = new Request([]);

			$element = $this->getMockBuilder('\LiftKit\Form\Field\Field')
                 ->setMethods(array('execute'))
                 ->getMock();

            $element->expects($this->once())
            	->method('execute')
            	->with($this->identicalTo($input));

            $this->fieldSet->attachElement($element);

            $this->fieldSet->execute($input);
		}
	}