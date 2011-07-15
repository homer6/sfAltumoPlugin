<?php

/**
 * SystemEventInstanceMessage form base class.
 *
 * @method SystemEventInstanceMessage getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSystemEventInstanceMessageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'system_event_instance_id'     => new sfWidgetFormPropelChoice(array('model' => 'SystemEventInstance', 'add_empty' => false)),
      'system_event_subscription_id' => new sfWidgetFormPropelChoice(array('model' => 'SystemEventSubscription', 'add_empty' => false)),
      'received'                     => new sfWidgetFormInputCheckbox(),
      'received_at'                  => new sfWidgetFormDateTime(),
      'status_message'               => new sfWidgetFormInputText(),
      'created_at'                   => new sfWidgetFormDateTime(),
      'updated_at'                   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorPropelChoice(array('model' => 'SystemEventInstanceMessage', 'column' => 'id', 'required' => false)),
      'system_event_instance_id'     => new sfValidatorPropelChoice(array('model' => 'SystemEventInstance', 'column' => 'id')),
      'system_event_subscription_id' => new sfValidatorPropelChoice(array('model' => 'SystemEventSubscription', 'column' => 'id')),
      'received'                     => new sfValidatorBoolean(),
      'received_at'                  => new sfValidatorDateTime(array('required' => false)),
      'status_message'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                   => new sfValidatorDateTime(array('required' => false)),
      'updated_at'                   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('system_event_instance_message[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemEventInstanceMessage';
  }


}
