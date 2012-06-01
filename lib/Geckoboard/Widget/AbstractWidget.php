<?php


namespace sfAltumoPlugin\Geckoboard\Widget;


abstract class AbstractWidget {

	
	/**
	 * Returns data to be sent to the response
	 * 
	 * @return \stdClass
	 */
	protected function getContent()
	{
		return new \stdClass();
	}
	
	
	/**
	 * Export data to JSON
	 * 
	 * @return string
	 */
	public function toJSON()
	{
		return json_encode( $this->getContent() );
	}
	
}