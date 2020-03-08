<?php

class ConnDb
{
    public $pdo;

    public function __construct()
    {
        $settings = $this->getPDOSettings();
        $this->pdo = new PDO($settings['dsn'], $settings['user'], $settings['pass'], null);
    }

    protected function getPDOSettings()
    {
        $config = include 'config.php';
        $result['dsn'] = "{$config['type']}:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $result['user'] = $config['user'];
        $result['pass'] = $config['pass'];
        return $result;
    }

    public function execute($query, array $params = null)
    {
        try {
            if (is_null($params)) {
                $stmt = $this->pdo->query($query);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Ошибка выполнения запроса: ". $e->getMessage();
        }
    }
}
