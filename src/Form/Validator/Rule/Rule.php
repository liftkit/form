<?php


	namespace LiftKit\Form\Validator\Rule;

	use LiftKit\Form\Validator\Rule\Exception\InvalidCallback as InvalidCallbackException;
	use LiftKit\Form\Validator\Rule\Exception\Validation as ValidationException;


	/**
	 * Class Rule
	 *
	 * @package LiftKit\Validator\Rule
	 */
	class Rule
	{
		const DEFAULT_PLACEHOLDER = '{field}';

		/**
		 * @var callable
		 */
		protected $callback;

		/**
		 * @var string
		 */
		protected $message;

		/**
		 * @var string
		 */
		protected $placeholder;


		/**
		 * @param callable $callback
		 * @param string   $message
		 * @param string   $placeholder
		 *
		 * @throws InvalidCallbackException
		 */
		public function __construct ($callback, $message = '', $placeholder = self::DEFAULT_PLACEHOLDER)
		{
			if (! is_callable($callback)) {
				throw new InvalidCallbackException('Validation rules must be provided a valid callback.');
			}

			$this->callback    = $callback;
			$this->message     = $message;
			$this->placeholder = $placeholder;
		}


		/**
		 * @param mixed      $value
		 * @param string      $name
		 * @param array $arguments
		 *
		 * @return bool
		 * @throws ValidationException
		 */
		public function validate (& $value, $name = '', $arguments = array())
		{
			$callbackArguments = array_merge(array(& $value), $arguments);

			$returnValue = call_user_func_array($this->callback, $callbackArguments);

			if ($returnValue) {
				return true;
			} else {
				throw new ValidationException($this->getMessage($name));
			}
		}


		/**
		 * @param string $name
		 *
		 * @return string
		 */
		protected function getMessage ($name)
		{
			return str_replace($this->placeholder, $name, $this->message);
		}
	}