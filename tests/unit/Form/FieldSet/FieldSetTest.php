<?php


	namespace LiftKit\Tests\Unit\Form\FieldSet;

	use LiftKit\Form\FieldSet\FieldSet;
	use LiftKit\Form\Field\Field;
	use LiftKit\Form\Validator\RuleSet\RuleSet;
	use LiftKit\Form\Validator\Rule\Rule;
	use LiftKit\Form\Validator\Validator;
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


		/**
		 * @expectedException \LiftKit\Form\Validator\Rule\Exception\Validation
		 */
		public function testExecuteValidates ()
		{
			$input = new Request([]);
			$ruleSet = new RuleSet;

			$ruleSet->setRule('required', new Rule(
				function ($value)
				{
					return (bool) $value;
				},
				'The field is required'
			));

			$element = new Field;
			$element->setValidator(
				new Validator(
					$ruleSet,
					'required'
				)
			);

			$this->fieldSet->attachElement($element);

			$this->fieldSet->execute($input);
		}
	}