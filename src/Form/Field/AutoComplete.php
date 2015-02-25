<?php


	namespace LiftKit\Form\Field;


	class AutoComplete extends Field
	{
		protected $url;
		protected $selectedLabel;

		/**
		 * @param mixed $selectedLabel
		 */
		public function setSelectedLabel ($selectedLabel)
		{
			$this->selectedLabel = $selectedLabel;

			return $this;
		}


		/**
		 * @return mixed
		 */
		public function getSelectedLabel ()
		{
			return $this->selectedLabel;
		}


		/**
		 * @param mixed $url
		 */
		public function setUrl ($url)
		{
			$this->url = $url;

			return $this;
		}


		/**
		 * @return mixed
		 */
		public function getUrl ()
		{
			return $this->url;
		}
	}
