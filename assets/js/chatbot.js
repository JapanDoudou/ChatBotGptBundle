document.addEventListener("DOMContentLoaded", function () {
    const chatBox = document.getElementById("chat-box");
    const userInput = document.getElementById("user-input");
    const sendButton = document.getElementById("send-button");

    sendButton.addEventListener("click", function () {
        const userMessage = userInput.value;
        if (userMessage.trim() === "") return;
        console.log(userMessage);
        const userBubble = document.createElement("div");
        userBubble.className = "message sent";
        userBubble.textContent = userMessage;
        chatBox.appendChild(userBubble);
        $.ajax({
            url: "{{ path('chatbot')}}",
            method: 'POST',
            dataType: 'json',
            contentType: 'application/text',
            data: JSON.stringify({ message: userMessage }),
            //On affiche un spinner en attendant la réponse du bot
            beforeSend: function () {
                const botBubble = document.createElement("div");
                botBubble.className = "message received spinner";
                botBubble.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>';
                chatBox.appendChild(botBubble);
            },
            success: function (response) {
                chatBox.removeChild(chatBox.lastChild);
                const botBubble = document.createElement("div");
                botBubble.className = "message received";
                botBubble.textContent = response.message;
                chatBox.appendChild(botBubble);
                chatBox.scrollTop = chatBox.scrollHeight;
            },
            error: function (error) {
                console.log(error);
                chatBox.removeChild(chatBox.lastChild);
                const botBubble = document.createElement("div");
                botBubble.className = "message received error";
                botBubble.textContent = "{{ 'chatbot.error'|trans }}";
                chatBox.appendChild(botBubble);
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
        userInput.value = "";
    });
});