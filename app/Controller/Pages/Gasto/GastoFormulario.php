<?php

namespace App\Controller\Pages\Gasto;

use App\Controller\Pages\CategoriaGasto\CategoriaGasto;
use App\Core\View;
use App\Controller\Pages\Page;
use App\Model\Entity\Gasto as ModelGasto;

class GastoFormulario extends Gasto {

  public static function getFormularioCriarGasto() {
    $content = View::render('pages/components/gasto/gasto-formulario', [
      'h1'               => 'Criar Gasto',
      'nome'             => '',
      'descricao'        => '',
      'valor'            => '',
      'opcoes'           => self::getOpcoesCategoriaGasto(),
      'status'           => ''
    ]);
    return Page::getPage($content);
  }

  public static function getOpcoesCategoriaGasto() {
    $varsLayout = '';
    $categorias = CategoriaGasto::getCategoriaGastos();
    foreach ($categorias as $idCategoria => $categoria) {
      $varsLayout .= View::render('pages/components/gasto/gasto-formulario-opcao', [
        'id' => $idCategoria,
        'nome' => $categoria,
        'selected' => ''
      ]);
    }

    return $varsLayout;
  }

  public static function getFormularioEditarGasto($request, $id) {

    $obNoticia = ModelGasto::getGastoPorId($id);

    // Valida se existe uma instância de depoimento
    if (!$obNoticia instanceof ModelGasto) {
      $request->getRouter()->redirect('/admin/noticias');
    }
    
    $content = View::render('admin/components/gasto/gasto-formulario', [      
      'h1'          => 'Editar Gasto',
    ]);
    return Page::getPage($content);
  }





}