$(document).ready(function() {
    $("#registration-form").submit(function(e) {
        e.preventDefault();
        var name = $("#name").val();
        var surname = $("#surname").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var confirmpassword = $("#confirmpassword").val();
        
        // Валідації на клієнті
        if (email.indexOf("@") === -1) {
            $("#error-message").text("Email повинен містити символ '@'.");
            return;
        }
        if (password !== confirmpassword) {
            $("#error-message").text("Паролі не співпадають.");
            return;
        }
        
        // Відправленя даних через AJAX
        $.ajax({
            url: "process.php",
            type: "POST",
            data: {
                name: name,
                surname: surname,
                email: email,
                password: password,
                confirmpassword:confirmpassword
            },
            success: function(response) {
                if (response === "success") {
                    // При успішній перевірці - форма повинна ховатись, а користувачу повинно відобразитись сповіщення про успішну реєстрацію
                    $("#registration-form").hide();
                    $("#error-message").hide();
                    $("#success-message").text("Ви успішно зареєстровані!");
                } else {
                    // При неуспішній перевірці - користувачу повинна відобразитись помилка над формою
                    $("#error-message").text(response);
                }
            }
        });
    });
});