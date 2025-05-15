<?php
// Hibakezelés bekapcsolása fejlesztési környezetben
if (getenv('ENVIRONMENT') === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        $this->connect();
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    private function connect() {
        // Konfiguráció betöltése
        $config = [
            'servername' => 'mysql.omega',
            'username' => 'regisztracio',
            'password' => 'regisztracio',
            'dbname' => 'regisztracio',
            'port' => 3306,
            'charset' => 'utf8mb4'
        ];
        
        try {
            $this->connection = new mysqli(
                $config['servername'],
                $config['username'],
                $config['password'],
                $config['dbname'],
                $config['port']
            );
            
            if ($this->connection->connect_error) {
                throw new Exception("Kapcsolódási hiba: " . $this->connection->connect_error);
            }
            
            // Karakterkódolás beállítása
            $this->connection->set_charset($config['charset']);
            
        } catch (Exception $e) {
            // Hibanaplózás
            error_log("Adatbázis hiba: " . $e->getMessage());
            
            // Felhasználóbarát hibaüzenet
            die("Az oldal karbantartás alatt áll. Kérjük, próbálkozz később!");
        }
    }
    
    public function getConnection() {
        // Ellenőrizzük, hogy él-e még a kapcsolat
        if (!$this->connection || !$this->connection->ping()) {
            $this->connect();
        }
        return $this->connection;
    }
    
    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

// Használat:
$db = Database::getInstance();
$conn = $db->getConnection();
?>