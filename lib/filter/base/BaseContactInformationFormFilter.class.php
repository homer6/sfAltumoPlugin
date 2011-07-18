<?php

/**
 * ContactInformation filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseContactInformationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name'         => new sfWidgetFormFilterInput(),
      'last_name'          => new sfWidgetFormFilterInput(),
      'email_address'      => new sfWidgetFormFilterInput(),
      'phone_main_number'  => new sfWidgetFormFilterInput(),
      'phone_other_number' => new sfWidgetFormFilterInput(),
      'mailing_address'    => new sfWidgetFormFilterInput(),
      'city'               => new sfWidgetFormFilterInput(),
      'state_id'           => new sfWidgetFormPropelChoice(array('model' => 'State', 'add_empty' => true)),
      'zip_code'           => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'first_name'         => new sfValidatorPass(array('required' => false)),
      'last_name'          => new sfValidatorPass(array('required' => false)),
      'email_address'      => new sfValidatorPass(array('required' => false)),
      'phone_main_number'  => new sfValidatorPass(array('required' => false)),
      'phone_other_number' => new sfValidatorPass(array('required' => false)),
      'mailing_address'    => new sfValidatorPass(array('required' => false)),
      'city'               => new sfValidatorPass(array('required' => false)),
      'state_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'State', 'column' => 'id')),
      'zip_code'           => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('contact_information_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactInformation';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'first_name'         => 'Text',
      'last_name'          => 'Text',
      'email_address'      => 'Text',
      'phone_main_number'  => 'Text',
      'phone_other_number' => 'Text',
      'mailing_address'    => 'Text',
      'city'               => 'Text',
      'state_id'           => 'ForeignKey',
      'zip_code'           => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
