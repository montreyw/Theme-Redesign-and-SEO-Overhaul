<?php
Class Zend_View_Helper_GenreBar extends Zend_View_Helper_Abstract
{

	protected $_activeKey;
  
  // where the settings are saved
  private $settings = array();

  // default settings (merged in and overridden by argument options)
  private $_defaults = array(
    'url_base' => 'genre',
    'view_all' => '',
    'submenu' => true,
    'show_options' => false
  );
  // passed into partial render
  private $render_vars = array();

	public function genreBar($active = '', $options = array()) {

    if (empty($this->view->genreBarOptions)) {
      $this->view->genreBarOptions = array();
    }
    $this->settings = array_merge($this->_defaults, $this->settings, $this->view->genreBarOptions, $options);
    $this->render_vars['genres'] = array();
    if (!empty($options['genres'])) {
      $this->render_vars['genres'] = $options['genres'];
    } else {
      $this->render_vars['genres'] = array(
        '' => 'VIEW ALL',
        'dance' => 'DANCE',
        'hiphop' => 'HIPHOP',
        'indie' => 'INDIE',
        'electronic' => 'ELECTRONIC',
        'experimental' => 'EXPERIMENTAL',
        'pop' => 'POP',
      );
    }
    
    $this->render_vars['subgenres'] = array();
    if ($this->settings['submenu'] && count($this->render_vars['genres'])) {
      foreach ($this->render_vars['genres'] as $slug => $label) {
        if ($slug) {
        	$params['limit'] = 7;
          $this->render_vars['subgenres'][$slug] = Term::find_children($slug, $params);
        }
      }
    }
    
    if (!$this->_activeKey) {
      $request =  Zend_Controller_Front::getInstance()->getRequest();
      
      if ($category = $request->getParam('category')) {
        if ($category != 'all') {
          $key = $category;  
        }
      }
      
      if ($key) {
        $term = Term::find_by_slug($key);
        if (!empty($term) && is_object($term)) {
          $parent = $term->find_parent()->slug;
        } else {
          $parent = '';
        }
        $this->setActiveKey($parent);
      }
      
    }
    
    $this->render_vars['active'] = $this->_activeKey ? $this->_activeKey : $active;
    // $this->render_vars['urlBase'] = $this->settings['url_base'];
    // $this->render_vars['view_all'] = $this->settings['view_all'];
    $this->render_vars['options'] = $this->settings;
	  echo $this->view->partial('partial/genrebar.phtml', $this->render_vars);

	}

	public function setActiveKey($key) {
		$this->_activeKey = $key;
	}

}