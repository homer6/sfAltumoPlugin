<?php


namespace sfAltumoPlugin\Geckoboard\Widget;


class TextWidget extends \Geckoboard\Widget\AbstractWidget
{

	const TYPE_NONE = 0;
	const TYPE_INFO = 2;
	const TYPE_ALERT = 1;
	

	/**
	 * Maximum number of items that can be sent to Geckoboard in a Text widget.
	 * 
	 * @var int
	 */
	const MAXIMUM_ITEM_COUNT = 10;
	
	
	/**
	 * @var \stdClass[]
	 */
	protected $items = array();
	
	
	/**
	 * 
	 * @param string $text
	 * @param int $type
	 * 
	 * @throws \Exception if maximum number of items reached
	 * 
	 * @return \Geckoboard\Widget\TextWidget
	 */
	public function addItem($text, $type = self::TYPE_NONE)
	{
		$item = new \stdClass();
		
		// pre-validate and set text
		$item->text = \Altumo\Validation\Strings::assertString( $text );
		
		// pre-validate and set type
		$item->type = \Altumo\Validation\Numerics::assertInteger( $type );

		if ( count($this->getItems()) > ( self::MAXIMUM_ITEM_COUNT - 1 ) ) {
			throw new \Exception( "Cannot add new item, maximum count reached" );
		}
		
		// add to items
		$this->items []= $item;

		return $this;
	}
	
	
	/**
	 * @return stdClass[]
	 */
	public function getItems()
	{
		return $this->items;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see Geckoboard\Widget.AbstractWidget::getContent()
	 */
	public function getContent()
	{
		$wrapper = new \stdClass();
		
		$wrapper->item = array();
		
		foreach($this->getItems() as $item) {
			$wrapper->item []= $item;
		}
		
		return $wrapper;
	}
	
}