<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Sitefeed filter form base class.
 *
 * @package    profile
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseSitefeedFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'site_id'    => new sfWidgetFormPropelChoice(array('model' => 'Site', 'add_empty' => true)),
      'feed_id'    => new sfWidgetFormPropelChoice(array('model' => 'Feed', 'add_empty' => true)),
      'collection' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'site_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Site', 'column' => 'id')),
      'feed_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Feed', 'column' => 'id')),
      'collection' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sitefeed_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sitefeed';
  }

  public function getFields()
  {
    return array(
      'site_id'    => 'ForeignKey',
      'feed_id'    => 'ForeignKey',
      'collection' => 'Text',
      'id'         => 'Number',
    );
  }
}
