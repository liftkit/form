<?php

	namespace LiftKit\Form\Validator;

	use LiftKit\Form\Validator\RuleSet\RuleSet;
	use LiftKit\Form\Validator\Exception\InvalidRule as InvalidRuleException;


	class Validator
	{
		const PERIOD_PLACEHOLDER          = '__.PLACEHOLDER_PERIOD.__';
		const PIPE_PLACEHOLDER            = '__|PLACEHOLDER_PIPE|__';
		const COMMA_PLACEHOLDER           = '__,PLACEHOLDER_COMMA,__';
		const IN_PARENTHESIS_PLACEHOLDER  = '__(PLACEHOLDER_IN_PARENTHESIS(__';
		const OUT_PARENTHESIS_PLACEHOLDER = '__)PLACEHOLDER_OUT_PARENTHESIS)__';

		const PERIOD_ESCAPED = '\\.';
		const PIPE_ESCAPED = '\\|';
		const COMMA_ESCAPED = '\\,';
		const IN_PARENTHESIS_ESCAPED = '\\(';
		const OUT_PARENTHESIS_ESCAPED = '\\)';

		const PERIOD = '.';
		const PIPE = '|';
		const COMMA = ',';
		const IN_PARENTHESIS = '(';
		const OUT_PARENTHESIS = ')';

		/**
		 * @var RuleSet
		 */
		protected $ruleSet;

		/**
		 * @var array
		 */
		protected $placeholders;

		/**
		 * @var array
		 */
		protected $replacements;

		/**
		 * @var string
		 */
		protected $ruleString;

		/**
		 * @var string
		 */
		protected $fieldName;


		public function __construct (RuleSet $ruleSet, $ruleString, $fieldName = '')
		{
			$this->ruleSet = $ruleSet;
			$this->fieldName = $fieldName;
			$this->ruleString = $ruleString;

			$this->setupPlaceholders();
		}


		public function setName ($fieldName)
		{
			$this->fieldName = $fieldName;
		}


		public function addRule ($ruleString)
		{
			if ($this->ruleString) {
				$this->ruleString .= self::PIPE . $ruleString;
			} else {
				$this->ruleString = $ruleString;
			}
		}


		public function validate (& $value)
		{
			$parsedRules = $this->parseRules();

			foreach ($parsedRules as $rule) {
				$validationRule = $this->ruleSet->getRule($rule['name']);

				if ($validationRule) {
					$validationRule->validate($value, $this->fieldName, $rule['arguments']);
				} else {
					throw new InvalidRuleException($rule['name'] . ' is not a recognized validation rule.');
				}
			}
		}


		protected function setupPlaceholders ()
		{
			$this->placeholders = array(
				self::PERIOD_ESCAPED => self::PERIOD_PLACEHOLDER,
				self::PIPE_ESCAPED => self::PIPE_PLACEHOLDER,
				self::COMMA_ESCAPED => self::COMMA_PLACEHOLDER,
				self::IN_PARENTHESIS_ESCAPED => self::IN_PARENTHESIS_PLACEHOLDER,
				self::OUT_PARENTHESIS_ESCAPED => self::OUT_PARENTHESIS_PLACEHOLDER,
			);

			$this->replacements = array(
				self::PERIOD_PLACEHOLDER          => self::PERIOD,
				self::PIPE_PLACEHOLDER            => self::PIPE,
				self::COMMA_PLACEHOLDER           => self::COMMA,
				self::IN_PARENTHESIS_PLACEHOLDER  => self::IN_PARENTHESIS,
				self::OUT_PARENTHESIS_PLACEHOLDER => self::OUT_PARENTHESIS,
			);
		}


		protected function parseRules ()
		{
			$processedRules = $this->substitutePlaceholders($this->ruleString);

			$rules = explode(self::PIPE, $processedRules);
			$parsedRules = array();

			foreach ($rules as $rule) {
				if (strstr($rule, self::IN_PARENTHESIS)) {
					$rule   = substr($rule, 0, count($rule) - 2);
					$split  = explode(self::IN_PARENTHESIS, $rule);
					$method = array_shift($split);
					$args   = explode(self::COMMA, $split[0]);
				} else {
					$method = $rule;
					$args   = array();
				}

				foreach ($args as $arg) {
					$args[] = $this->replacePlaceholders($arg);
				}

				if ($method) {
					$parsedRules[] = array(
						'name' => $method,
						'arguments' => $args,
					);
				}
			}

			return $parsedRules;
		}


		protected function substitutePlaceholders ($string)
		{
			foreach ($this->placeholders as $placeholder => $replace) {
				$string = str_replace($placeholder, $replace, $string);
			}

			return $string;
		}


		protected function replacePlaceholders ($string)
		{
			foreach ($this->replacements as $placeholder => $replacement) {
				$string = str_replace($placeholder, $replacement, $string);
			}

			return $string;
		}
	}