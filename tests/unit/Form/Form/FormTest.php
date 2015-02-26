<?php

	namespace LiftKit\Tests\Unit\Form\Form;
	
	use LiftKit\Form\Form\Form;
	use PHPUnit_Framework_TestCase;
	
	
	class FormTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var Form
		 */
		protected $form;
		
		
		public function setUp ()
		{
			$this->form = new Form;
		}
		
		
		public function testGetSetMethod ()
		{
			$this->form->setMethod('test');
			
			$this->assertEquals($this->form->getMethod(), 'test');
		}
		
		
		public function testGetSetEncType ()
		{
			$this->form->setEncType('test');
			
			$this->assertEquals($this->form->getEncType(), 'test');
		}
		
		
		public function testGetSetAction ()
		{
			$this->form->setAction('test');
			
			$this->assertEquals($this->form->getAction(), 'test');
		}
		
		
		public function testAttributes ()
		{
			$this->form->setMethod('test');
			$this->form->setEncType('test');
			$this->form->setAction('test');
			
			$this->assertEquals(
				$this->form->getAttributes(),
				array(
					'method' => 'test',
					'enctype' => 'test',
					'action' => 'test',
				)
			);
		}
	}