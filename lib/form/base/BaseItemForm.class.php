<?php

/**
 * Item form base class.
 *
 * @package    profile
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseItemForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'feed_id'     => new sfWidgetFormPropelChoice(array('model' => 'Feed', 'add_empty' => false)),
      'atomid'      => new sfWidgetFormInput(),
      'title'       => new sfWidgetFormTextarea(),
      'link'        => new sfWidgetFormInput(),
      'description' => new sfWidgetFormTextarea(),
      'published'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Item', 'column' => 'id', 'required' => false)),
      'feed_id'     => new sfValidatorPropelChoice(array('model' => 'Feed', 'column' => 'id')),
      'atomid'      => new sfValidatorString(array('max_length' => 255)),
      'title'       => new sfValidatorString(),
      'link'        => new sfValidatorString(array('max_length' => 255)),
      'description' => new sfValidatorString(),
      'published'   => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'Item', 'column' => array('atomid'))),
        new sfValidatorPropelUnique(array('model' => 'Item', 'column' => array('link'))),
      ))
    );

    $this->widgetSchema->setNameFormat('item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Item';
  }


}
