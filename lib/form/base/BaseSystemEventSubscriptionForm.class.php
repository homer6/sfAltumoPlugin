<?php

/**
 * SystemEventSubscription form base class.
 *
 * @method SystemEventSubscription getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSystemEventSubscriptionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'system_event_id' => new sfWidgetFormPropelChoice(array('model' => 'SystemEvent', 'add_empty' => false)),
      'remote_url'      => new sfWidgetFormInputText(),
      'enabled'         => new sfWidgetFormInputCheckbox(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'SystemEventSubscription', 'column' => 'id', 'required' => false)),
      'system_event_id' => new sfValidatorPropelChoice(array('model' => 'SystemEvent', 'column' => 'id')),
      'remote_url'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'enabled'         => new sfValidatorBoolean(),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('system_event_subscription[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemEventSubscription';
  }


}
