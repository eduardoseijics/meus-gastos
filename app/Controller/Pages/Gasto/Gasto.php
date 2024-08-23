<?php

namespace App\Controller\Pages\Gasto;

use App\Http\Request;
use App\Controller\Alert;
use App\Controller\Pages\Page;
use App\Model\Entity\Gasto as ModelGasto;

class Gasto extends Page {


  /**
   * Retorna mensagem de status
   *
   * @param  Request $request
   * @return string
   */
  public static function getStatus($request) {
    $queryParams = $request->getQueryParams();

    if (!isset($queryParams['status'])) return '';

    switch ($queryParams['status']) {
      case 'created':
        return Alert::getSuccess('Gasto <b>adicionado</b> com sucesso!');
      case 'updated':
        return Alert::getSuccess('Gasto <b>atualizado</b> com sucesso!');
      case 'deleted':
        return Alert::getSuccess('Gasto <b>excluído</b> com sucesso!');
      default:
        return '';
    }
  }
  
  public static function criar($request) {
    $postVars = $request->getPostVars();
    ModelGasto::criar($postVars);
    $request->getRouter()->redirect('/adicionar-gasto?status=created');

  }

  public static function deletarGasto($request, $id) {
    $obGasto = ModelGasto::getGastoPorId($id);
    
    // Valida se existe uma instância de depoimento
    if (!$obGasto instanceof ModelGasto) {
      $request->getRouter()->redirect('/admin/noticias');
    }

    // Exclui o depoimento
    $obGasto->delete();

    $request->getRouter()->redirect('/?status=deleted');
  }
}