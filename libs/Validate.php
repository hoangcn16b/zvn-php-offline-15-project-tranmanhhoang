<?php
class Validate
{

	// Error array
	private $errors	= array();

	// Source array
	private $source	= array();

	// Rules array
	private $rules	= array();

	// Result array
	private $result	= array();

	// Contrucst
	public function __construct($source)
	{
		$this->source = $source;
	}

	// Add rules
	public function addRules($rules)
	{
		$this->rules = array_merge($rules, $this->rules);
	}

	// Get error
	public function getError()
	{
		return $this->errors;
	}

	// Set error
	public function setError($element, $message)
	{

		if (array_key_exists($element, $this->errors)) {
			$this->errors[$element] .= ' - ' . $message;
		} else {
			$this->errors[$element] = '<b>' . ucfirst($element) . ':</b> ' . $message;
		}
	}

	// Get result
	public function getResult()
	{
		return $this->result;
	}

	// Add rule
	public function addRule($element, $type, $options = null, $required = true)
	{
		$this->rules[$element] = array('type' => $type, 'options' => $options, 'required' => $required);
		return $this;
	}

	// Run
	public function run()
	{
		foreach ($this->rules as $element => $value) {
			if ($value['required'] == true && trim($this->source[$element]) == null) {
				$this->setError($element, 'is not empty');
			} else {
				switch ($value['type']) {
					case 'int':
						$this->validateInt($element, $value['options']['min'], $value['options']['max'], $value['options']['required'] = true);
						break;
					case 'phone':
						$this->validatePhone($element, $value['options']['required'] = true);
						break;
					case 'string':
						$this->validateString($element, $value['options']['min'], $value['options']['max'], $value['options']['required'] = true);
						break;
					case 'username':
						$this->validateUserName($element, $value['options']['min'], $value['options']['max']);
						break;
					case 'password':
						$this->validatePassword($element, $value['options']);
						break;
					case 'url':
						$this->validateUrl($element);
						break;
					case 'email':
						$this->validateEmail($element);
						break;
					case 'status':
						$this->validateStatus($element);
						break;
					case 'groupAcp':
						$this->validateGroupAcp($element);
						break;
					case 'group':
						$this->validateGroupID($element);
						break;
					case 'select':
						$this->validateSelect($element);
						break;
					case 'date':
						$this->validateDate($element, $value['options']['start'], $value['options']['end']);
						break;
					case 'existRecord':
						$this->validateExistRecord($element, $value['options']);
						break;
					case 'notExistRecord':
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'string-existRecord':
						$this->validateString($element, $value['options']['min'], $value['options']['max']);
						$this->validateExistRecord($element, $value['options']);
						break;
					case 'string-notExistRecord':
						$this->validateString($element, $value['options']['min'], $value['options']['max']);
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'email-existRecord':
						$this->validateEmail($element);
						$this->validateExistRecord($element, $value['options']);
						break;
					case 'email-notExistRecord':
						$this->validateEmail($element);
						$this->validateNotExistRecord($element, $value['options']);
						break;
					case 'file':
						$this->validateFile($element, $value['options']);
						break;
				}
			}
			if (!array_key_exists($element, $this->errors)) {
				$this->result[$element] = $this->source[$element];
			}
		}
		$eleNotValidate = array_diff_key($this->source, $this->errors);
		$this->result	= array_merge($this->result, $eleNotValidate);
	}

