<?php


	namespace LiftKit\Form\Element;

	use LiftKit\Request\Http as Request;


	abstract class Element
	{
		/**
		 * @var array
		 */
		protected $attributes = array();


		abstract public function submit (Request $input);
		abstract public function execute (Request $input);
		abstract public function validate (Request $input);


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