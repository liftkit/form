<?php

	namespace LiftKit\Tests\Unit\Form\Field;

	use LiftKit\Form\Field\Field;

	use LiftKit\Form\Validator\Validator;
	use LiftKit\Form\Validator\RuleSet\RuleSet;
	use LiftKit\Form\Validator\Rule\Rule;

	use PHPUnit_Framework_TestCase;


	class FieldTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var Field
		 */
		protected $field;


		public function setUp ()
		{
			$this->field = new Field;
		}


		public function testSetGetName ()
		{
			$this->field->setName('test');

			$this->assertEquals(
				$this->field->getName(),
				'test'
			);
		}


		public function testSetGetValue ()
		{
			$value = 'test';

			$this->field->setValue($value);

			$this->assertSame(
				$this->field->getValue(),
				$value
			);
		}


		public function testSetGetLabel ()
		{
			$label = 'test';

			$this->field->setLabel($label);

			$this->assertEquals(
				$this->field->getLabel(),
				$label
			);
		}


		public function testValidatorPasses ()
		{
			$ruleSet = new RuleSet;
			$ruleSet->setRule('required', $this->createRequiredRule());

			$validator = new Validator(
				$ruleSet,
				'required',
				'required field'
			);

			$value = 'value';

			$this->field->setValidator($validator);
			$this->field->setValue($value);

			$this->field->validate();
		}


		/**
		 * @expectedException \LiftKit\Form\Validator\Rule\Exception\Validation
		 */
		public function testValidatorFails ()
		{
			$ruleSet = new RuleSet;
			$ruleSet->setRule('required', $this->createRequiredRule());

			$validator = new Validator(
				$ruleSet,
				'required',
				'required field'
			);

			$value = '';

			$this->field->setValidator($validator);
			$this->field->setValue($value);

			$this->field->validate();
		}


		public function testSetGetValidator ()
		{
			$ruleSet = new RuleSet;
			$ruleSet->setRule('required', $this->createRequiredRule());

			$validator = new Validator(
				$ruleSet,
				'required',
				'required field'
			);

			$this->field->setValidator($validator);

			$this->assertSame(
				$validator,
				$this->field->getValidator()
			);
		}


		protected function createRequiredRule ()
		{
			return new Rule(
				function ($value)
				{
					return (bool) $value;
				},
				'The ' . Rule::DEFAULT_PLACEHOLDER . ' field is required.'
			);
		}
	}