<?php


namespace Geckoboard\Widget;


class NumberAndSecondaryStatWidget extends \Geckoboard\Widget\AbstractWidget
{
	
	/**
	 * Determines if absolute, not per cent difference should be shown by the widget
	 * 
	 * @var bool
	 */
	protected $absolute;
	
	
	/**
	 * Determines if high values should be shown as green (true) or red (false)
	 * 
	 * @var bool
	 */
	protected $reverse;
	
	
	/**
	 * Primary number to display
	 * 
	 * @var double
	 */
	protected $primary_number;
	
	
	/**
	 * Primary text to display
	 * 
	 * @var string
	 */
	protected $primary_text;
	
	
	/**
	 * Secondary number to display
	 * 
	 * @var double
	 */
	protected $secondary_number;
	
	
	/**
	 * Secondary text to display
	 * 
	 * @var string
	 */
	protected $secondary_text;
	
	
	/**
	 * Determines whether widget should display high numbers as green (true)
	 * or red (false)
	 * 
	 * @param bool $v
	 * 
	 * @return \Geckoboard\Widget\NumberAndSecondaryStatWidget
	 * 
	 * @throws \Exception if $v doesn't validate
	 */
	public function setReverse( $v )
	{
		$this->reverse = \Altumo\Validation\Booleans::assertLooseBoolean( $v );

		return $this;
	}
	
	
	/**
	 * @return bool
	 */
	protected function isReverse()
	{
		return (bool) $this->reverse;
	}
	

	/**
	 * Determines if widget should display the difference between the primary
	 * and secondary value as an absolute value (true) or per cent value (false)
	 * 
	 * @param bool $v
	 *
	 * @return \Geckoboard\Widget\NumberAndSecondaryStatWidget
	 *
	 * @throws \Exception if $v doesn't validate
	 */
	public function setAbsolute( $v )
	{
		$this->absolute = \Altumo\Validation\Booleans::assertLooseBoolean( $v );
		
		return $this;
	}
	
	
	/**
	 * @return bool
	 */
	protected function isAbsolute()
	{
		return (bool) $this->absolute;
	}
	
	
	/**
	 * @param double $v
	 * 
	 * @return \Geckoboard\Widget\NumberAndSecondaryStatWidget
	 * 
	 * @throws \Exception if value doesn't validate
	 */
	public function setPrimaryValue( $v )
	{
		$this->primary_number = \Altumo\Validation\Numerics::assertDouble( $v );
		
		return $this;
	}
	
	
	/**
	 * @return double
	 */
	protected function getPrimaryValue()
	{
		return $this->primary_number;
	}
	
	
	/**
	 * @param string $v
	 * 
	 * @return \Geckoboard\Widget\NumberAndSecondaryStatWidget
	 * 
	 * @throws \Exception if value doesn't validate
	 */
	public function setPrimaryText( $v )
	{
		$this->primary_text = \Altumo\Validation\Strings::assertString( $v );
		
		return $this;
	}
	
	
	/**
	 * @return string
	 */
	protected function getPrimaryText()
	{
		return $this->primary_text;
	}
	
	
	/**
	 * @param double $value
	 * @param string $text
	 * 
	 * @return \Geckoboard\Widget\NumberAndSecondaryStatWidget
	 * 
	 * @throws \Exception if $value or $text doesn't validate
	 */
	public function setPrimary( $value, $text )
	{
		return $this
			->setPrimaryValue( $value )
			->setPrimaryText( $text )
		;
	}
	
	
	/**
	 * @param double $v
	 *
	 * @return \Geckoboard\Widget\NumberAndSecondaryStatWidget
	 *
	 * @throws \Exception if value doesn't validate
	 */
	public function setSecondaryValue( $v )
	{
		$this->secondary_number = \Altumo\Validation\Numerics::assertDouble( $v );
	
		return $this;
	}
	

	/**
	 * @return double
	 */
	protected function getSecondaryValue()
	{
		return $this->secondary_number;
	}
	
	
	/**
	 * @param string $v
	 *
	 * @return \Geckoboard\Widget\NumberAndSecondaryStatWidget
	 *
	 * @throws \Exception if value doesn't validate
	 */
	public function setSecondaryText( $v )
	{
		$this->secondary_text = \Altumo\Validation\Strings::assertString( $v );
	
		return $this;
	}
	
	
	/**
	 * @return string
	 */
	public function getSecondaryText()
	{
		return $this->secondary_text;
	}
	
	
	/**
	 * @param double $value
	 * @param string $text
	 *
	 * @return \Geckoboard\Widget\NumberAndSecondaryStatWidget
	 *
	 * @throws \Exception if $value or $text doesn't validate
	 */
	public function setSecondary( $value, $text )
	{
		return $this
		->setSecondaryValue( $value )
		->setSecondaryText( $text )
		;
	}
	

	/**
	 * (non-PHPdoc)
	 * @see Geckoboard\Widget.AbstractWidget::getContent()
	 */
	public function getContent()
	{
		// make sure we have a primary value
		\Altumo\Validation\Numerics::assertDouble( $this->getPrimaryValue() );
		
		$wrapper = new \stdClass();
		$wrapper->item = array();
		
		$item = new \stdClass();
		$item->value = $this->getPrimaryValue();
		$item->text = $this->getPrimaryText();
		$wrapper->item []= $item;
		
		if ($this->getSecondaryValue()) {
			$item = new \stdClass();
			$item->value = $this->getSecondaryValue();
			$item->text = $this->getSecondaryText();
			$wrapper->item []= $item;
		}
		
		return $wrapper;
	}
	
}