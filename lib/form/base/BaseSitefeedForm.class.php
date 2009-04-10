<?php

/**
 * Sitefeed form base class.
 *
 * @package    profile
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseSitefeedForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'site_id'    => new sfWidgetFormPropelChoice(array('model' => 'Site', 'add_empty' => false)),
      'feed_id'    => new sfWidgetFormPropelChoice(array('model' => 'Feed', 'add_empty' => false)),
      'collection' => new sfWidgetFormInput(),
      'id'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'site_id'    => new sfValidatorPropelChoice(array('model' => 'Site', 'column' => 'id')),
      'feed_id'    => new sfValidatorPropelChoice(array('model' => 'Feed', 'column' => 'id')),
      'collection' => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'id'         => new sfValidatorPropelChoice(array('model' => 'Sitefeed', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sitefeed[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sitefeed';
  }


}
