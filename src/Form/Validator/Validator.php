<?php

	namespace LiftKit\Form\Validator;

	use LiftKit\Form\Validator\RuleSet\RuleSet;
	use LiftKit\Form\Validator\Exception\InvalidRule as InvalidRuleException;


	class Validator
	{
		const BACKSLASH_PLACEHOLDER          = '__PLACEHOLDER_BACKSLASH__';
		const PIPE_PLACEHOLDER            = '__PLACEHOLDER_PIPE__';
		const COMMA_PLACEHOLDER           = '__PLACEHOLDER_COMMA__';
		const IN_PARENTHESIS_PLACEHOLDER  = '__PLACEHOLDER_IN_PARENTHESIS__';
		const OUT_PARENTHESIS_PLACEHOLDER = '__PLACEHOLDER_OUT_PARENTHESIS__';

		const BACKSLASH_ESCAPED = '\\\\';
		const PIPE_ESCAPED = '\\|';
		const COMMA_ESCAPED = '\\,';
		const IN_PARENTHESIS_ESCAPED = '\\(';
		const OUT_PARENTHESIS_ESCAPED = '\\)';

		const BACKSLASH = '\\';
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
		protected static $placeholders = array(
			self::BACKSLASH_ESCAPED => self::BACKSLASH_PLACEHOLDER,
			self::PIPE_ESCAPED => self::PIPE_PLACEHOLDER,
			self::COMMA_ESCAPED => self::COMMA_PLACEHOLDER,
			self::IN_PARENTHESIS_ESCAPED => self::IN_PARENTHESIS_PLACEHOLDER,
			self::OUT_PARENTHESIS_ESCAPED => self::OUT_PARENTHESIS_PLACEHOLDER,
		);

		/**
		 * @var array
		 */
		protected static $replacements = array(
			self::BACKSLASH_PLACEHOLDER       => self::BACKSLASH,
			self::PIPE_PLACEHOLDER            => self::PIPE,
			self::COMMA_PLACEHOLDER           => self::COMMA,
			self::IN_PARENTHESIS_PLACEHOLDER  => self::IN_PARENTHESIS,
			self::OUT_PARENTHESIS_PLACEHOLDER => self::OUT_PARENTHESIS,
		);

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


		public static function escapeArgument ($argument)
		{
			return addcslashes($argument, implode(self::$replacements));
		}


		protected function parseRules ()
		{
			$processedRules = $this->substitutePlaceholders($this->ruleString);

			$rules = explode(self::PIPE, $processedRules);
			$parsedRules = array();

			foreach ($rules as $rule) {
				if (strstr($rule, self::IN_PARENTHESIS)) {
					$rule   = rtrim(trim($rule), self::OUT_PARENTHESIS);
					$split  = explode(self::IN_PARENTHESIS, $rule);
					$method = array_shift($split);
					$args   = explode(self::COMMA, $split[0]);
				} else {
					$method = $rule;
					$args   = array();
				}

				$newArgs = array();

				foreach ($args as $arg) {
					$newArgs[] = $this->replacePlaceholders($arg);
				}

				if ($method) {
					$parsedRules[] = array(
						'name' => trim($method),
						'arguments' => $newArgs,
					);
				}
			}

			return $parsedRules;
		}


		protected function substitutePlaceholders ($string)
		{
			foreach (self::$placeholders as $placeholder => $replace) {
				$string = str_replace($placeholder, $replace, $string);
			}

			return $string;
		}


		protected function replacePlaceholders ($string)
		{
			foreach (self::$replacements as $placeholder => $replacement) {
				$string = str_replace($placeholder, $replacement, $string);
			}

			return $string;
		}
	}