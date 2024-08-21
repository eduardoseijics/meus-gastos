<?php

namespace App\Model\Entity;

use App\Core\Database;

class CategoriaGasto {
  
  private int $id;

  private string $nome;

  public function getId() {
    return $this->id;
  }
  
  public function getNome() {
    return $this->nome;
  }

  public function setNome($nome) {
    $this->nome = $nome;
    return $this;
  }

  public static function getCategoriaGastos($where = null, $order = null, $limit = '100', $fields = '*') {
    return (new Database('categoria_gasto'))->select($where, $order, $limit, $fields);
  }
}