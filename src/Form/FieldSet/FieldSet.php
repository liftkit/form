<?php


	namespace LiftKit\Form\FieldSet;

	use LiftKit\Response\View;
	use LiftKit\Input\Input;

	use LiftKit\Form\Element\Element;
	use LiftKit\Form\Field\Field;
	use LiftKit\Form\Field\Select;
	use LiftKit\Form\Field\MultiSelect;
	use LiftKit\Form\Field\GroupedSelect;
	use LiftKit\Form\Field\GroupedMultiSelect;
	use LiftKit\Form\Field\AutoComplete;


	class FieldSet extends Element
	{
		/**
		 * @var Element[]
		 */
		protected $elements = array();


		public function __construct (View $view = null)
		{
			$this->view = $view;
		}


		public function createField (View $view = null)
		{
			return new Field($view);
		}


		public function createAutoCompleteField (View $view = null)
		{
			return new AutoComplete($view);
		}


		public function createSelectField (View $view = null)
		{
			return new Select($view);
		}


		public function createGroupedSelectField (View $view = null)
		{
			return new GroupedSelect($view);
		}


		public function createMultiSelectField (View $view = null)
		{
			return new MultiSelect($view);
		}


		public function createGroupedMultiSelectField (View $view = null)
		{
			return new GroupedMultiSelect($view);
		}


		public function createFieldSet (View $view = null)
		{
			return new Fieldset($view);
		}


		public function getElements ()
		{
			return $this->elements;
		}


		public function getElement ($name)
		{
			return $this->elements[$name];
		}


		public function addElement ($name, Element $element)
		{
			$this->elements[$name] = $element;

			return $this;
		}


		public function attachElement (Element $element)
		{
			if ($element instanceof Field) {
				$name = $element->getName() ?: uniqid();
			} else {
				$name = uniqid();
			}

			$this->addElement($name, $element);

			return $this;
		}


		public function attachElements ()
		{
			foreach (func_get_args() as $element) {
				$this->attachElement($element);
			}

			return $this;
		}


		public function removeElement ($name)
		{
			unset($this->elements[$name]);

			return $this;
		}


		public function clearElements ()
		{
			$this->elements = array();

			return $this;
		}


		public function execute (Input & $input)
		{
			$this->submit($input);
			$this->validate($input);

			foreach ($this->elements as $element) {
				$element->execute($input);
			}
		}


		public function submit (Input & $input)
		{
			// no action
		}


		public function validate (Input & $input)
		{
			// no action
		}
	}