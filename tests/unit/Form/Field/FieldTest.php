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


		public function testSetAttribute ()
		{
			$this->field->setAttribute('test', 1);

			$this->assertEquals(
				$this->field->getAttribute('test'),
				1
			);

			$this->assertEquals(
				$this->field->getAttributes(),
				array('test' => 1)
			);
		}


		public function testGetAttributesString ()
		{
			$this->field->setAttribute('test', 1);
			$this->field->setAttribute('another', '1&2');

			$this->assertEquals(
				trim($this->field->getAttributesString()),
				'test="1" another="1&amp;2"'
			);
		}


		public function testValidatorPasses ()
		{
			$ruleset = new RuleSet;
			$ruleset->setRule('required', $this->createRequiredRule());

			$validator = new Validator(
				$ruleset,
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
			$ruleset = new RuleSet;
			$ruleset->setRule('required', $this->createRequiredRule());

			$validator = new Validator(
				$ruleset,
				'required',
				'required field'
			);

			$value = '';

			$this->field->setValidator($validator);
			$this->field->setValue($value);

			$this->field->validate();
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