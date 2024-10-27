<?php

class Users extends Model
{
  #[Column(type: 'integer')]
//  #[Validation(['required'])]
  public int $id;

  #[Column(type: 'string', length: 255)]
  #[Validation(['required', 'min:2'])]
  public string $name;

  #[Column(type: 'string', length: 255)]
  #[Validation(['required', 'email'])]
  public string $email;

  #[Column(type: 'string', length: 255)]
  #[Validation(['required', 'min:2'])]
  public string $message;

  #[Column(type: 'string', length: 255)]
  #[Validation(['required', 'min:6'])]
  public string $password;

  #[Column(type: 'datetime', nullable: true)]
  public ?string $email_verified_at;

  public static function findByEmail(string $email): ?self
  {
    return static::query()->where('email', $email)->first();
  }

  public function userAll()
  {
    return Users::find($this->id);
  }

  protected static function boot(): void
  {
    static::creating(function ($user) {
      if (isset($user->password)) {
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
      }
    });
  }

  private static function creating(Closure $param)
  {
  }

  public function getUsers()
  {
    $this->db->query("SELECT * FROM users");
    return $this->db->resultSet();
  }




//  public function create($data) {
//    $this->db->query("INSERT INTO admin_cred (admin_name, admin_pass) VALUES (:name, :email)");
//    $this->db->bind(':name', $data['name']);
//    $this->db->bind(':email', $data['email']);
//    return $this->db->execute();
//  }

//  public function getUsers() {
//    $this->db->query("SELECT * FROM users");
//    return $this->db->resultSet();
//  }
//
//  public function store($data) {
//    $this->db->query("INSERT
//                        INTO users (name, email, password, email_verified_at, message)
//                        VALUES (:name, :email, :password, :email_verified_at, : message)");
//    $this->db->bind(':name', $data['name']);
//    $this->db->bind(':email', $data['email']);
//    return $this->db->execute();
//  }


}