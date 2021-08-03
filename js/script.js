jQuery(function($) {
    
    let email_flag = 0; // флаги для проверки правильности введенных данных
    let password_flag = 0; //
    let name_flag = 0; //
    let password_second_flag = 0; //
    let email_mask = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/; // маска для email

    $(".btn-auth").click(function(event){ // авторизация
        event.preventDefault();
        if (email_flag == 1 && password_flag == 1){ // проверка что поля почта и пароль заполнены правильно
            $.ajax({
                url: "handlers/auth_handler.php",
                type: "POST",
                dataType: "html",
                data: $(".auth_form").serialize(),
                success: function(response) {
                	$('.alerts').html(response);
                	if (response.includes("alert-success")){
                	    setTimeout (function () {
                        window.location.href = "account.php";
                        }, 2000);
                        email_flag = 0; //сброс флагов
                        password_flag = 0;
                	}
            	},
            	error: function() {
                    $('.alerts').html("<br><div class='alert alert-danger' role='alert'>Ошибка. Данные не отправлены.</div>");
            	}
         	});
        } else {
            $('.alerts').html("<br><div class='alert alert-danger' role='alert'>Проверьте правильность введенных данных.</div>");
        }
        
     	$('.captcha-placeholder').html("").load("handlers/captcha.php"); // обновление капчи при нажатии кнопки авторизация
    });
    
    $('.captcha-placeholder').load("handlers/captcha.php"); // загрузка капчи при загрузке страницы
    
    $(".btn-reg").click(function(event){ // регистрация
        event.preventDefault();
        if (email_flag == 1 && password_second_flag == 1 && name_flag == 1){
            $.ajax({
                url: "handlers/reg_handler.php",
                type: "POST",
                dataType: "html",
                data: $(".reg_form").serialize(),
                success: function(response) {
                	$('.alerts').html(response);
                	if (response.includes("alert-success")){
                	    setTimeout (function () {
                        window.location.href = "account.php";
                        }, 2000);
                        email_flag = 0; //сброс флагов
                        password_flag = 0;
                        password_second_flag = 0;
                        name_flag = 0;
                	}
            	},
            	error: function() {
                    $('.alerts').html("<br><div class='alert alert-danger' role='alert'>Ошибка. Данные не отправлены.</div>");
            	}
         	});
        } else {
            $('.alerts').html("<br><div class='alert alert-danger' role='alert'>Проверьте правильность введенных данных.</div>");
        }
        
    });
    
    
    $('.name').change(function() { // проверка минимальной длины (3 символа)
        if( $(this).val().length >= 3 ){
            $(this).css("border","1px solid green");
            $('#nameErrors').html("");
            name_flag = 1;
        } else {
            $(this).css("border","1px solid red");
            $('#nameErrors').html("Минимальная длина имени 3 символа").css("color","red");
        }
    });
    
    
    $('.email').change(function() { // проверка соответствию маске почты
        if( $(this).val() !== '' && email_mask.test($(this).val()) ){
            $(this).css("border","1px solid green");
            $('#emailErrors').html("");
            email_flag = 1;
        } else {
            $(this).css("border","1px solid red");
            $('#emailErrors').html("Email введён не верно").css("color","red");
        }
    });
    
    
    $('.email_reg').change(function() { // ajax проверка доступности почты
        if( $(this).val() !== '' && email_mask.test($(this).val()) ){
            $.ajax({
                url: "handlers/email_check.php",
                type: "POST",
                dataType: "html",
                data: $(".email_reg").serialize(),
                success: function(response) {
                    $("#emailCheck").html(response);
                }
            });
        }
    });
    
    
    $('.password').change(function() { // проверка минимальной длины (6 символов)
        if( $(this).val().length >= 6 ){
            $(this).css("border","1px solid green");
            $('#passwordErrors').html("");
            password_flag = 1;
        } else {
            $(this).css("border","1px solid red");
            $('#passwordErrors').html("Минимальная длина пароля 6 символов").css("color","red");
        }
    });
    
    
    $('.password_second').change(function() { // проверка на совпадение с первым паролем
        if( $(this).val() == $('.password').val() ){
            $(this).css("border","1px solid green");
            $('#passwordSecondErrors').html("");
            password_second_flag = 1;
        } else {
            $(this).css("border","1px solid red");
            $('#passwordSecondErrors').html("Пароли не совпадают").css("color","red");
        }
    });
});
