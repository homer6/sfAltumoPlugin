<?php

/**
 * SingleSignOnKey filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSingleSignOnKeyFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'secret'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'used'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'session_id'        => new sfWidgetFormPropelChoice(array('model' => 'Session', 'add_empty' => true)),
      'valid_for_minutes' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'secret'            => new sfValidatorPass(array('required' => false)),
      'used'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'session_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Session', 'column' => 'id')),
      'valid_for_minutes' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('single_sign_on_key_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SingleSignOnKey';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'secret'            => 'Text',
      'used'              => 'Boolean',
      'session_id'        => 'ForeignKey',
      'valid_for_minutes' => 'Number',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
