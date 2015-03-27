<?php


	namespace LiftKit\Form\Field;


	/**
	 * Class GroupedMultiSelect
	 *
	 * @deprecated Use GroupedSelectTrait, MultiSelectTrait instead
	 * @package LiftKit\Form\Field
	 */
	class GroupedMultiSelect extends Field
	{
		use GroupedSelectTrait, MultiSelectTrait;
	}