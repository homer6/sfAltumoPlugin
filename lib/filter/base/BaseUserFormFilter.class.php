<?php

/**
 * User filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'contact_information_id' => new sfWidgetFormPropelChoice(array('model' => 'ContactInformation', 'add_empty' => true)),
      'salt'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password_reset_key'     => new sfWidgetFormFilterInput(),
      'active'                 => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'email'                  => new sfValidatorPass(array('required' => false)),
      'contact_information_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'ContactInformation', 'column' => 'id')),
      'salt'                   => new sfValidatorPass(array('required' => false)),
      'password'               => new sfValidatorPass(array('required' => false)),
      'password_reset_key'     => new sfValidatorPass(array('required' => false)),
      'active'                 => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'email'                  => 'Text',
      'contact_information_id' => 'ForeignKey',
      'salt'                   => 'Text',
      'password'               => 'Text',
      'password_reset_key'     => 'Text',
      'active'                 => 'Boolean',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
    );
  }
}
