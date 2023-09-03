$(document).ready(function() {
    var mensagemInput = document.getElementById("message");
    var botaoEnviar = document.getElementById("send");
    var nickname = document.getElementById("nickname");
    mensagemInput.style.display='none';
    nickname.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) { // Verifica se a tecla pressionada é a tecla "Enter" (código 13)
            botaoEnviar.click(); // Clique no botão "send"
        }
    });

    var nome_user;
    callAtualizarChat();
    //variaveis globais acima

    // Sua inicialização de código aqui, se necessário

    $(document).on("click", "#send", function() {
        var nickname=document.getElementById("nickname");

        const estilo = window.getComputedStyle(nickname);
        const display = estilo.getPropertyValue('display');

        if (display !== 'none') {
            // O elemento está visível, logo o nickname não está setado.
            if (nickname.value==""){
                return;
            }
            if (nickname.value!=""){
                nome_user=nickname.value;

                var titulo=document.getElementById("div_name");
                var conteudoAtual = titulo.innerHTML;
                var novoConteudo = conteudoAtual + nome_user;
                titulo.innerHTML = novoConteudo;

                Adicionar_usuario(nome_user);
                nickname.style.display = 'none';
                mensagemInput.style.display = 'block';
                mensagemInput.addEventListener("keyup", function(event) {
                    if (event.keyCode === 13) { // Verifica se a tecla pressionada é a tecla "Enter" (código 13)
                        botaoEnviar.click(); // Clique no botão "send"
                    }
                });
                nickname.removeEventListener("keyup", function(event){
                    if (event.keyCode === 13) { // Verifica se a tecla pressionada é a tecla "Enter" (código 13)
                        botaoEnviar.click(); // Clique no botão "send"
                    }
                });
                

                var send = document.getElementById("send");
                send.click();
            }
        } else {
            // O elemento está oculto, logo o nickname já está setado.
            console.log(nickname.value+" Já está registrado!");
            Enviar_mensagem();
        }
        

    });

    function Get_user_id() {
        if (!nome_user) {
            console.log("Nome de usuário não definido ou vazio.");
            return;
        }
    
        $.ajax({
            type: 'POST',
            url: 'chat_page.api.php',
            data: {
                get_user_id: 'S',
                nome: nome_user
            },
            dataType: 'json',
            success: function(data) {
                if (data && data.id) { // Mudança de 'data.user_id' para 'data.id'
                    id_user = data.id;
                    console.log("UserId Buscado. -"+id_user);
                    callAtualizarChat();
                } else {
                    console.log("Erro: Resposta do servidor inválida ou incompleta.");
                }
            },
            error: function(xhr, status, error) {
                console.log("Erro na solicitação AJAX: " + status + " - " + error);
            }
        });
        
    }

    function Adicionar_usuario(nome_user){
        $.ajax({
            type: 'POST',
            url: 'chat_page.api.php',
            data: {
              adicionar_usuario:'S',
              nome:nome_user
            },
            dataType: 'html',
            success: function(data) {
                console.log("Usuário Adicionado ou logado.")
                id_user=Get_user_id();
                callAtualizarChat();
            },
            error: function(e) {
                console.log("Mensagem não enviada.")
            }
          });
    }

    function callAtualizarChat(){
        //id="chat-query"
        console.log("Atualizando Chat...");
        $.ajax({
            type: 'POST',
            url: 'chat_page.api.php',
            data: {
              query_chat: 'S'
            },
            dataType: 'html',
            success: function(data) {
              $("#chat-query").empty().html(data);
                var customDiv = document.querySelector('.custom-div');
                customDiv.scrollTop = customDiv.scrollHeight;
            },
            error: function(e) {
              console.log('Erro na requisição AJAX:', e);
            }
          });
          
    }

    function Enviar_mensagem(){
        var mensagem_element=document.getElementById("message")
        var mensagem = document.getElementById("message").value;
        $.ajax({
            type: 'POST',
            url: 'chat_page.api.php',
            data: {
              enviar_mensagem:'S',
              mensagem:mensagem,
              id_user:id_user
            },
            dataType: 'html',
            success: function(data) {
                mensagem_element.value='';
                console.log("Mensagem Enviada.")
                callAtualizarChat();
            },
            error: function(e) {
                console.log("Mensagem não enviada.")
            }
          });
    }

});