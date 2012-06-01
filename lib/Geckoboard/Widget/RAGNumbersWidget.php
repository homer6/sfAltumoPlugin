<?php


namespace sfAltumoPlugin\Geckoboard\Widget;


class RAGNumbersWidget extends \Geckoboard\Widget\AbstractWidget
{
	
	/**
	 * @var double
	 */
	protected $red_value;

	/**
	 * @var string
	 */
	protected $red_text;

	
	/**
	 * @var double
	 */
	protected $amber_value;

	/**
	 * @var string
	 */
	protected $amber_text;
	
	
	/**
	 * @var double
	 */
	protected $green_value;

	/**
	 * @var string
	 */
	protected $green_text;
	
	
	/**
	 * Sets the red value
	 * 
	 * @param double $value
	 * 
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setRedValue( $value )
	{
		$this->red_value = \Altumo\Validation\Numerics::assertDouble( $value );
		
		return $this;
	}
	
	/**
	 * Sets text for the red value
	 * 
	 * @param string $text
	 * 
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setRedText( $text )
	{
		$this->red_text = $text;
		
		return $this;
	}
	
	
	/**
	 * Sets red value and number
	 * 
	 * @param double $value
	 * @param string $text
	 * 
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setRed( $value, $text )
	{
		$this->setRedValue($value);
		$this->setRedText($text);
		
		return $this;
	}
	
	
	/**
	 * Sets to green value
	 * 
	 * @param double $value
	 * 
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setGreenValue( $value )
	{
		$this->green_value = \Altumo\Validation\Numerics::assertDouble( $value );
		
		return $this;
	}

	
	/**
	 * Sets text for the green value
	 *
	 * @param string $text
	 * 
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setGreenText( $text )
	{
		$this->green_text = $text;
	
		return $this;
	}
	
	
	/**
	 * Sets green value and text
	 * 
	 * @param double $value
	 * @param string $text
	 * 
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setGreen( $value, $text )
	{
		$this->setGreenValue( $value );
		$this->setGreenText( $text );
		
		return $this;
	}
	
	
	/**
	 * Sets the amber value
	 *
	 * @param double $value
	 *
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setAmberValue( $value )
	{
		$this->amber_value = \Altumo\Validation\Numerics::assertDouble( $value );
		
		return $this;
	}

	
	/**
	 * Sets text for the amber value
	 *
	 * @param string $text
	 * 
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setAmberText( $text )
	{
		$this->amber_text = $text;
	
		return $this;
	}
	
	
	/**
	 * Sets amber value and text
	 * 
	 * @param double $value
	 * @param string $text
	 * 
	 * @return \Geckoboard\Widget\RAGNumbersWidget
	 */
	public function setAmber($value, $text)
	{
		$this->setAmberValue( $value );
		$this->setAmberText( $text );
		
		return $this;
	}
	
	
	/**
	 * 
	 * @return \stdClass
	 */
	public function getContent()
	{
		$content = new \stdClass();
		
		$content->item = array();

		$red_item = new \stdClass();
		$red_item->value = $this->red_value;
		$red_item->text = $this->red_text;
		$content->item[0] = $red_item;
		
		$amber_item = new \stdClass();
		$amber_item->value = $this->amber_value;
		$amber_item->text = $this->amber_text;
		$content->item[1] = $amber_item;
		
		$green_item = new \stdClass();
		$green_item->value = $this->green_value;
		$green_item->text = $this->green_text;
		$content->item[2] = $green_item;
		
		return $content;
	}
	
}