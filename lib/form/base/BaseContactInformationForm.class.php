<?php

/**
 * ContactInformation form base class.
 *
 * @method ContactInformation getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseContactInformationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'first_name'         => new sfWidgetFormInputText(),
      'last_name'          => new sfWidgetFormInputText(),
      'email_address'      => new sfWidgetFormInputText(),
      'phone_main_number'  => new sfWidgetFormInputText(),
      'phone_other_number' => new sfWidgetFormInputText(),
      'mailing_address'    => new sfWidgetFormInputText(),
      'city'               => new sfWidgetFormInputText(),
      'state_id'           => new sfWidgetFormPropelChoice(array('model' => 'State', 'add_empty' => true)),
      'zip_code'           => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'ContactInformation', 'column' => 'id', 'required' => false)),
      'first_name'         => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'last_name'          => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'email_address'      => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'phone_main_number'  => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'phone_other_number' => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'mailing_address'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'city'               => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'state_id'           => new sfValidatorPropelChoice(array('model' => 'State', 'column' => 'id', 'required' => false)),
      'zip_code'           => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contact_information[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactInformation';
  }


}
