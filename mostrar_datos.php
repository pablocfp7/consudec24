<?php


class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "consudec24";
    private $conn;


    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function verDatos($tabla, $condicion = "") {
        $sql = "SELECT * FROM $tabla";
        if ($condicion) {
            $sql .= " WHERE $condicion";
        }

        $resultado = $this->conn->query($sql);

        if ($resultado->num_rows > 0) {
            $filas = [];
            while ($fila = $resultado->fetch_assoc()) {
                $filas[] = $fila;
            }
            return $filas;
        } else {
            return "No se encontraron resultados";
        }
    }


    public function __destruct() {
        $this->conn->close();
    }
}


$db = new Database();


$datos = $db->verDatos("usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Datos</title>
</head>
<body>
    <h1>Datos de Usuarios</h1>
    <?php
    
    if (is_array($datos)) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Edad</th></tr>";
        foreach ($datos as $fila) {
            echo "<tr>";
            echo "<td>" . $fila["id"] . "</td>";
            echo "<td>" . $fila["nombre"] . "</td>";
            echo "<td>" . $fila["edad"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo $datos; 
    }
    ?>
</body>
</html>
