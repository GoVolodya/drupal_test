<?php

namespace Drupal\drupal_test\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TestForm extends FormBase
{

  protected $config;

  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->config = $configFactory;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  public function getFormId()
{
  return 'test_form';
}

  public function buildForm(array $form, FormStateInterface $form_state)
{
  $form['text'] = [
    '#type' => 'textfield',
    '#title' => $this->t('Title'),
    '#placeholder' => $this->config('system.site')->get('name'),
  ];
  $form['actions']['#type'] = 'actions';
  $form['actions']['submit'] = [
    '#type' => 'submit',
    '#value' => $this->t('Submit'),
    '#button_type' => 'primary',
  ];
  return $form;
}

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('text')) < 6) {
      $form_state->setErrorByName('text', $this->t('The site name is too short. Please enter at least 6 chars.'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
{
  if($form_state->getValue('text')){
    $this->config->getEditable('system.site')->set('name',$form_state->getValue('text'))->save();
  }
}
}
