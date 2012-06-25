<?php


namespace sfAltumoPlugin\Geckoboard\Widget;


class TextWidget extends \sfAltumoPlugin\Geckoboard\Widget\AbstractWidget
{

	const TYPE_NONE = 0;
	const TYPE_INFO = 2;
	const TYPE_ALERT = 1;
	
    // enumerations for the different widget heights available on Geckoboard
    const WIDGET_TYPE_SINGLE = 1;
    const WIDGET_TYPE_DOUBLE = 2;

    // the default color of the bars displayed in the funnel chart
    const DEFAULT_CHART_COLOR = '#77ab13';

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
	 * @return \sfAltumoPlugin\Geckoboard\Widget\TextWidget
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



    /**
     * create HTML to display a funnel chart
     *
     * @static
     * @param     $chart_title
     * @param     $chart_data array containing attributes for each funnel chart item (label, value, color)
     * @param int $widget_type
     * @return string
     *
     * e.g.
     *  $funnel_data[] = array(
     *       'label'	=> 'Item A',
     *       'value'	=> 3,
     *       'color'    => '#c00'
     *   );
     *
     *   $widget->addItem( \sfAltumoPlugin\Geckoboard\Widget\TextWidget::GenerateFunnelChartHtml( "pane title", $funnel_data, \sfAltumoPlugin\Geckoboard\Widget\TextWidget::WIDGET_TYPE_SINGLE ) );
     *
     */
    public static function GenerateFunnelChartHtml( $chart_title, $chart_data, $widget_type = self::WIDGET_TYPE_DOUBLE )
    {
        $chart_data_count = sizeof( $chart_data );
        $row_height = ( $chart_data_count !== 0 ) ? floor( 100 / $chart_data_count ) : 0;

        // set the widget attributes based on the widget type
        switch( $widget_type )
        {
            case self::WIDGET_TYPE_SINGLE:
                $container_height = 92;
                $font_size = 11;
                $line_height = 12;
                break;
            case self::WIDGET_TYPE_DOUBLE:
            default:
                $container_height = 343;
                $font_size = 14;
                $line_height = 48;
                break;
        }


        // find the largest value in the data set (this will be the largest bar)
        $max_value = 0;
        foreach( $chart_data as $data ) {
            $value = intval( $data['value'] );
            if ( $value > $max_value )
                $max_value = $value;
        }

        // build the HTML
        $html = array();
        $html[] = '<section class="b-widget-body">';
        $html[] = '<h2 style="font-size:14px; color:#D3D4D4;">' . $chart_title . '</h2>';
        $html[] = '<div class="b-widget-inner">';
        $html[] = '<ul style="list-style-type:none; height:' . $container_height . 'px;">';

        foreach( $chart_data as $data ) {
            $label = $data['label'];
            $value = $data['value'];
            $color = ( !empty( $data['color'] ) )? $data['color'] : self::DEFAULT_CHART_COLOR;
            $bar_size = ( $max_value !== 0 ) ? $value / $max_value * 100 : 0;

            $html[] = '<li style="margin-bottom:1px; height:' . $row_height . '%; line-height:' . $line_height . 'px;">';

            $html[] = '<div style="width:50%; clear:both; float:right; margin:0; padding:0; font-size:' . $font_size . 'px; line-height:' . $line_height . 'px;">';
            $html[] = '<span style="color:#D3D4D4; font-size:1.1em; font:bold; margin:0;">&nbsp;' . $value . '</span>&nbsp;' . $label;
            $html[] = '</div>';

            $html[] = '<div style="width:50%; float:right; margin:0; padding:0; line-height:' . $line_height . 'px;">';
            $html[] = '<div style="width:' . $bar_size . '%; height:100%; float:right; margin:0 0 1px 0; background-color:' . $color . '; border-right:1px solid ' . $color . ';">&nbsp;</div>';
            $html[] = '</div>';

            $html[] = '</li>';
        }

        $html[] = '</ul>';
        $html[] = '</div>';
        $html[] = '</section>';

        return implode('', $html);
    }
}