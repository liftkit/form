<?php

	namespace LiftKit\Tests\Stub\Form\Field;

	use LiftKit\Form\Field\Field;
	use LiftKit\Form\Field\SelectTrait;
	use LiftKit\Form\Field\GroupedSelectTrait;



	class GroupedSelect extends Field
	{
		use SelectTrait, GroupedSelectTrait;
	}
