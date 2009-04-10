<?php

/**
 * Feed form base class.
 *
 * @package    profile
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseFeedForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'title' => new sfWidgetFormInput(),
      'link'  => new sfWidgetFormInput(),
      'type'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorPropelChoice(array('model' => 'Feed', 'column' => 'id', 'required' => false)),
      'title' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link'  => new sfValidatorString(array('max_length' => 255)),
      'type'  => new sfValidatorString(array('max_length' => 32, 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'Feed', 'column' => array('link')))
    );

    $this->widgetSchema->setNameFormat('feed[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Feed';
  }


}
