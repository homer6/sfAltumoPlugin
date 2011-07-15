<?php

/**
 * SingleSignOnKey form base class.
 *
 * @method SingleSignOnKey getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSingleSignOnKeyForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'secret'            => new sfWidgetFormInputText(),
      'used'              => new sfWidgetFormInputCheckbox(),
      'session_id'        => new sfWidgetFormPropelChoice(array('model' => 'Session', 'add_empty' => true)),
      'valid_for_minutes' => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'SingleSignOnKey', 'column' => 'id', 'required' => false)),
      'secret'            => new sfValidatorString(array('max_length' => 32)),
      'used'              => new sfValidatorBoolean(),
      'session_id'        => new sfValidatorPropelChoice(array('model' => 'Session', 'column' => 'id', 'required' => false)),
      'valid_for_minutes' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'SingleSignOnKey', 'column' => array('secret')))
    );

    $this->widgetSchema->setNameFormat('single_sign_on_key[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SingleSignOnKey';
  }


}
