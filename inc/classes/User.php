<?php

if (!defined('__CONFIG__')) {
    exit('Access Denied');
}

class User
{
    private $conn;
    public $id;
    public $login;
    public $created_at;

    public $columns = '*';

    public function __construct()
    {
        $this->conn = DB::getConnection();
    }

    public function select()
    {
        $columns_count = func_num_args();
        if ($columns_count > 0) {
            $columns = func_get_args();
            if (!empty($columns)) $this->columns = implode(',', $columns);
        }
        return $this;
    }

    public function find($user_id, $columns = ['*'])
    {
        if (!$user_id) return false;

        $select = implode(',', $columns);
        $query = sprintf("SELECT %s FROM users WHERE id=:id LIMIT 1" . $select);

        $user = $this->conn->prepare($query);
        $int = Filter::Int($user_id);
        $user->bindParam(':id', $int, PDO::PARAM_INT);
        $user->execute();

        return $user->fetchObject();
    }

    public function all()
    {
        $query = sprintf("SELECT %s FROM users", $this->columns);
        $users = $this->conn->prepare($query);
        $users->execute();

        return $users->fetchAll(PDO::FETCH_OBJ);
    }

    public function create($login, $password)
    {
        $this->conn = DB::getConnection();

        $user = $this->conn->prepare("INSERT INTO users(id,login,password) VALUES (null,:login,:password)");
        $new_user = $user->execute([
            ':login' => $login,
            ':password' => md5($password)
        ]);

        if ($new_user) {
            return $this->find($this->conn->lastInsertId(), ['id', 'login', 'created_at', 'updated_at']);
        } else {
            return false;
        }
    }

    public function update($user_id, $data = [])
    {
        if (!$user_id) return false;
        if (!isset($data['login'])) return false;
        if (!isset($data['password'])) return false;

        $user_id = Filter::Int($user_id);

        if (!empty($data)) {
            $query = sprintf("UPDATE users SET password=:password,login=:login,updated_at:=:updated_at WHERE id=:id");

            $user = $this->conn->prepare($query);
            $user->bindParam(':id', $user_id, PDO::PARAM_INT);
            $user->bindParam(':login', Filter::String($data['login']), PDO::PARAM_STR);
            $user->bindParam(':password', Filter::String($data['password']), PDO::PARAM_STR);
            $user->bindParam('updated_at', date("Y-m-d H:i:s"), PDO::PARAM_STR);
            $update_user = $user->execute();

            if ($update_user) {
                return $this->find($user_id, ['id', 'login', 'created_at', 'updated_at']);
            } else {
                return false;
            }
        }
    }

    public function delete($user_id)
    {

    }
}