<?php

namespace App\Model\Entity;

use App\Core\Database;

class Gasto {
  
  private int $id = 0;

  private string $nome = '';

  private int $id_categoria_gasto = 1;

  private string $valor = '0'; // Usando string para armazenar valores DECIMAL

  private int $id_usuario;

  private string $descricao;

  private string $data_criacao;

  private ?string $data_ultima_atualizacao;

  /**
   * @return int
   */
  public function getId(): int
  {
      return $this->id;
  }

  /**
   * @return string
   */
  public function getNome(): string
  {
      return $this->nome;
  }

  /**
   * @param string $nome
   */
  public function setNome(string $nome): void
  {
      $this->nome = $nome;
  }

  /**
   * @return int
   */
  public function getIdCategoriaGasto(): int
  {
      return $this->id_categoria_gasto;
  }

  /**
   * @return string
   */
  public function getValor(): string
  {
      return $this->valor;
  }

  /**
   * @param string $valor
   */
  public function setValor(string $valor): void
  {
      $this->valor = $valor;
  }

  /**
   * @return int
   */
  public function getIdUsuario(): int
  {
      return $this->id_usuario;
  }

  /**
   * @return string
   */
  public function getDescricao(): string
  {
      return $this->descricao;
  }

  /**
   * @param string $descricao
   */
  public function setDescricao(string $descricao): void
  {
      $this->descricao = $descricao;
  }

  /**
   * @return \DateTime
   */
  public function getDataCriacao(): \DateTime
  {
      return $this->data_criacao;
  }

  /**
   * @param \DateTime $data_criacao
   */
  public function setDataCriacao(\DateTime $data_criacao): void
  {
      $this->data_criacao = $data_criacao;
  }

  /**
   * @return \DateTime
   */
  public function getDataUltimaAtualizacao(): \DateTime
  {
      return $this->data_ultima_atualizacao;
  }

  /**
   * @param \DateTime $data_ultima_atualizacao
   */
  public function setDataUltimaAtualizacao(\DateTime $data_ultima_atualizacao): void
  {
      $this->data_ultima_atualizacao = $data_ultima_atualizacao;
  }


  public static function getGastos($where = null, $order = null, $limit = 10, $fields = '*') {
    return (new Database('gasto'))->select($where, $order, $limit, $fields);
  }
}