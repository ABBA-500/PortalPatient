let username = document.querySelector('#username');
let password = document.querySelector('#password');
let submit = document.querySelector('#submit');


function User(username,password){
    this.username=username;
    this.password=password;
}


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

    let check = false;
    let passcheck = '';
    let UserId="";
    //localStorage.removeItem('ActiveUserId');
    for (let i=0; i<localStorage.length;i++){
        if(username.value==JSON.parse(localStorage.getItem('User'+i)).username){
            check=true;
            passcheck = JSON.parse(localStorage.getItem('User'+i)).password;
            UserId='User'+i;
        }
    }

    if (password.value!=passcheck || check==false){
        alert('Неверное имя пользователя или пароль');
        return;
    }

    const nameUser = username.value;
    const passwordUser = password.value;

    if (nameUser == "" || passwordUser == "")
    {
        alert('Заполните все поля!')
        return;
    }

    else{
        alert('Успех');
        localStorage.setItem('ActiveUserId', UserId);
        window.open("Profile.html")
        username.value="";
        password.value="";
    }
    
})