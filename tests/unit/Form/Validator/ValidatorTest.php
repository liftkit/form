<?php

	namespace LiftKit\Tests\Unit\Form\Validator;


	use LiftKit\Form\Validator\Validator;
	use LiftKit\Form\Validator\RuleSet\RuleSet;
	use LiftKit\Form\Validator\Rule\Rule;

	use PHPUnit_Framework_TestCase;


	class ValidatorTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var RuleSet
		 */
		protected $ruleset;


		public function setUp ()
		{
			$ruleset = new RuleSet;

			$ruleset->setRule('required', $this->createRequiredRule());
			$ruleset->setRule('trim', $this->createTrimRule());
			$ruleset->setRule('regex', $this->createRegexRule());

			$this->ruleset = $ruleset;
		}


		public function testRequiredPasses ()
		{
			$validator = new Validator(
				$this->ruleset,
				'required',
				'required field'
			);

			$value = 'not empty';

			$validator->validate($value);
		}


		public function testEmptyRule ()
		{
			$validator = new Validator(
				$this->ruleset,
				'',
				'required field'
			);

			$value = '';

			$validator->validate($value);
		}


		/**
		 * @expectedException \LiftKit\Form\Validator\Rule\Exception\Validation
		 */
		public function testAddRule ()
		{
			$validator = new Validator(
				$this->ruleset,
				'',
				'required field'
			);

			$validator->addRule('required');

			$value = '';

			$validator->validate($value);
		}


		/**
		 * @expectedException \LiftKit\Form\Validator\Rule\Exception\Validation
		 */
		public function testRequiredFails ()
		{
			$validator = new Validator(
				$this->ruleset,
				'required',
				'required field'
			);

			$value = '';

			$validator->validate($value);
		}


		public function testMultipleRules ()
		{
			$validator = new Validator(
				$this->ruleset,
				'required|trim',
				'required field'
			);

			$value = ' spaces ';

			$validator->validate($value);

			$this->assertEquals(
				$value,
				'spaces'
			);
		}


		public function testRuleWithArgumentsPasses ()
		{
			$validator = new Validator(
				$this->ruleset,
				'regex(#test#)',
				'required field'
			);

			$value = ' test ';

			$validator->validate($value);
		}


		/**
		 * @expectedException \LiftKit\Form\Validator\Rule\Exception\Validation
		 */
		public function testRuleWithArgumentsFails ()
		{
			$validator = new Validator(
				$this->ruleset,
				'regex(#test#)',
				'required field'
			);

			$value = 'xyz';

			$validator->validate($value);
		}


		public function testEscapedRule ()
		{
			$validator = new Validator(
				$this->ruleset,
				'regex(' . Validator::escapeArgument('#^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$#') . ')',
				'required field'
			);

			$value = 'jim@google.com';

			$validator->validate($value);
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


		protected function createTrimRule ()
		{
			return new Rule(
				function (& $value)
				{
					$value = trim($value);

					return true;
				}
			);
		}


		protected function createRegexRule ()
		{
			return new Rule(
				function ($value, $pattern)
				{
					return (bool) preg_match($pattern, $value);
				},
				'The ' . Rule::DEFAULT_PLACEHOLDER . ' field is not formatted correctly.'
			);
		}
	}