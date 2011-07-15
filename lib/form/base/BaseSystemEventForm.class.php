<?php

/**
 * SystemEvent form base class.
 *
 * @method SystemEvent getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSystemEventForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'unique_key' => new sfWidgetFormInputText(),
      'slug'       => new sfWidgetFormInputText(),
      'enabled'    => new sfWidgetFormInputCheckbox(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'SystemEvent', 'column' => 'id', 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 64)),
      'unique_key' => new sfValidatorString(array('max_length' => 64)),
      'slug'       => new sfValidatorString(array('max_length' => 255)),
      'enabled'    => new sfValidatorBoolean(),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
      'updated_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'SystemEvent', 'column' => array('unique_key'))),
        new sfValidatorPropelUnique(array('model' => 'SystemEvent', 'column' => array('slug'))),
      ))
    );

    $this->widgetSchema->setNameFormat('system_event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemEvent';
  }


}
