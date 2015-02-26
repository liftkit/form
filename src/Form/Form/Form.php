<?php


	namespace LiftKit\Form\Form;

	use LiftKit\Form\FieldSet\FieldSet;


	class Form extends FieldSet
	{
		protected $rules = array();


		public function setMethod ($method)
		{
			$this->attributes['method'] = $method;

			return $this;
		}


		public function getMethod ()
		{
			return $this->attributes['method'];
		}


		public function setEncType ($enctype)
		{
			$this->attributes['enctype'] = $enctype;

			return $this;
		}


		public function getEncType ()
		{
			return $this->attributes['enctype'];
		}


		public function setAction ($action)
		{
			$this->attributes['action'] = $action;

			return $this;
		}


		public function getAction ()
		{
			return $this->attributes['action'];
		}
	}