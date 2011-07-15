<?php

/**
 * SystemEventInstance filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSystemEventInstanceFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'system_event_id' => new sfWidgetFormPropelChoice(array('model' => 'SystemEvent', 'add_empty' => true)),
      'user_id'         => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'message'         => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'system_event_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystemEvent', 'column' => 'id')),
      'user_id'         => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'message'         => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('system_event_instance_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemEventInstance';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'system_event_id' => 'ForeignKey',
      'user_id'         => 'ForeignKey',
      'message'         => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
