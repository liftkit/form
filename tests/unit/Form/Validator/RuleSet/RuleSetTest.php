<?php

	namespace LiftKit\Tests\Unit\Form\Validator\RuleSet;

	use LiftKit\Form\Validator\RuleSet\RuleSet;
	use LiftKit\Form\Validator\Rule\Rule;

	use PHPUnit_Framework_TestCase;


	class RuleSetTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var RuleSet
		 */
		protected $ruleSet;


		public function setUp ()
		{
			$this->ruleSet = new RuleSet;
		}


		public function testSetGetRule ()
		{
			$rule = $this->createMockRule();

			$this->ruleSet->setRule('test', $rule);

			$this->assertSame(
				$this->ruleSet->getRule('test'),
				$rule
			);
		}


		public function testGetRules ()
		{
			$this->ruleSet->setRule(
				'test1',
				$this->createMockRule()
			);

			$this->ruleSet->setRule(
				'test2',
				$this->createMockRule()
			);

			$this->assertEquals(
				count($this->ruleSet->getRules()),
				2
			);
		}


		public function testOverrideRule ()
		{
			$rule1 = $this->createMockRule();
			$rule2 = $this->createMockRule();

			$this->ruleSet->setRule('test', $rule1);
			$this->ruleSet->setRule('test', $rule2);

			$this->assertNotSame(
				$this->ruleSet->getRule('test'),
				$rule1
			);

			$this->assertSame(
				$this->ruleSet->getRule('test'),
				$rule2
			);
		}


		protected function createMockRule ()
		{
			return new Rule(
				function () {
					return true;
				}
			);
		}
	}