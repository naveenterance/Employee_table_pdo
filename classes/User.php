<?php

/**
 * User
 *
 */
class User
{

    /**
     * id
     *
     * @var mixed
     */
    public $id;

    /**
     * username
     *
     * @var mixed
     */
    public $username;

    /**
     * password
     *
     * @var mixed
     */
    public $password;

    /**
     * name
     *
     * @var mixed
     */
    public $name;

    /**
     * age
     *
     * @var mixed
     */
    public $age;

    /**
     * role
     *
     * @var mixed
     */
    public $role;

    /**
     * errors
     *
     * @var array
     */
    public $errors = [];

    /**
     * getAll
     *
     * @param  mixed $conn
     * @return void
     */
    public static function getAll($conn)
    {
        $sql = "SELECT *
                FROM users;";

        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * getByID
     *
     * @param  mixed $conn
     * @param  mixed $id
     * @param  mixed $columns
     * @return void
     */
    public static function getByID($conn, $id, $columns = '*')
    {
        $sql = "SELECT $columns
                FROM users
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

        if ($stmt->execute()) {

            return $stmt->fetch();

        }
    }

    /**
     * getPage
     *
     * @param  mixed $conn
     * @param  mixed $limit
     * @param  mixed $offset
     * @return void
     */
    public static function getPage($conn, $limit, $offset)
    {
        $sql = "SELECT *
                FROM users
                ORDER BY id
                LIMIT :limit
                OFFSET :offset";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * getTotal
     *
     * @param  mixed $conn
     * @return void
     */
    public static function getTotal($conn)
    {
        return $conn->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    /**
     * update
     *
     * @param  mixed $conn
     * @return void
     */
    public function update($conn)
    {
        if ($this->validate()) {

            $sql = "UPDATE users
                    SET username = :username,
                        password = :password,
                        name = :name,
                        role = :role,
                        age = :age
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':role', $this->role, PDO::PARAM_STR);
            $stmt->bindValue(':age', $this->age, PDO::PARAM_STR);

            return $stmt->execute();

        } else {
            return false;
        }
    }

    /**
     * validate
     *
     * @return void
     */
    protected function validate()
    {

        if ($this->username == '') {
            $this->errors[] = 'username is required';
        }
        if ($this->password == '') {
            $this->errors[] = 'password is required';
        }
        if ($this->name == '') {
            $this->errors[] = 'name is required';
        }
        if ($this->role == '') {
            $this->errors[] = 'role is required';
        }
        if ($this->age == '') {
            $this->errors[] = 'age is required';
        }

        return empty($this->errors);
    }

    /**
     * delete
     *
     * @param  mixed $conn
     * @return void
     */
    public function delete($conn)
    {
        $sql = "DELETE FROM users
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * create
     *
     * @param  mixed $conn
     * @return void
     */
    public function create($conn)
    {
        if ($this->validate()) {

            if (($conn->query("SELECT COUNT(*) FROM users WHERE username='$this->username'")->fetchColumn()) >= 1) {
                echo ">Username already exists";
            } elseif (($conn->query("SELECT COUNT(*) FROM users WHERE name='$this->name'")->fetchColumn()) >= 1) {
                echo ">Name already exists";
            } else {

                $sql = "INSERT INTO users (id, username, password, name, role, age)
                    VALUES (:id, :username, :password, :name, :role, :age)";

                $stmt = $conn->prepare($sql);

                $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
                $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
                $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
                $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindValue(':role', $this->role, PDO::PARAM_STR);
                $stmt->bindValue(':age', $this->age, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $this->id = $conn->lastInsertId();
                    return true;
                }

            }} else {
            return false;
        }
    }
}
