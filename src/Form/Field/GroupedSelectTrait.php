<?php


	namespace LiftKit\Form\Field;

	use LiftKit\Form\Field\Exception\Field as FieldException;


	trait GroupedSelectTrait
	{
		protected $groupExtractor;


		public function setOptionGroup ($group)
		{
			if (is_string($group)) {
				$this->groupExtractor = function ($row) use ($group) {
					return $row[$group];
				};
			} else if (is_callable($group)) {
				$this->groupExtractor = $group;
			} else {
				throw new FieldException('Invalid label extractor type exception.');
			}

			return $this;
		}


		public function extractGroup ($row)
		{
			return call_user_func_array($this->groupExtractor, array($row));
		}


		public function isGrouped ()
		{
			return (bool) $this->groupExtractor;
		}
	}
