<?php


namespace sfAltumoPlugin\Geckoboard\Widget;


class LineChartWidget extends \sfAltumoPlugin\Geckoboard\Widget\AbstractWidget
{
	
	protected $items = array();
	protected $axis_x_descriptors = array();
	protected $axis_y_descriptors = array();
	
	
	/**
	 * @param double $value
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\LineChartWidget
	 * 
	 * @throws \Exception if item fails to validate
	 */
	public function addItem( $value )
	{
		$this->items []= \Altumo\Validation\Numerics::assertDouble( $value );
		
		return $this;
	}
	
	
	/**
	 * @param double[] $values Array of numerical values
	 *
	 * @return \sfAltumoPlugin\Geckoboard\Widget\LineChartWidget
	 * 
	 * @throws \Exception if any item fails to validate
	 */
	public function setItems( $values )
	{
		$this->items = array();
		
		foreach( $values as $value ) $this->addItem( $value );
		
		return $this;
	}
	
	
	/**
	 * @param string[] $descriptors
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\LineChartWidget
	 * 
	 * @throws \Exception if any descriptor fails to validate
	 */
	public function setAxisXDescriptors( $descriptors )
	{
		$this->axis_x_descriptors = array();
		
		foreach($descriptors as $descriptor) $this->addAxisXDescriptor( $descriptor );
		
		return $this;
	}
	

	/**
	 * @param string $descriptor
	 *
	 * @return \sfAltumoPlugin\Geckoboard\Widget\LineChartWidget
	 *
	 * @throws \Exception if descriptor fails to validate
	 */
	public function addAxisXDescriptor( $descriptor )
	{
		$this->axis_x_descriptors []= \Altumo\Validation\Strings::assertString( $descriptor );
		
		return $this;
	}
	
	
	/**
	 * @param string[] $descriptors
	 *
	 * @return \sfAltumoPlugin\Geckoboard\Widget\LineChartWidget
	 *
	 * @throws \Exception if any descriptor fails to validate
	 */
	public function setAxisYDescriptors( $descriptors )
	{
		$this->axis_y_descriptors = array();
		
		foreach( $descriptors as $descriptor ) $this->addAxisYDescriptor( $descriptor );
		
		return $this;
	}
	

	/**
	 * @param string $descriptor
	 * 
	 * @return \sfAltumoPlugin\Geckoboard\Widget\LineChartWidget
	 * 
	 * @throws \Exception if descriptor fails to validate
	 */
	public function addAxisYDescriptor( $descriptor )
	{
		$this->axis_y_descriptors []= \Altumo\Validation\Strings::assertString( $descriptor );
		
		return $this;
	}
	
	
	protected function getItems()
	{
		return $this->items;
	}
	
	protected function getAxisXDescriptors()
	{
		return $this->axis_x_descriptors;
	}
	
	protected function getAxisYDescriptors()
	{
		return $this->axis_y_descriptors;
	}
	
	
	public function getContent()
	{
		$wrapper = new \stdClass();
		
		$wrapper->item = array();
		
		foreach( $this->getItems() as $value ) {
			$wrapper->item []= $value;
		}
		
		$wrapper->settings = new \stdClass();
		$wrapper->settings->axisx = $this->getAxisXDescriptors();
		$wrapper->settings->axisy = $this->getAxisYDescriptors();
		
		return $wrapper;
	}
	
}