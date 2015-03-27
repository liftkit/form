<?php

	namespace LiftKit\Tests\Unit\Form\Field;

	use LiftKit\Tests\Stub\Form\Field\Select;

	use PHPUnit_Framework_TestCase;


	class SelectTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var Select
		 */
		protected $field;


		public function setUp ()
		{
			$this->field = new Select;
		}


		public function testGetSetOptions ()
		{
			$options = $this->getDefaultOptions();

			$this->field->setOptions($options);

			$this->assertEquals($this->field->getOptions(), $options);
		}


		public function testKeyValue ()
		{
			$this->field->setOptionValue('value');

			$row = array(
				'label' => 'Label',
				'value' => 'Value',
			);

			$this->assertEquals(
				$this->field->extractValue($row),
				'Value'
			);
		}


		public function testCallbackValue ()
		{
			$this->field->setOptionValue(function ($row) {
				return $row['value'];
			});

			$row = array(
				'label' => 'Label',
				'value' => 'Value',
			);

			$this->assertEquals(
				$this->field->extractValue($row),
				'Value'
			);
		}


		public function testKeyLabel ()
		{
			$this->field->setOptionLabel('label');

			$row = array(
				'label' => 'Label',
				'value' => 'Value',
			);

			$this->assertEquals(
				$this->field->extractLabel($row),
				'Label'
			);
		}


		public function testCallbackLabel ()
		{
			$this->field->setOptionLabel(function ($row) {
				return $row['label'];
			});

			$row = array(
				'label' => 'Label',
				'value' => 'Value',
			);

			$this->assertEquals(
				$this->field->extractLabel($row),
				'Label'
			);
		}


		public function testSelected ()
		{
			$this->field->setOptionValue('value');

			$value = 'Value';

			$this->field->setValue($value);

			$this->assertTrue($this->field->isSelected(array('value' => 'Value')));
			$this->assertFalse($this->field->isSelected(array('value' => 'Value1')));
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