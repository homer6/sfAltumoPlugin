<?php


namespace sfAltumoPlugin\Geckoboard\Widget;


class GeckOMeterWidget extends \sfAltumoPlugin\Geckoboard\Widget\AbstractWidget
{
	
	/**
	 * Primary value to display
	 * 
	 * @var double
	 */
	protected $item;
	

	/**
	 * Minimum value
	 * 
	 * @var number
	 */
	protected $min_value;
	
	
	/**
	 * Text for minimum value
	 * 
	 * @var string
	 */
	protected $min_text;
	
	
	/**
	 * Maximum value
	 * 
	 * @var number
	 */
	protected $max_value;
	
	
	/**
	 * Text for maximum value
	 * 
	 * @var string
	 */
	protected $max_text;
	


	/**
	 * @param number $v
	 * 
	 * @throws \Exception if $v doesn't validate 
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\NumberAndSecondaryStatWidget
	 */
	public function setMinValue( $v )
	{
		$this->min_value = \Altumo\Validation\Numerics::assertDouble( $v, 'Min value expects a double');
		
		return $this;
	}
	
	
	/**
	 * @return number
	 */
	protected function getMinValue()
	{
		return $this->min_value;
	}
	
	
	/**
	 * @param string $v
	 * 
	 * @throws \Exception if $v doesn't validate
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\NumberAndSecondaryStatWidget
	 */
	public function setMinText( $v )
	{
		$this->min_text = is_null($v) ? $v : \Altumo\Validation\Strings::assertString( $v, 'Min text expects a string' );
		
		return $this;
	}

	
	/**
	 * @return string
	 */
	protected function getMinText()
	{
		return $this->min_text;
	}
	
	
	/**
	 * @param number $value
	 * @param string $text
	 * 
	 * @throws \Exception if $value doesn't validate
	 * @throws \Exception if $text doesn't validate
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\NumberAndSecondaryStatWidget
	 */
	public function setMin( $value, $text )
	{
		$this->setMinValue( $value );
		$this->setMinText( $text );
		
		return $this;
	}

	
	/**
	 * @param number $v
	 * 
	 * @throws \Exception if $v doesn't validate
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\NumberAndSecondaryStatWidget
	 */
	public function setMaxValue( $v )
	{
		$this->max_value = \Altumo\Validation\Numerics::assertDouble( $v, 'Max value expects a double');
		
		return $this;
	}
	

	/**
	 * @return number
	 */
	protected function getMaxValue()
	{
		return $this->max_value;
	}
	
	
	/**
	 * @param string $v
	 * 
	 * @throws \Exception if $v doesn't validate
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\NumberAndSecondaryStatWidget
	 */
	public function setMaxText( $v )
	{
		$this->max_text = is_null($v) ? $v : \Altumo\Validation\Strings::assertString( $v, 'Max text expects a string' );
		
		return $this;
	}
	

	/**
	 * @return string
	 */
	protected function getMaxText()
	{
		return $this->max_text;
	}
	
	
	/**
	 * @param number $value
	 * @param string $text
	 *
	 * @throws \Exception if $value doesn't validate
	 * @throws \Exception if $text doesn't validate
	 *
	 * @return \sfAltumoPlugin\Geckoboard\Widget\NumberAndSecondaryStatWidget
	 */
	public function setMax( $value, $text )
	{
		$this->setMaxValue( $value );
		$this->setMaxText( $text );
	
		return $this;
	}
	
	
	
	/**
	 * 
	 * @param number $v
	 * 
	 * @throws \Exception if $v doesn't validate
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\NumberAndSecondaryStatWidget
	 */
	public function setItem( $v )
	{
		$this->item = \Altumo\Validation\Numerics::assertDouble( $v, 'Item expects a double' );
		
		return $this;
	}
	
	
	/**
	 * @return number
	 */
	protected function getItem()
	{
		return $this->item;
	}
	
	

	/**
	 * (non-PHPdoc)
	 * @see Geckoboard\Widget.AbstractWidget::getContent()
	 */
	public function getContent()
	{
		// make sure we have a primary value
		\Altumo\Validation\Numerics::assertDouble( $this->getItem(), 'An item is required' );
		
		$wrapper = new \stdClass();
		
		$wrapper->item = $this->getItem();
		
		
		$min = new \stdClass();
		$min->value = $this->getMinValue();
		$min->text = $this->getMinText();
		
		$wrapper->min = $min;
		
		
		$max = new \stdClass();
		$max->value = $this->getMaxValue();
		$max->text = $this->getMaxText();
		
		$wrapper->max = $max;
		
		
		return $wrapper;
	}
	
}