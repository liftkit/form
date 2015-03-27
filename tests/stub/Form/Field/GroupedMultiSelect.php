<?php

	namespace LiftKit\Tests\Stub\Form\Field;

	use LiftKit\Form\Field\Field;
	use LiftKit\Form\Field\GroupedSelectTrait;
	use LiftKit\Form\Field\MultiSelectTrait;



	class GroupedMultiSelect extends Field
	{
		use GroupedSelectTrait, MultiSelectTrait;
	}