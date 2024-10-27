<?php


#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{
  public function __construct(
    public ?string $type = null,
    public bool    $nullable = false,
    public ?int    $length = null,
    public ?string $default = null
  )
  {
  }
}
