<?php


namespace sfAltumoPlugin\Geckoboard\Widget;


class FunnelWidget extends \Geckoboard\Widget\AbstractWidget
{
	
	protected $items = array();
	protected $is_reverse = false;
	protected $is_percentage_enabled = false;
	
	
	/**
	 * Adds an item
	 * 
	 * @param double $value
	 * @param string $label
	 * 
	 * @throws \Exception if $value doesn't validate
	 * @throws \Exception if $label doesn't validate
	 * 
	 * @return \Geckoboard\Widget\FunnelWidget 
	 */
	public function addItem( $value, $label )
	{
		$value = \Altumo\Validation\Numerics::assertDouble( $value );
		
		$label = \Altumo\Validation\Strings::assertString( $label );
		
		$item = new \stdClass();
		$item->value = $value;
		$item->label = $label;
		
		$this->items []= $item;
		
		return $this;
	}
	
	
	/**
	 * Returns an array of items as \stdClass objects
	 * 
	 * @return \stdClass[]
	 */
	protected function getItems()
	{
		return $this->items;
	}
	
	
	/**
	* Determines whether (true) the widget should be rendered as reverse,
	* i.e. with red at the top and green at the bottom, or (false) with 
	* green at the top and red at the bottom.
	* 
	* @param bool $reverse
	* 
	* @throws \Exception if value doesn't validate
	* 
	* @return \Geckoboard\Widget\FunnelWidget
	*/
	public function setReverse( $reverse = true )
	{
		$this->is_reverse = \Altumo\Validation\Booleans::assertLooseBoolean( $reverse );
		
		return $this;
	}
	
	
	/**
	 * Returns true if the widget should be rendered as reverse,
	 * i.e. with red at the top and green at the bottom, or false
	 * if with green at the top and red at the bottom.
	 * 
	 * @return bool
	 */
	protected function isReverse()
	{
		return $this->is_reverse;
	}
	

	/**
	 * Determines whether or not percentages should be shown in the widget
	 * 
	 * @param bool $enabled
	 * 
	 * @return \Geckoboard\Widget\FunnelWidget
	 * 
	 * @throws \Exception if value doesn't validate
	 */
	public function setPercentageEnabled( $enabled = true )
	{ 
		$this->is_percentage_enabled = \Altumo\Validation\Booleans::assertLooseBoolean( $enabled );
		
		return $this;
	}
	
	
	/**
	 * @return bool
	 */
	protected function isPercentageEnabled()
	{
		return $this->is_percentage_enabled;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Geckoboard\Widget.AbstractWidget::getContent()
	 */
	public function getContent()
	{
		$content = new \stdClass();
		
		// determine whether red should be at bottom (reverse) or top (not)
		if ($this->isReverse()) $content->type = 'reverse';
		
		// determine whether percentages should be shown
		$content->percentage = $this->isPercentageEnabled() ? 'show' : 'hide';
		
		$content->item = array();
		foreach( $this->getItems() as $item ) $content->item []= $item;
		
		return $content;
	}
	
}