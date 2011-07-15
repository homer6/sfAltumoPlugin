<?php

/**
 * Session form base class.
 *
 * @method Session getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSessionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'session_key'       => new sfWidgetFormInputText(),
      'data'              => new sfWidgetFormInputText(),
      'client_ip_address' => new sfWidgetFormInputText(),
      'session_type'      => new sfWidgetFormInputText(),
      'time'              => new sfWidgetFormInputText(),
      'user_id'           => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'Session', 'column' => 'id', 'required' => false)),
      'session_key'       => new sfValidatorString(array('max_length' => 32)),
      'data'              => new sfValidatorPass(array('required' => false)),
      'client_ip_address' => new sfValidatorString(array('max_length' => 39, 'required' => false)),
      'session_type'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'time'              => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'user_id'           => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Session', 'column' => array('session_key')))
    );

    $this->widgetSchema->setNameFormat('session[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session';
  }


}
