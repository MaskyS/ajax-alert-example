<?php
namespace Drupal\ajax_alert_example\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AlertCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Datetime\Time;

class AjaxAlert extends FormBase {

  public function getFormID() {
    return 'ajax_alert_example';
  }

  //build the form
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['ajax_alert_example'] = [
      '#type' => 'button',
      '#value' => 'Click me!',
      '#ajax' => [
        'callback' => '::alertCallback',
        'event' => 'click', //adding a fancy loader
          'progress' => [
             'type' => 'throbber',
             'message' => 'Starting AJAX engines...',
            ],
          ],
    ];
    return $form;
  }

  /*
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

  /*
   * This will alert the user the current time.
   * @see Drupal\Core\Ajax\AlertCommand; 
   * @see Drupal\Component\Datetime\Time;
   */

  public function alertCallback($form, $form_state) {

    $response = new AjaxResponse();
    $request_time = \Drupal::time()->getCurrentMicroTime();
    $response->addCommand(new AlertCommand("The time you clicked that shiny button is " . $request_time . ", correct to the microsecond!"));
    return $response;
  }
   
}
