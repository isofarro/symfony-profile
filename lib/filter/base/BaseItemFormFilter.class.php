<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Item filter form base class.
 *
 * @package    profile
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 15484 2009-02-13 13:13:51Z fabien $
 */
class BaseItemFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'feed_id'     => new sfWidgetFormPropelChoice(array('model' => 'Feed', 'add_empty' => true)),
      'atomid'      => new sfWidgetFormFilterInput(),
      'title'       => new sfWidgetFormFilterInput(),
      'link'        => new sfWidgetFormFilterInput(),
      'description' => new sfWidgetFormFilterInput(),
      'published'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'feed_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Feed', 'column' => 'id')),
      'atomid'      => new sfValidatorPass(array('required' => false)),
      'title'       => new sfValidatorPass(array('required' => false)),
      'link'        => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'published'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Item';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'feed_id'     => 'ForeignKey',
      'atomid'      => 'Text',
      'title'       => 'Text',
      'link'        => 'Text',
      'description' => 'Text',
      'published'   => 'Date',
    );
  }
}
