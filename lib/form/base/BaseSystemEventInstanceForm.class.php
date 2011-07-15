<?php

/**
 * SystemEventInstance form base class.
 *
 * @method SystemEventInstance getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSystemEventInstanceForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'system_event_id' => new sfWidgetFormPropelChoice(array('model' => 'SystemEvent', 'add_empty' => false)),
      'user_id'         => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'message'         => new sfWidgetFormTextarea(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'SystemEventInstance', 'column' => 'id', 'required' => false)),
      'system_event_id' => new sfValidatorPropelChoice(array('model' => 'SystemEvent', 'column' => 'id')),
      'user_id'         => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'message'         => new sfValidatorString(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(array('required' => false)),
      'updated_at'      => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('system_event_instance[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemEventInstance';
  }


}
