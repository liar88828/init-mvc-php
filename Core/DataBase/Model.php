<?php

abstract class Model
{
  protected static string $table;
  protected array $original = [];
  protected array $attributes = [];
  protected array $errors = [];
  public Database $db;

//  protected $db = Database::getInstance();

  public function __construct(array $attributes = [])
  {
    $this->fill($attributes);
    $this->original = $this->attributes;
    $this->db = Database::getInstance();

  }

  public function __get(string $name)
  {
    return $this->attributes[$name] ?? null;
  }

  public function __set(string $name, $value)
  {
    $this->attributes[$name] = $value;
  }

  public function fill(array $attributes): void
  {
    foreach ($attributes as $key => $value) {
      $this->attributes[$key] = $value;
    }
  }

  public static function getTableName(): string
  {
    if (isset(static::$table)) {
      return static::$table;
    }
    return strtolower((new ReflectionClass(static::class))->getShortName());
  }

  public static function query(): QueryBuilder
  {
    return new QueryBuilder(static::class);
  }

  public static function all(): array
  {
    return static::query()->get();
  }

  public static function find(int $id): ?static
  {
    return static::query()->where('id', $id)->first();
  }

  public static function findOrFail(int $id): static
  {
    $model = static::find($id);
    if (!$model) {
      throw new RuntimeException("Model not found");
    }
    return $model;
  }

  public static function create(array $attributes): static
  {
    $model = new static($attributes);
    $model->save();
    return $model;
  }



  public function save(): bool
  {
    if (!$this->validate()) {
      return false;
    }


    $attributes = $this->getAttributes();

    if (empty($this->attributes['id'])) {
      // Insert
      $columns = implode(', ', array_keys($attributes));
      $values = implode(', ', array_fill(0, count($attributes), '?'));
      $sql = "INSERT INTO " . static::getTableName() . " ($columns) VALUES ($values)";
      $stmt = $this->db->prepare($sql);
      $stmt->execute(array_values($attributes));

      $this->attributes['id'] = $this->db->lastInsertId();
    } else {
      // Update
      $id = $this->attributes['id'];
      unset($attributes['id']);
      $set = implode(', ', array_map(fn($col) => "$col = ?", array_keys($attributes)));
      $sql = "UPDATE " . static::getTableName() . " SET $set WHERE id = ?";
      $stmt = $this->db->prepare($sql);
      $stmt->execute([...array_values($attributes), $id]);
    }

    $this->original = $this->attributes;
    return true;
  }

  public function delete(): bool
  {
//    $this->attributes['id'] = $this->attributes['id'] ?: $id;
    if (empty($this->attributes['id'])) {
      return false;
    }
    $db = Database::getInstance();
    $sql = "DELETE FROM " . static::getTableName() . " WHERE id = ?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$this->attributes['id']]);
  }

  public function validate(): bool
  {
    $this->errors = [];
    $reflection = new ReflectionClass($this);
    $properties = $reflection->getProperties();

    foreach ($properties as $property) {
      $validations = $property->getAttributes(Validation::class);
      foreach ($validations as $validation) {
        $rules = $validation->newInstance()->rules;
        $value = $this->attributes[$property->getName()] ?? null;
        foreach ($rules as $rule) {
          if (!$this->validateRule($rule, $value, $property->getName())) {
            break;
          }
        }
      }
    }

    return empty($this->errors);
  }

  protected function validateRule(string $rule, $value, string $field): bool
  {
    if ($rule === 'required' && empty($value)) {
      $this->errors[$field][] = "$field is required";
      return false;
    }

    if (str_starts_with($rule, 'min:')) {
      $min = (int)substr($rule, 4);
      if (strlen($value) < $min) {
        $this->errors[$field][] = "$field must be at least $min characters";
        return false;
      }
    }

    if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $this->errors[$field][] = "$field must be a valid email";
      return false;
    }

    return true;
  }

  public function getErrors(): array
  {
    return $this->errors;
  }

  public function getValues(): array
  {
    return $this->original;
  }


  protected function getAttributes(): array
  {
    $attributes = [];
    $reflection = new ReflectionClass($this);
    $properties = $reflection->getProperties();

    foreach ($properties as $property) {
      $column = $property->getAttributes(Column::class);
      if (!empty($column)) {
        $name = $property->getName();
        $attributes[$name] = $this->attributes[$name] ?? null;
      }
    }

    return $attributes;
  }
}