	// Validate Integer
	private function validateInt($element, $min = 0, $max = 0, $required = true)
	{
		if ($required == true) {
			if ($this->source[$element] < $min) {
				$this->setError($element, 'is invalid');
			} elseif ($this->source[$element] > $max) {
				$this->setError($element, 'is invalid');
			} elseif (!is_string($this->source[$element])) {
				$this->setError($element, 'is an invalid number');
			}
			if ($min > 0) {
				if (!filter_var($this->source[$element], FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max)))) {
					$this->setError($element, 'is an invalid number');
				}
			}
		}
	}

	private function validatePhone($element, $required = true)
	{
		if ($required == true) {
			if ((!empty($this->source[$element]))) {
				if (!preg_match('/^[0-9]{10}+$/', $this->source[$element])) {
					$this->setError($element, "is an invalid Phone Number");
				}
			}
		}
	}

	// Validate String
	private function validateString($element, $min = 0, $max = 0, $required = true)
	{
		if ($required == true) {
			$length = strlen($this->source[$element]);
			if ($length < $min) {
				$this->setError($element, 'is too short');
			} elseif ($length > $max) {
				$this->setError($element, 'is too long');
			} elseif (!is_string($this->source[$element])) {
				$this->setError($element, 'is an invalid string');
			}
			if ($min > 0) {
				$pattern = '"^(?=.{0,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$"';
				if (!preg_match($pattern, $this->source[$element])) {
					$this->setError($element, 'is an invalid string');
				};
			}
		}
	}

	// Validate URL
	private function validateURL($element)
	{
		if (!filter_var($this->source[$element], FILTER_VALIDATE_URL)) {
			$this->setError($element, 'is an invalid url');
		}
	}

	// Validate Email
	private function validateEmail($element)
	{
		if (!filter_var($this->source[$element], FILTER_VALIDATE_EMAIL)) {
			$this->setError($element, 'is an invalid email');
		}
	}

	// public function showErrors()
	// {
	// 	$xhtml = '';
	// 	if (!empty($this->errors)) {
	// 		$xhtml .= '<ul class="error">';
	// 		foreach ($this->errors as $key => $value) {
	// 			$xhtml .= '<li>' . $value . ' </li>';
	// 		}
	// 		$xhtml .=  '</ul>';
	// 	}
	// 	return $xhtml;
	// }
	public function showErrors()
	{
		$xhtml = '';
		if (!empty($this->errors)) {
			$xhtml .= '<div class="error">';
			foreach ($this->errors as $key => $value) {
				$xhtml .= '<span>' . $value . ' </span></br>';
			}
			$xhtml .=  '</div>';
		}
		return $xhtml;
	}

	public function isValid()
	{
		if (count($this->errors) > 0) return false;
		return true;
	}

	// Validate Status
	private function validateStatus($element)
	{
		if ($this->source[$element] == 'default') {
			$this->setError($element, 'Select status');
		}
	}

	private function validateSelect($element)
	{
		if ($this->source[$element] == 'default') {
			$this->setError($element, 'Select status');
		}
	}

	// Validate group ACP
	private function validateGroupAcp($element)
	{
		if ($this->source[$element] < 0 || $this->source[$element] > 1) {
			$this->setError($element, 'Select Group ACP');
		}
	}


	// Validate GroupID
	private function validateGroupID($element)
	{
		if ($this->source[$element] == 0) {
			$this->setError($element, 'Select group');
		}
	}


	//validate username
	private function validateUserName($element, $min = 0, $max = 0)
	{
		$length = strlen($this->source[$element]);
		if ($length < $min) {
			$this->setError($element, 'is too short');
		} elseif ($length > $max) {
			$this->setError($element, 'is too long');
		} elseif (!is_string($this->source[$element])) {
			$this->setError($element, 'is an invalid string');
		}
	}

	// Validate Password
	private function validatePassword($element, $options)
	{
		$min = 4;
		$max = 20;
		// if ($options['action'] == 'add' || ($options['action'] == 'edit' && $this->source[$element])) {
		if ($options['action'] == 'add') {
			$length = strlen($this->source[$element]);
			if ($length < $min) {
				$this->setError($element, 'is too short');
			} elseif ($length > $max) {
				$this->setError($element, 'is too long');
			} elseif (!is_string($this->source[$element])) {
				$this->setError($element, 'is an invalid string');
			}
			// $pattern = '"^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$"';
			$pattern = '"^(?=.{0,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$"';
			if (!preg_match($pattern, $this->source[$element])) {
				$this->setError($element, 'is an invalid password');
			};
		}
	}

	// Validate Date
	private function validateDate($element, $start, $end)
	{
		// Start
		$arrDateStart 	= date_parse_from_format('Y-m-d', $start);
		$tsStart		= mktime(0, 0, 0, $arrDateStart['month'], $arrDateStart['day'], $arrDateStart['year']);

		// End
		$arrDateEnd 	= date_parse_from_format('Y-m-d', $end);
		$tsEnd			= mktime(0, 0, 0, $arrDateEnd['month'], $arrDateEnd['day'], $arrDateEnd['year']);

		// Current
		$arrDateCurrent	= date_parse_from_format('Y-m-d', $this->source[$element]);
		$tsCurrent		= mktime(0, 0, 0, $arrDateCurrent['month'], $arrDateCurrent['day'], $arrDateCurrent['year']);

		if ($tsCurrent < $tsStart || $tsCurrent > $tsEnd) {
			$this->setError($element, 'is an invalid date');
		}
	}

	// Validate Exist record
	private function validateExistRecord($element, $options)
	{
		$required = true;
		$required = ($options['required'] == false) ? false : true;
		if ($required == true) {
			$database = $options['database'];
			$query	  = $options['query'];
			if ($database->isExist($query) == false) {
				$this->setError($element, 'giá trị này không tồn tại');
			}
		}
	}
	// Validate Not Exist record
	private function validateNotExistRecord($element, $options)
	{
		$required = true;
		$required = ($options['required'] == false) ? false : true;
		if ($required == true) {
			$database = $options['database'];
			$query	  = $options['query'];	// SELECT id FROM user where username = 'admin'
			if ($database->isExist($query) == true) {
				$this->setError($element, 'giá trị này đã tồn tại');
			}
		}
	}
	// Validate File
	private function validateFile($element, $options)
	{
		if ($this->source[$element]['name'] != null) {
			if (!filter_var($this->source[$element]['size'], FILTER_VALIDATE_INT, array("options" => array("min_range" => $options['min'], "max_range" => $options['max'])))) {
				$this->setError($element, 'kích thước không phù hợp');
			}

			$ext = pathinfo($this->source[$element]['name'], PATHINFO_EXTENSION);
			if (in_array($ext, $options['extension']) == false) {
				$this->setError($element, 'phần mở rộng không phù hợp');
			}
		}
	}
}
