<?php

#[Attribute(Attribute::TARGET_PROPERTY)]
class Validation {
  public function __construct(
    public array $rules = []
  ) {}
}