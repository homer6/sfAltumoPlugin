<?php

/**
 * Country filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseCountryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'iso_code'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'iso_short_code' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'iso_code'       => new sfValidatorPass(array('required' => false)),
      'iso_short_code' => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('country_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Country';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'name'           => 'Text',
      'iso_code'       => 'Text',
      'iso_short_code' => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
