<?php

/**
 * SystemEventInstanceMessage filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSystemEventInstanceMessageFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'system_event_instance_id'     => new sfWidgetFormPropelChoice(array('model' => 'SystemEventInstance', 'add_empty' => true)),
      'system_event_subscription_id' => new sfWidgetFormPropelChoice(array('model' => 'SystemEventSubscription', 'add_empty' => true)),
      'received'                     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'received_at'                  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'status_message'               => new sfWidgetFormFilterInput(),
      'created_at'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'                   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'system_event_instance_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystemEventInstance', 'column' => 'id')),
      'system_event_subscription_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'SystemEventSubscription', 'column' => 'id')),
      'received'                     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'received_at'                  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'status_message'               => new sfValidatorPass(array('required' => false)),
      'created_at'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'                   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('system_event_instance_message_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemEventInstanceMessage';
  }

  public function getFields()
  {
    return array(
      'id'                           => 'Number',
      'system_event_instance_id'     => 'ForeignKey',
      'system_event_subscription_id' => 'ForeignKey',
      'received'                     => 'Boolean',
      'received_at'                  => 'Date',
      'status_message'               => 'Text',
      'created_at'                   => 'Date',
      'updated_at'                   => 'Date',
    );
  }
}
