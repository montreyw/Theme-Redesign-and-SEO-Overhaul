<?php
use Earmilk\Misc\Analytics\Pageviews\Popular as Popular;
class Zend_View_Helper_GenreTrends extends Zend_View_Helper_Abstract
{
  public $_defaults = array();
  public $settings = array();

  private $view_data = array();


  public function render($genre) {
    $this->genre = $genre;
    $this->view_data['genre'] = $genre;
    $this->initializeData();
    return $this->view->partial('chartbeat/genre-statbox.phtml', $this->view_data);
  }

  public function initializeData() {
    $this->getWeek();
    $this->getMonth();
  }

  public function getWeek() {

    $key = "GENRE_TRENDS_WEEK_".$this->genre;

    if(MEMCACHE) { 
      $memcache = Zend_Registry::get('memcache');
      $popular = $memcache->get($key);
    }

    if (empty($popular)) {
      $popular = array_slice(Popular::genre('week', $this->genre, true), 0, 10);
      foreach ($popular as $i => $row) {
        $article = Article::get($row['post_id']);
        $popular[$i] = new ArticlePresenter($article[0]);
      }
      if (MEMCACHE && count($popular) > 5) {
        $memcache->set($key, $popular, 7200);
      }
    }
    
    $this->view_data['week'] = $popular;
  }
  public function getMonth() {
    $key = "GENRE_TRENDS_MONTH_".$this->genre;

    if(MEMCACHE) { 
      $memcache = Zend_Registry::get('memcache');
      $popular = $memcache->get($key);
    }

    if (empty($popular)) {
      $popular = array_slice(Popular::genre('month', $this->genre, true), 0, 10);
      foreach ($popular as $i => $row) {
        $article = Article::get($row['post_id']);
        $popular[$i] = new ArticlePresenter($article[0]);
      }
      if (MEMCACHE) {
        if (count($popular) > 5) {
          $memcache->set($key, $popular, 7200);
        }
      }
    }
    $this->view_data['month'] = $popular;
  }

}