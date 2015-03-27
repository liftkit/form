<?php


	namespace LiftKit\Form\Field;

	use LiftKit\Request\Http as Request;

	use LiftKit\Form\Element\Element;
	use LiftKit\Form\Validator\Validator;


	class Field extends Element
	{
		/**
		 * @var Validator
		 */
		protected $validator;

		/**
		 * @var string
		 */
		protected $name;

		/**
		 * @var string|mixed
		 */
		protected $value;

		/**
		 * @var string
		 */
		protected $label;


		public function submit (Request $input)
		{
			// no action
		}


		public function validate (Request $input = null)
		{
			if ($this->validator instanceof Validator) {
				$this->validator->validate($this->value);
			}
		}


		public function execute (Request $input)
		{
			$this->submit($input);
			$this->validate($input);
		}


		public function setName ($name)
		{
			$this->name = $name;

			return $this;
		}


		public function getName ()
		{
			return $this->name;
		}


		public function setValue (& $value)
		{
			$this->value = & $value;

			return $this;
		}


		public function & getValue ()
		{
			return $this->value;
		}


		public function setLabel ($label)
		{
			$this->label = $label;

			return $this;
		}


		public function getLabel ()
		{
			return $this->label;
		}


		public function setValidator (Validator $validator)
		{
			$this->validator = $validator;

			return $this;
		}


		public function getValidator ()
		{
			return $this->validator;
		}
	}
