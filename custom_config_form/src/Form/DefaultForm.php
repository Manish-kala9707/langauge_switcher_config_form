<?php

namespace Drupal\custom_config_form\Form;

use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\File\Exception\FileException;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\StreamWrapper\PublicStream;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\domain\DomainStorageInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Theme\ThemeManagerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;

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

 $master_selection = ! empty($form_state->getValue('select_language')) ? $form_state->getValue('select_language') : t('Select');
 
if (! empty($langcodes_options)) {
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
'callback' => '::form_populate',
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

 
      

   
    
     
       


  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $language_list = \Drupal::languageManager()->getLanguages();
    $langcodes_options[] = 'Select Language';
    foreach ($language_list as $language) {
      $id = $language->getId();
      $language = $language->getName();
    
   


    
    $this->config('custom_config_form.default')
    
    
    ->set($master_selection.'_inputfield', $form_state->getValue($master_selection.'_inputfield'))
    ->set($master_selection, $form_state->getValue($master_selection))
    
    

    
      

      
      ->save();
  }
}

  public function form_populate(array &$form, FormStateInterface $form_state) {
   return $form;
 
  }

}
