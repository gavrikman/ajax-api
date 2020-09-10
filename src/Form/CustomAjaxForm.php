<?php


namespace Drupal\ajaxform\Form;


use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class CustomAjaxForm extends FormBase{


  public function getFormId() {
    return 'custom_ajax_form';
  }

  protected $number;

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#tree'] = TRUE;

    $form['first_field'] = [
      '#title' => 'Input something',
      '#type' => 'textfield',
      '#placeholder' => 'Some text',
      '#tree' => true,
    ];

    $form['add_more'] = [
      '#value' => $this->t('Add More'),
      '#type' => 'submit',
      '#submit' => ['::changeIndex'],
      '#ajax' => [
        'callback' => '::addFieldsCallback',
        'wrapper' => 'container',
      ],
    ];

    $form['container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'container'],
    ];

    return $form;
  }


  public function addFieldsCallback($form, $form_state) {
      for ($i = 1; $i <= $this->number; $i++) {

        $form['container']['name_' . $i] = [
          '#type' => 'textfield',
          '#placeholder' => $this->t('New field ' . $i),
        ];
      }

    return $form['container'];
  }

  public function changeIndex(array &$form, FormStateInterface $form_state) {

    $this->number++;
    $form_state->setRebuild();
  }


  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
  }
}
