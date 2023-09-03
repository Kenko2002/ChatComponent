<head>
    <?php include('configdb.php'); ?>
    <title>Exemplo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="chat_page.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body style="background-color: #192A56; ">
    <div class="container mt-5">
        <div class="row justify-content-center">

            <!--div cadastro pessoa-->
            <div class="col-md-6">
                <div class="card p-4 shadow" id="Box2">
                    <!-- Formulário para cadastrar uma nova pessoa -->
                    <h4 id="div_name"> Chat </h4>
                    <div>

                    <style>
                        /* Estilo personalizado para a div */
                        .custom-div {
                            width: 100%;
                            height: 70vh; /* 40% da altura da tela */
                            overflow-y: scroll; /* Adicionar barra de rolagem vertical quando necessário */
                            border: 1px solid #ccc;
                            padding: 10px;
                        }
                    </style>
                </head>
                <body>

                                <div class="custom-div" id="chat-query">
                                    <!-- Conteúdo da sua div aqui -->
                                    
                                    <!-- Adicione mais conteúdo conforme necessário -->
                                </div>


                    </div>
                        <!-- Campos do formulário -->
                        <input type="text" id="nickname" class="form-control mb-3" placeholder="Seu Nickname">
                        <div class="input-group">
                            <input type="text" id="message" class="form-control" placeholder="Digite sua Mensagem...">
                            <div class="input-group-append">
                                <button id="send" class="btn btn-success" style="height: 38px;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3106/3106794.png" style="height: 20px;">
                                </button>
                            </div>
                        </div>
                        <!-- Outros campos do formulário -->

                       
                </div>
            </div>
        </div>
    </div>
</body>



