<?php


	namespace LiftKit\Form\Field;


	trait MultiSelectTrait
	{
		use SelectTrait;

		public function isSelected ($row)
		{
			$rowValue = $this->extractValue($row);
			$values = $this->getValue();

			foreach ($values as $value) {
				$selectedValue = $this->extractValue($value);

				if ($rowValue == $selectedValue) {
					return true;
				}
			}

			return false;
		}
	}