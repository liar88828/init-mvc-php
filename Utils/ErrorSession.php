<?php

enum ErrorType: string
{
  case VALIDATION = 'validations';
  case VALUE = 'values';
  case MESSAGE = 'message';
}

class ErrorSession
{
  private static function getSession(): ?array
  {
    return $_SESSION['redirect_data']['errors'] ?? null;
  }

  private static function checkMessage(): ?array
  {
    return $_SESSION['redirect_data']['message'] ?? null;
  }


  public static function getError(): ?array
  {
    if (isset($_SESSION['redirect_data']['errors'])) {
      return $_SESSION['redirect_data']['errors'];
    }
    return null;
  }

  public static function getValidationError(string $field): ?string
  {
    $errors = self::getSession();
    if (isset($errors[ErrorType::VALIDATION->value][$field][0])) {
      return $errors[ErrorType::VALIDATION->value][$field][0];
    }
    return null;
  }

  public static function getValueError(string $field): mixed
  {
    $errors = self::getSession();
    if (isset($errors[ErrorType::VALUE->value][$field])) {
      return $errors[ErrorType::VALUE->value][$field];
    }
    return null;
  }

  public static function getMessage(): ?string
  {
    $errors = self::getSession();
    if (isset($errors[ErrorType::MESSAGE->value])) {
      return $errors[ErrorType::MESSAGE->value];
    }
    return null;
  }

  public static function whenError(Model $model)
  {
    throw new Exception(serialize([
      'validations' => $model->getErrors(),
      'values' => $model->getValues()
    ]));

  }

}

// Usage examples:
// $error = ErrorSession::getError();
// $validationError = ErrorSession::getValidationError('email');
// $valueError = ErrorSession::getValueError('username');