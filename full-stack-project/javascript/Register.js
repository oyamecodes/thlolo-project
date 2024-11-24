const btnReg = document.getElementById("btnRegister")
const div = document.querySelector(".main-back")
const pgHeader = document.querySelector(".lbl-new-item")

const txtusername = document.getElementById("txtregUsername");
const txtpassword = document.getElementById("txtregPassword");
const txtrepassword = document.getElementById("txtRePassword");
const lblTime = document.getElementById("txtTime");

function Register() {
    const username = txtusername.value;
    const password = txtpassword.value;
    const repassword = txtrepassword.value;

    if (password !== repassword) {
        alert("Passwords do not match");
        return false; // Explicitly return false
    }

    if (username && password) {
        // Form will submit to register_process.php
        return true;
    } else {
        alert("Please fill all fields");
        return false;
    }
}

function fclear(txtusername, txtpassword, txtrepassword) {
    txtusername.value = '';
    txtpassword.value = '';
    txtrepassword.value = '';
}

function fgetSystemTime() {
    setInterval(() => {
        const dt_date = new Date();
        let hour = dt_date.getHours();
        let min = dt_date.getMinutes();
        let sec = dt_date.getSeconds();

        if (hour < 10) hour = "0" + hour;
        if (min < 10) min = "0" + min;
        if (sec < 10) sec = "0" + sec;

        const displayTime = hour + ":" + min + ":" + sec;
        if (lblTime) lblTime.innerHTML = displayTime;
    }, 1000);
}

window.addEventListener("DOMContentLoaded", () => {
    fgetSystemTime();
    
    // Add form submit validation
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
        if (!Register()) {
            e.preventDefault();
        }
    });
});

const form = document.querySelector('form');
if (form) {
    form.addEventListener('submit', (e) => {
        if (!Register()) {
            e.preventDefault();
        }
    });
}