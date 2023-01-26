function va_username() {
    let x = document.getElementById('username').value;
    if (x == "") {
        document.getElementById('e_username').innerHTML = "Enter User Name";
        document.getElementById('e_username').style.display = "block";
        return false;
    }
    const pattern = /^[A-Z a-z]+$/;
    if (!(pattern.test(x))) {
        document.getElementById('e_username').innerHTML = "Invalid Username";
        document.getElementById('e_username').style.display = "block";
        return false;
    }
    document.getElementById('e_username').innerHTML = "";
    document.getElementById('e_username').style.display = "none";
    return true;
}
function va_email() {
    let x = document.getElementById('email').value;
    if (x == "") {
        document.getElementById('e_email').innerHTML = "Enter Email Address";
        document.getElementById('e_email').style.display = "block";
        return false;
    }
    const pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!(pattern.test(x))) {
        document.getElementById('e_email').innerHTML = "Invalid Email Address";
        document.getElementById('e_email').style.display = "block";
        return false;
    }
    document.getElementById('e_email').innerHTML = "";
    document.getElementById('e_email').style.display = "none";
    return true;
}
function va_password() {
    let x = document.getElementById('password').value;
    if (x == "") {
        document.getElementById('e_password').innerHTML = "Enter Password";
        document.getElementById('e_password').style.display = "block";
        return false;
    }
    if (x.length < 8) {
        document.getElementById('e_password').innerHTML = "Password is Too Short";
        document.getElementById('e_password').style.display = "block";
        return false;
    }
    document.getElementById('e_password').innerHTML = "";
    document.getElementById('e_password').style.display = "none";
    return true;
}
function va_confirmPassword() {
    va_password();
    let x = document.getElementById('confirmPassword').value;
    let y = document.getElementById('password').value;
    if (x == "") {
        document.getElementById('e_confirmPassword').innerHTML = "Confirm Your Password";
        document.getElementById('e_confirmPassword').style.display = "block";
        return false;
    }
    if (!(x == y)) {
        document.getElementById('e_confirmPassword').innerHTML = "Passwords Does Not Match";
        document.getElementById('e_confirmPassword').style.display = "block";
        return false;
    }
    document.getElementById('e_confirmPassword').innerHTML = "";
    document.getElementById('e_confirmPassword').style.display = "none";
    return true;
}

function va_registration(){
    return va_username() && va_email() && va_confirmPassword();
}

function va_update(){
    return va_username() && va_email();
}

function va_admin_u(){
    let x = document.getElementById('username').value;
    const pattern = /^[A-Z a-z]+$/;
    if (!(pattern.test(x))) {
        document.getElementById('e_username').innerHTML = "Invalid Username";
        document.getElementById('e_username').style.display = "block";
        return false;
    }
    document.getElementById('e_username').innerHTML = "";
    document.getElementById('e_username').style.display = "none";
    return true;
}
function va_admin_p(){
    let x = document.getElementById('password').value;
    if (x.length < 8) {
        document.getElementById('e_password').innerHTML = "Password is Too Short";
        document.getElementById('e_password').style.display = "block";
        return false;
    }
    document.getElementById('e_password').innerHTML = "";
    document.getElementById('e_password').style.display = "none";
    return true;
}
function va_admin_e(){
    let x = document.getElementById('email').value;
    const pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!(pattern.test(x))) {
        document.getElementById('e_email').innerHTML = "Invalid Email Address";
        document.getElementById('e_email').style.display = "block";
        return false;
    }
    document.getElementById('e_email').innerHTML = "";
    document.getElementById('e_email').style.display = "none";
    return true;
}