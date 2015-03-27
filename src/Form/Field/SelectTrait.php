<?php

	/*
	 *
	 *	LiftKit MVC PHP Framework
	 *
	 */


	namespace LiftKit\Form\Field;

	use LiftKit\Form\Field\Exception\Field as FieldException;
	use Iterator;


	trait SelectTrait
	{
		protected $options = array();
		protected $valueExtractor;
		protected $labelExtractor;


		abstract public function & getValue ();


		public function setOptions ($data)
		{
			if (!is_array($data) && !($data instanceof Iterator)) {
				throw new FieldException('You must pass an iteratable type.');
			}

			$this->options = $data;

			return $this;
		}


		public function getOptions ()
		{
			return $this->options;
		}


		public function setOptionValue ($value)
		{
			if (is_string($value)) {
				$this->valueExtractor = function ($row) use ($value) {
					return $row[$value];
				};
			} else if (is_callable($value)) {
				$this->valueExtractor = $value;
			} else {
				throw new FieldException('Invalid value extractor type exception.');
			}

			return $this;
		}


		public function setOptionLabel ($label)
		{
			if (is_string($label)) {
				$this->labelExtractor = function ($row) use ($label) {
					return $row[$label];
				};
			} else if (is_callable($label)) {
				$this->labelExtractor = $label;
			} else {
				throw new FieldException('Invalid label extractor type exception.');
			}

			return $this;
		}


		public function extractValue ($row)
		{
			return call_user_func_array($this->valueExtractor, array($row));
		}


		public function extractLabel ($row)
		{
			return call_user_func_array($this->labelExtractor, array($row));
		}


		public function isSelected ($row)
		{
			if ($this->extractValue($row) == $this->getValue()) {
				return true;
			} else {
				return false;
			}
		}
	}
