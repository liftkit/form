<?php


	namespace LiftKit\Form\Field;



	class GroupedMultiSelect extends GroupedSelect
	{


		public function isSelected ($row)
		{
			$row_value = $this->extractValue($row);
			$values = $this->getValue();

			foreach ((array)$values as $value) {
				$selected_value = $this->extractValue($value);
				if ($row_value == $selected_value) {
					return true;
				}
			}

			return false;
		}
	}