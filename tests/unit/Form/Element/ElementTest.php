<?php


	namespace LiftKit\Tests\Unit\Form\Element;
	
	use LiftKit\Tests\Stub\Form\Element\Element as StubElement;
	use PHPUnit_Framework_TestCase;
	
	
	class ElementTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var StubElement
		 *
		 */
		protected $field;
		
		
		public function setUp ()
		{
			$this->field = new StubElement;
		}
		

		public function testSetAttribute ()
		{
			$this->field->setAttribute('test', 1);

			$this->assertEquals(
				$this->field->getAttribute('test'),
				1
			);

			$this->assertEquals(
				$this->field->getAttributes(),
				array('test' => 1)
			);
		}


		public function testGetAttributesString ()
		{
			$this->field->setAttribute('test', 1);
			$this->field->setAttribute('another', '1&2');

			$this->assertEquals(
				trim($this->field->getAttributesString()),
				'test="1" another="1&amp;2"'
			);
		}
	}