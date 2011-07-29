<?php

/**
 * Session filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSessionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'session_key'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'data'              => new sfWidgetFormFilterInput(),
      'client_ip_address' => new sfWidgetFormFilterInput(),
      'session_type'      => new sfWidgetFormFilterInput(),
      'time'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'session_key'       => new sfValidatorPass(array('required' => false)),
      'data'              => new sfValidatorPass(array('required' => false)),
      'client_ip_address' => new sfValidatorPass(array('required' => false)),
      'session_type'      => new sfValidatorPass(array('required' => false)),
      'time'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('session_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'session_key'       => 'Text',
      'data'              => 'Text',
      'client_ip_address' => 'Text',
      'session_type'      => 'Text',
      'time'              => 'Number',
    );
  }
}
