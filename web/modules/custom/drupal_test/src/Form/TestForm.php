<?php

namespace Drupal\drupal_test\Form;

/**
 * @file
 * This file contains class with form.
 */

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class for TestForm.
 */
class TestForm extends FormBase {

  /**
   * Site configurations.
   *
   * @var ConfigFactoryInterface
   *   The site configs.
   */
  protected $config;

  /**
   * The constructor for TestForm class.
   *
   * @param ConfigFactoryInterface $configFactory
   *   The config factory interface.
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->config = $configFactory;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'test_form';
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

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

  /**
   * {@inheritDoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (strlen($form_state->getValue('text')) < 6) {
      $form_state->setErrorByName('text', $this->t('The site name is too short. Please enter at least 6 chars.'));
    }
  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    if($form_state->getValue('text')){
      $this->config->getEditable('system.site')->set('name',$form_state->getValue('text'))->save();
    }
  }
}
