<?php

	namespace LiftKit\Tests\Unit\Form\Field;

	use LiftKit\Tests\Stub\Form\Field\AutoComplete;

	use PHPUnit_Framework_TestCase;


	class AutoCompleteTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var AutoComplete
		 */
		protected $field;


		public function setUp ()
		{
			$this->field = new AutoComplete;
		}


		public function testGetSetSelectedLabel ()
		{
			$this->field->setSelectedLabel('label');

			$this->assertEquals($this->field->getSelectedLabel(), 'label');
		}


		public function testGetSetUrl ()
		{
			$this->field->setUrl('url');

			$this->assertEquals($this->field->getUrl(), 'url');
		}
	}