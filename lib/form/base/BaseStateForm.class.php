<?php

/**
 * State form base class.
 *
 * @method State getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseStateForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'name'           => new sfWidgetFormInputText(),
      'iso_code'       => new sfWidgetFormInputText(),
      'iso_short_code' => new sfWidgetFormInputText(),
      'country_id'     => new sfWidgetFormPropelChoice(array('model' => 'Country', 'add_empty' => false)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'State', 'column' => 'id', 'required' => false)),
      'name'           => new sfValidatorString(array('max_length' => 64)),
      'iso_code'       => new sfValidatorString(array('max_length' => 12)),
      'iso_short_code' => new sfValidatorString(array('max_length' => 2)),
      'country_id'     => new sfValidatorPropelChoice(array('model' => 'Country', 'column' => 'id')),
      'created_at'     => new sfValidatorDateTime(array('required' => false)),
      'updated_at'     => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'State', 'column' => array('iso_short_code')))
    );

    $this->widgetSchema->setNameFormat('state[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'State';
  }


}
