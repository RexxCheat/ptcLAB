"use strict";
function secure_password(input){
    var password = input.val();
    var capital = /[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/;
    var capital = capital.test(password);
    if (!capital){
        $('.capital').removeClass('success');
        $('.capital').addClass('error');
    }else{
        $('.capital').removeClass('error');
        $('.capital').addClass('success');
    }
    var lower = /[abcdefghijklmnopqrstuvwxyz]/;
    var lower = lower.test(password);
    if (!lower){
        $('.lower').removeClass('success');
        $('.lower').addClass('error');
    }else{
        $('.lower').removeClass('error');
        $('.lower').addClass('success');
    }
    var number = /[1234567890]/;
    var number = number.test(password);
    if (!number){
        $('.number').removeClass('success');
        $('.number').addClass('error');
    }else{
        $('.number').removeClass('error');
        $('.number').addClass('success');
    }
    var special = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    var special = special.test(password);
    if (!special){
        $('.special').removeClass('success');
        $('.special').addClass('error');
    }else{
        $('.special').removeClass('error');
        $('.special').addClass('success');
    }
    var minimum = password.length;
    if (minimum < 6){
        $('.minimum').removeClass('success');
        $('.minimum').addClass('error');
    }else{
        $('.minimum').removeClass('error');
        $('.minimum').addClass('success');
    }
}