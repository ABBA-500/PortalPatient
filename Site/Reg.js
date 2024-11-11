let username = document.querySelector('#username');
let email = document.querySelector('#email');
let password = document.querySelector('#password');
let password2 = document.querySelector('#password2');
let submit = document.querySelector('#submit');
let change = document.querySelector('#change');

//localStorage.clear();


function User(username,email,password){
    this.username=username;
    this.email=email;
    this.password=password;
}

function checkPassword(password) {
    var password = password.value; 
    var s_letters = "qwertyuiopasdfghjklzxcvbnm"; 
    var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; 
    var digits = "0123456789";
    var specials = "!@#$%^&*()_-+=\|/.,:;[]{}";
    var is_s = false; 
    var is_b = false; 
    var is_d = false; 
    var is_sp = false; 
    for (var i = 0; i < password.length; i++) {
      if (!is_s && s_letters.indexOf(password[i]) != -1) is_s = true;
      else if (!is_b && b_letters.indexOf(password[i]) != -1) is_b = true;
      else if (!is_d && digits.indexOf(password[i]) != -1) is_d = true;
      else if (!is_sp && specials.indexOf(password[i]) != -1) is_sp = true;
    }
    var rating = 0;
    var text = "";
    if (is_s) rating++; 
    if (is_b) rating++; 
    if (is_d) rating++; 
    if (is_sp) rating++; 
    
    if(password.length<4||password.length>16) text="Длина пароля должна быть от 4 до 16 символов!";
    else if ((password.length < 6 && rating < 3)||(password.length >= 6 && rating == 1)) text = "Пароль простой";
    else if ((password.length < 6 && rating >= 3)||(password.length >= 8 && rating < 3)||(password.length >= 6 && rating > 1 && rating < 4)) text = "Пароль средний";
    else if ((password.length >= 8 && rating >= 3)||(password.length >= 6 && rating == 4)) text = "Пароль сложный";
    document.querySelector('.checkPass').innerHTML= text;
    return false; 
  }
password.addEventListener('contextmenu',()=>{
    for (let j=0;j<localStorage.length;j++)
    console.log(JSON.parse(localStorage.getItem('User'+j)));
})
password.addEventListener('keyup',()=>{
    checkPassword(password);
})

change.addEventListener('click',()=>{
    window.open('Login.html');
})

submit.addEventListener('click',()=>{
    while (username.value.includes('<')){
        var newsername ="";
        newsername += username.value.slice(0, username.value.indexOf('<'));
        newsername += '^';
        newsername += username.value.slice(username.value.indexOf('<')+1,);
        username.value = newsername;
    }
    while (username.value.includes('>')){
        var newsername ="";
        newsername += username.value.slice(0, username.value.indexOf('>'));
        newsername += '^';
        newsername += username.value.slice(username.value.indexOf('>')+1,);
        username.value = newsername;
    }
    
    for (let i=0; i<localStorage.length;i++){
        if(username.value==JSON.parse(localStorage.getItem('User'+i)).username){
            alert('Это имя пользователя уже занято');
            return;
        }
        if(email.value==JSON.parse(localStorage.getItem('User'+i)).email){
            alert('Этот email уже занят');
            return;
        }
    }
    if (password.value != password2.value){
        alert('Пароли не совпадают');
        return;
    }
    const nameUser = username.value;
    const emailUser = email.value;
    const passwordUser = password.value;

    if (nameUser == "" || emailUser == "" || passwordUser == "")
    {
        alert('Заполните все поля!')
        return;
    }

    else if (passwordUser.length < 4 || passwordUser.length > 16){
        alert('Длина пароля должна быть от 4 до 16 символов!');
        return;
    }

    else{
        const user = new User(nameUser, emailUser, passwordUser);

        const UserId = 'User'+(localStorage.length);

        localStorage.setItem(UserId, JSON.stringify(user));

        alert('регистрация успешна');
        username.value=null;
        email.value=null;
        password.value=null;
        password2.value=null;
    }
    
})