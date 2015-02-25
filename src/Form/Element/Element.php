<?php

	/*
	 *
	 *	LiftKit MVC PHP Framework
	 *
	 *
	 */


	namespace LiftKit\Form\Element;

	use LiftKit\Input\Input;
	use LiftKit\Response\Response;
	use LiftKit\Response\View;


	abstract class Element extends Response
	{
		/**
		 * @var View|null
		 */
		protected $view;

		/**
		 * @var array
		 */
		protected $attributes = array();


		abstract public function submit (Input & $input);
		abstract public function execute (Input & $input);
		abstract public function validate (Input & $input);


		public function prepare ()
		{
			if ($this->view) {
				return $this->view->prepare();
			} else {
				return null;
			}
		}


		public function setData ()
		{
			if ($this->view) {
				$this->view->setData(func_get_args());
			}
		}


		public function setAttribute ($attribute, $value)
		{
			$this->attributes[$attribute] = $value;

			return $this;
		}


		public function getAttribute ($attribute)
		{
			return $this->attributes[$attribute];
		}


		public function getAttributes ()
		{
			return $this->attributes;
		}


		public function getAttributesString ()
		{
			$string = '';

			foreach ($this->getAttributes() as $key => $attribute) {
				$string .= ' ' . $key . '="' . $this->escapeOutput($attribute) . '"';
			}

			return $string;
		}


		protected function escapeOutput ($string)
		{
			return htmlentities($string);
		}
	}