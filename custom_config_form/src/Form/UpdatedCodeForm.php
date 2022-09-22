<?php

namespace Drupal\custom_config_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;

/**
 * Class DefaultForm.
 */
class DefaultForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'custom_config_form.default',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'default_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $config = $this->config('custom_config_form.default');
    $language_list = \Drupal::languageManager()->getLanguages();
	$langcodes_options[] = 'Select Language';
      foreach ($language_list as $language) {
        $langcodes_options[($language->getId())] = $language->getName();
       
      }
	$form['#prefix'] = '<div id="template_form_wrapper">';
	$form['#suffix'] = '</div>';
 $master_selection = ! empty($form_state->getValue('select_language')) ? $form_state->getValue('select_language') : t('Select');
 
if(isset($langcodes_options)){

$form['form_settings'] = array(
 '#type' => 'fieldset',
 '#title' => t('Title'),
 '#open' => TRUE,
);
$form['form_settings']['select_language'] = array(
 '#type' => 'select',
 '#title' => t('Choose language'),
 '#default_value' => $master_selection,
 '#options' => $langcodes_options,
 '#weight' => '-5',
 '#ajax' => [
 'callback' => '::default_form_populate',
 'disable-refocus' => FALSE,
 'event' => 'change',
 'wrapper' => 'template_form_wrapper',
 'progress' => [
 'type' => 'throbber',
 'message' => $this->t('Please wait...'),
],
 ]
);

if ($master_selection != 'Select') {
      $form['form_settings'][$master_selection . '_inputfield'] = array(
        '#type' => 'textfield',
        '#title' => t('Input Field'),
        '#description' => t(''),
        '#default_value' => $config->get($master_selection. '_inputfield'),
        );
    }
        else {
            $form['form_settings']['help'] = array(
              '#type' => 'markup',
              '#markup' => t('Please select any lansguage')
            );
          }
           
          }  
       
          return parent::buildForm($form, $form_state);
       
   
}

public function default_form_populate(array &$form, FormStateInterface $form_state) {
   return $form;
 
  }     

   
    
     
       


  public function submitForm(array &$form, FormStateInterface $form_state) {

 $form_values = $form_state->getValues();

    foreach ($form_values as $key => $value) {
      \Drupal::service('config.factory')->getEditable('custom_config_form.default')->set($key , $value)->save();
      } 
      parent::submitForm($form, $form_state);
  
}

  

}
