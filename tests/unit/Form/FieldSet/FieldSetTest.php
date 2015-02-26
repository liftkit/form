<?php


	namespace LiftKit\Tests\Unit\Form\FieldSet;
	
	use LiftKit\Form\FieldSet\FieldSet;
	use LiftKit\Form\Field\Field;
	use LiftKit\Form\Field\Select;
	use LiftKit\Form\Field\AutoComplete;
	use LiftKit\Form\Field\MultiSelect;
	use LiftKit\Form\Field\GroupedSelect;
	use LiftKit\Form\Field\GroupedMultiSelect;
	use LiftKit\Input\Input;
	
	use PHPUNIT_Framework_TestCase;
	
	
	class FieldSetTest extends PHPUnit_Framework_TestCase
	{
		/**
		 * @var FieldSet
		 */
		protected $fieldSet;
		
		
		
		public function setUp ()
		{
			$this->fieldSet = new FieldSet;
		}
		
		
		public function testCreateField ()
		{
			$this->assertTrue($this->fieldSet->createField() instanceof Field);
		}
		
		
		public function testCreateSelect ()
		{
			$this->assertTrue($this->fieldSet->createSelectField() instanceof Select);
		}
		
		
		public function testCreateMultiSelect ()
		{
			$this->assertTrue($this->fieldSet->createMultiSelectField() instanceof MultiSelect);
		}
		
		
		public function testCreateGroupedSelect ()
		{
			$this->assertTrue($this->fieldSet->createGroupedSelectField() instanceof GroupedSelect);
		}
		
		
		public function testCreateGroupedMultiSelect ()
		{
			$this->assertTrue($this->fieldSet->createGroupedMultiSelectField() instanceof GroupedMultiSelect);
		}
		
		
		public function testCreateAutoComplete ()
		{
			$this->assertTrue($this->fieldSet->createAutoCompleteField() instanceof AutoComplete);
		}
		
		
		public function testCreateFieldSet ()
		{
			$this->assertTrue($this->fieldSet->createFieldSet() instanceof FieldSet);
		}
		
		
		public function testAddRemoveElement ()
		{
			$element = $this->fieldSet->createField();
			
			$this->fieldSet->addElement('element', $element);
			
			$this->assertSame(
				$this->fieldSet->getElement('element'),
				$element
			);
			
			$this->assertEquals(
				$this->fieldSet->getElements(),
				array('element' => $element)
			);
			
			$this->fieldSet->removeElement('element');
			
			$this->assertEquals(
				$this->fieldSet->getElements(),
				array()
			);
		}
		
		
		public function testAttachClearElements ()
		{
			$field = $this->fieldSet->createField();
			$this->fieldSet->attachElement($field);
			
			$select = $this->fieldSet->createSelectField();
			$autoComplete = $this->fieldSet->createAutoCompleteField();
			
			$this->fieldSet->attachElements($select, $autoComplete);
			
			$this->assertEquals(
				array_values($this->fieldSet->getElements()),
				array(
					$field,
					$select,
					$autoComplete
				)
			);
			
			$this->fieldSet->clearElements();
			
			$this->assertEquals(
				$this->fieldSet->getElements(),
				array()
			);
		}
		
		
		public function testExecute ()
		{
            $input = new Input;
            
			$element = $this->getMockBuilder('\LiftKit\Form\Field\Field')
                 ->setMethods(array('execute'))
                 ->getMock();
                 
            $element->expects($this->once())
            	->method('execute')
            	->with($this->identicalTo($input));
            
            $this->fieldSet->attachElement($element);
            
            $this->fieldSet->execute($input);
		}
	}