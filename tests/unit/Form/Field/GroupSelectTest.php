<?php

	namespace LiftKit\Tests\Unit\Form\Field;

	use LiftKit\Tests\Stub\Form\Field\GroupedSelect;

	use PHPUnit_Framework_TestCase;


	class GroupedSelectTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var GroupedSelect
		 */
		protected $field;


		public function setUp ()
		{
			$this->field = new GroupedSelect;
		}


		public function testKeyGroup ()
		{
			$this->assertFalse($this->field->isGrouped());

			$this->field->setOptionGroup('value');

			$row = array(
				'label' => 'Label',
				'value' => 'Value',
			);

			$this->assertEquals(
				$this->field->extractGroup($row),
				'Value'
			);

			$this->assertTrue($this->field->isGrouped());
		}


		public function testCallbackGroup ()
		{
			$this->assertFalse($this->field->isGrouped());

			$this->field->setOptionGroup(function ($row) {
				return $row['value'];
			});

			$row = array(
				'label' => 'Label',
				'value' => 'Value',
			);

			$this->assertEquals(
				$this->field->extractGroup($row),
				'Value'
			);

			$this->assertTrue($this->field->isGrouped());
		}
	}