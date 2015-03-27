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
			$this->field->setOptionGroup('value');

			$row = array(
				'label' => 'Label',
				'value' => 'Value',
			);

			$this->assertEquals(
				$this->field->extractGroup($row),
				'Value'
			);
		}


		public function testCallbackGroup ()
		{
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
		}
	}