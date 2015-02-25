<?php

	namespace LiftKit\Tests\Unit\Form\Validator\Rule;

	use LiftKit\Form\Validator\Rule\Rule;
	use PHPUnit_Framework_TestCase;


	class FormBuilder_Validator_Rule_Test extends PHPUnit_Framework_TestCase
	{


		public function setUp ()
		{

		}


		/**
		 * @expectedException \LiftKit\Form\Validator\Rule\Exception\InvalidCallback
		 */
		public function testInvalidRule ()
		{
			new Rule(null);
		}


		public function testRequiredPasses ()
		{
			$rule = $this->createRequiredRule();
			$value = 'info';

			$rule->validate($value, 'field');
		}


		/**
		 * @expectedException \LiftKit\Form\Validator\Rule\Exception\Validation
		 */
		public function testRequiredFails ()
		{
			$rule = $this->createRequiredRule();
			$value = '';

			$rule->validate($value, 'field');
		}


		public function testTrim ()
		{
			$rule = $this->createTrimRule();

			$value = ' spaces ';
			$rule->validate($value);

			$this->assertEquals($value, 'spaces');
		}


		public function testRegexPasses ()
		{
			$rule = $this->createRegexRule();

			$value = 'adasdtest';
			$pattern = '#test#';

			$rule->validate($value, 'match', array($pattern));
		}


		/**
		 * @expectedException \LiftKit\Form\Validator\Rule\Exception\Validation
		 */
		public function testRegexFails ()
		{
			$rule = $this->createRegexRule();

			$value = 'adasdtest';
			$pattern = '#xyz#';

			$rule->validate($value, 'match', array($pattern));
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
				}
			);
		}
	}