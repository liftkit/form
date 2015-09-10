<?php

	namespace LiftKit\Form\Validator\RuleSet;

	use LiftKit\Form\Validator\Rule\Rule;


	class RuleSet
	{
		/**
		 * @var Rule[]
		 */
		protected $rules = array();


		public function setRule ($name, Rule $rule)
		{
			$this->rules[$name] = $rule;
		}


		public function getRule ($name)
		{
			return $this->rules[$name];
		}


		public function getRules ()
		{
			return $this->rules;
		}
	}