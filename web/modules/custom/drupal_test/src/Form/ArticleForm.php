<?php

namespace Drupal\drupal_test\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ArticleForm extends FormBase
{

  protected $config;
  protected $entityType;

  public function __construct(ConfigFactoryInterface $configFactory,  EntityTypeManagerInterface $entityType) {
    $this->config = $configFactory;
    $this->entityType = $entityType;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('entity_type.manager')
    );
  }

  public function getFormId()
  {
    return 'articles_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $articles = $this->entityType->getStorage('node')->loadByProperties(['type' => 'article']);
    $titles = [];
    foreach ($articles as $article) {
      $titles[$article->id()] = $article->label();
    }

    $form['title'] = [
      '#type' => 'select',
      '#title' => $this->t('Article title'),
      '#options' => $titles,
    ];

    $form['status'] = [
      '#type' => 'select',
      '#title' => $this->t('Article status'),
      '#options' => ['published' => 'published', 'unpublished' => 'unpublished'],
    ];

    $form['sticky'] = [
      '#type' => 'select',
      '#title' => $this->t('sticky'),
      '#options' => ['sticky' => 'sticky', 'not sticky' => 'not sticky'],
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['update'] = [
      '#type' => 'submit',
      '#value' => $this->t('Update'),
      '#submit' => [$this, 'update'],
    ];

    $form['actions']['delete'] = [
      '#type' => 'submit',
      '#value' => $this->t('Delete'),
      '#submit' => [$this, 'delete'],
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    return;
  }

}
