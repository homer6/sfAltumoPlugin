<?php

/**
 * Country form base class.
 *
 * @method Country getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseCountryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'iso_code'       => new sfWidgetFormInputText(),
      'iso_short_code' => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Country', 'column' => 'id', 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 64)),
      'iso_code'       => new sfValidatorString(array('max_length' => 12)),
      'iso_short_code' => new sfValidatorString(array('max_length' => 2)),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Country', 'column' => array('iso_short_code')))
    );

    $this->widgetSchema->setNameFormat('country[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Country';
  }


}
