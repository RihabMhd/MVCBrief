<?php
namespace App\Repository;

use PDO;
use App\Repository\BaseRepository;

class UserRepository extends BaseRepository
{

    public function getTableName(): string
    {
        return 'users';
    }

    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }


    public function findByUsername(string $username): ?array
    {
        $sql = "SELECT * FROM users WHERE name = :name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['name' => $username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }


    public function create(array $userData): int
    {
        $sql = "INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'], 
            'role_id' => $userData['role_id']
        ]);
        return $this->db->lastInsertId();
    }


    public function update(int $id, array $data): bool
    {

        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }


        $data['updated_at'] = date('Y-m-d H:i:s');


        return parent::update($id, $data);
    }


    public function findByRole($role): array
    {

        if (is_numeric($role)) {
            $sql = "SELECT u.* FROM users u WHERE u.role_id = :role_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['role_id' => $role]);
        } else {
            $sql = "SELECT u.* FROM users u 
                    INNER JOIN roles r ON u.role_id = r.id 
                    WHERE r.name = :role_name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['role_name' => $role]);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findByIdWithRole(int $id): ?array
    {
        $sql = "SELECT u.*, r.name as role_name, r.description as role_description 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}
