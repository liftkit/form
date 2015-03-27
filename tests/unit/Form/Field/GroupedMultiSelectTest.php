<?php

	namespace LiftKit\Tests\Unit\Form\Field;

	use LiftKit\Tests\Stub\Form\Field\GroupedMultiSelect;

	use PHPUnit_Framework_TestCase;


	class GroupedMultiSelectTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var GroupedMultiSelect
		 */
		protected $field;


		public function setUp ()
		{
			$this->field = new GroupedMultiSelect;
		}


		public function testSelected ()
		{
			$this->field->setOptionValue('value');

			$value = array(
				array('value' => 'Value'),
				array('value' => 'Value1')
			);

			$this->field->setValue($value);

			$this->assertTrue($this->field->isSelected(array('value' => 'Value')));
			$this->assertTrue($this->field->isSelected(array('value' => 'Value1')));
			$this->assertFalse($this->field->isSelected(array('value' => 'Value2')));
		}


		protected function getDefaultOptions ()
		{
			return array(
				array(
					'label' => 'Yes',
					'value' => 1,
				),
				array(
					'label' => 'Yes',
					'value' => 0,
				)
			);
		}
	}