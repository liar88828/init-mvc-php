<?php


class QueryBuilder
{
  protected string $modelClass;
  protected array $wheres = [];
  protected array $orders = [];
  protected ?int $limit = null;
  protected int $offset = 0;

  public function __construct(string $modelClass)
  {
    $this->modelClass = $modelClass;
  }

  public function where(string $column, $value): self
  {
    $this->wheres[] = [$column, '=', $value];
    return $this;
  }

  public function orderBy(string $column, $direction = 'ASC' | 'DESC'): self
  {
    $this->orders[] = [$column, strtoupper($direction)];
    return $this;
  }

  public function limit(int $limit): self
  {
    $this->limit = $limit;
    return $this;
  }

  public function offset(int $offset): self
  {
    $this->offset = $offset;
    return $this;
  }

  public function get(): array
  {
    $db = Database::getInstance();

    $query = "SELECT * FROM " . $this->modelClass::getTableName();
    $params = [];

    if (!empty($this->wheres)) {
      $conditions = array_map(function ($where) use (&$params) {
        $params[] = $where[2];
        return "{$where[0]} {$where[1]} ?";
      }, $this->wheres);
      $query .= " WHERE " . implode(' AND ', $conditions);
    }

    if (!empty($this->orders)) {
      $orders = array_map(fn($order) => "{$order[0]} {$order[1]}", $this->orders);
      $query .= " ORDER BY " . implode(', ', $orders);
    }

    if ($this->limit !== null) {
      $query .= " LIMIT {$this->limit}";
    }

    if ($this->offset > 0) {
      $query .= " OFFSET {$this->offset}";
    }

    $stmt = $db->prepare($query);
//    print_r($stmt);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_CLASS, $this->modelClass);
  }

  public function first(): ?object
  {
    $this->limit(1);
    $results = $this->get();
    return $results[0] ?? null;
  }
}
