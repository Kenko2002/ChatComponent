
<?php
include('configdb.php');

#QUERYCHAT

if(isset($_POST["query_chat"])){
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = 'SELECT mens.id, mens.id_escritor, mens.texto, esc.id, esc.nickname
        FROM "public"."mensagem" mens
        INNER JOIN "public"."escritor" esc ON esc.id = mens.id_escritor
        ORDER BY mens.id'; // Ordenar por ID de forma descendente

        $results = $pdo->query($query);
    ?>
    <div class="container">
        <div class="row">
            <div style="width: 100%;">
                <?php foreach ($results as $row) { ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row["nickname"] ?></h5>
                            <p class="card-text"><?= $row["texto"] ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    } catch (PDOException $e) {
        // Lide com erros, se necessário
        die("Error: " . $e->getMessage());
    }
}



#adicionar_usuario
if(isset($_POST["adicionar_usuario"])){
    $nome=$_POST["nome"];
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "INSERT INTO escritor (nickname, num_messages)
        VALUES
        ('".$nome."', 0)";
        $pdo->query($query);
    
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }


}

#enviar_mensagem
if(isset($_POST["enviar_mensagem"])){
    $id_user = $_POST["id_user"];
    $mensagem = $_POST["mensagem"];
    
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Use prepared statements para evitar SQL injection
        $query = "INSERT INTO mensagem (id_escritor, texto) VALUES (:id_user, :mensagem)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
        $stmt->execute();
        
        // Você não precisa retornar nenhuma resposta em JSON neste caso
    } catch (PDOException $e) {
        // Lide com erros, se necessário
        die("Error: " . $e->getMessage());
    }
}

if (isset($_POST["get_user_id"])) {
    $nome = $_POST["nome"];

    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Execute a consulta SQL para buscar o id com base no nickname
        $query = "SELECT id FROM escritor WHERE nickname=:nome";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->execute();

        // Obtém o resultado da consulta como um array associativo
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se encontrou um resultado
        if ($resultado) {
            // Define o cabeçalho Content-Type para application/json
            header('Content-Type: application/json');

            // Retorna o resultado como JSON
            echo json_encode($resultado);
        } else {
            // Se não encontrar um resultado, você pode retornar uma resposta de erro
            header('HTTP/1.1 404 Not Found');
            echo json_encode(array("mensagem" => "Usuário não encontrado"));
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(array("erro" => $e->getMessage()));
    }
}


?>