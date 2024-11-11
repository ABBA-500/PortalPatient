let ActiveUser = localStorage.getItem('ActiveUserId');
//document.querySelector('.results').innerHTML = 'Hello World!';
document.querySelector('.Username').innerHTML = JSON.parse(localStorage.getItem(ActiveUser)).username;
document.querySelector('.Email').innerHTML = JSON.parse(localStorage.getItem(ActiveUser)).email;
document.querySelector('.Pass').innerHTML = JSON.parse(localStorage.getItem(ActiveUser)).password;
localStorage.removeItem("ActiveUserId");