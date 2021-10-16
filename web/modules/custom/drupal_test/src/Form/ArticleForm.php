<?php

namespace Drupal\drupal_test\Form;

/**
 * @file
 * This file contains ArticleForm class.
 */

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The ArticleForm class.
 */
class ArticleForm extends FormBase {

  /**
   * Entity type manager.
   *
   * @var EntityTypeManagerInterface
   *   The entity type manager.
   */
  protected $entityType;

  /**
   * The constructor for ArticleForm class.
   *
   * @param EntityTypeManagerInterface $entityType
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entityType) {
    $this->entityType = $entityType;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
    return 'articles_form';
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
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

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // This method should be declared, but we use form submit handlers declared in drupal_test.module file.
  }

}
