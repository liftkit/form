<?php


	namespace LiftKit\Form\Field;


	/**
	 * Class GroupedSelect
	 *
	 * @deprecated Use GroupedSelectTrait instead
	 * @package LiftKit\Form\Field
	 */
	class GroupedSelect extends Field
	{
		use SelectTrait, GroupedSelectTrait;
	}
