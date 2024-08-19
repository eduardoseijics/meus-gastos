<?php

namespace App\Controller\Pages;

use App\Core\View;

class Page {

  private static function getHeader() {
    return View::render('pages/components/header');
  }

  private static function getFooter() {
    return View::render('pages/components/footer');
  }

  public static function getPage($content, $title = 'Meus Gastos') {
		return View::render('pages/base', [
			'title' => $title,
			'content' => $content,
			'header' => self::getHeader(),
			'footer' => self::getFooter()
		]);
  }

  public static function getStaticPage($path, $title = 'Meus Gastos') {
        
    $content = View::render($path);
    return self::getPage($content, $title);
  }

}