function check_form()
{
    var bValid=true;
    //Проверка логина
      var iLog=$("#login");
      var login=iLog.val();
      var reLog = /^[a-zA-z0-9_]{1,10}$/;
      if(!reLog.test(login)) {
          iLog.css("border-color", "red");
          bValid=false;

      }
      else
          iLog.css("border-color","#ccc");
    //Проверка ФИО
    var iFIO=$("#fio");
    var fio=iFIO.val();
    var reFIO = /^[А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+ [А-ЯЁ][а-яё]+$/;
    if(!reFIO.test(fio)) {
        iFIO.css("border-color", "red");
        bValid=false;
    }
    else
        iFIO.css("border-color","#ccc");


    //Проверка e-mail
    var iMail=$("#mail");
    var mail=iMail.val();
    var reMail =/^[\-\._a-z0-9]+@(?:[a-z0-9][\-a-z0-9]+\.)+[a-z]{2,6}$/;

    if(mail!=""&&!reMail.test(mail)) {
        iMail.css("border-color", "red");
        bValid=false;
    }
    else
        iMail.css("border-color","#ccc");


    //Проверка пароля. У пароля и логина совпадают регулярные выражения
    var iPas=$("#pass");
    var pass=iPas.val();
    if(!reLog.test(pass)) {
        iPas.css("border-color", "red");
        bValid=false;
    }
    else
        iPas.css("border-color","#ccc");

    //Проверка подтверждения пароля
    var iConfPas=$("#pass_confirm");
    var cpass=iConfPas.val();
    if(cpass!=pass) {
        iConfPas.css("border-color", "red");
        bValid=false;
    }
    else
        iConfPas.css("border-color","#ccc");

    return bValid;


}
/*
$(function(){
 // alert("здесь");

});
    */