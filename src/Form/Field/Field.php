<?php

	/*
	 *
	 *	LiftKit MVC PHP Framework
	 *
	 */


	namespace LiftKit\Form\Field;

	use LiftKit\Response\View;

	use LiftKit\Input\Input;

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


		public function __construct (View $view = null)
		{
			$this->view = $view;
		}


		public function submit (Input & $input)
		{
			// no action
		}


		public function validate (Input & $input = null)
		{
			if ($this->validator instanceof Validator) {
				$this->validator->validate($this->value);
			}
		}


		public function execute (Input & $input)
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
	}
