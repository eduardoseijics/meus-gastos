<?php

namespace App\Controller\Pages\Gasto;

use PDO;
use App\Core\View;
use App\Model\Entity\Gasto as ModelGasto;

class GastoListagem {
  
  public function getGastosUltimosTrintaDias() {
    $gasto = ModelGasto::getGastos('data >= CURDATE() - INTERVAL 30 DAY;', null, null, 'SUM(valor) AS total');
    return $gasto->fetchObject()->total;
  }

  public function getListagemGastos() {
    $query = 'SELECT a.*, b.nome AS categoria 
              FROM gasto AS a 
              INNER JOIN categoria_gasto AS b 
              WHERE a.id_categoria_gasto = b.id 
              ORDER BY a.data DESC';
    $arrGastos = ModelGasto::getGastosByQuery($query)->fetchAll(PDO::FETCH_CLASS, ModelGasto::class);
    $varsLayout = '';
    foreach ($arrGastos as $key => $obModelGasto) {
      $valor = $obModelGasto->getValor();

      $varsLayout .= View::render('pages/components/gasto/listagem/gasto-listagem-item', [
        'nome' => $obModelGasto->getNome(),
        'valor' => number_format($valor, 2, ',', ''),
        'data'  => date("d/m/Y", strtotime($obModelGasto->getData())),
        'descricao' => $obModelGasto->getDescricao()
      ]);
    }
    return View::render('pages/components/gasto/listagem/gasto-listagem', [
      'itens' => $varsLayout
    ]);
  }

  public function getGastoPorCategoria() {
    $query = 'SELECT cg.nome AS nome_categoria, SUM(g.valor) AS total_gasto 
            FROM gasto g
            JOIN categoria_gasto cg ON g.id_categoria_gasto = cg.id
            GROUP BY cg.nome
            ORDER BY total_gasto DESC;';
    $arrGastos = ModelGasto::getGastosByQuery($query)->fetchAll(PDO::FETCH_CLASS, ModelGasto::class);
  }
}