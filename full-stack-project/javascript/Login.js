const txtusername = document.getElementById("txtlogin-username");
const txtpassword = document.getElementById("txtlogin-password");
const btnLogin = document.getElementById("btnLogin");
const lblTime = document.getElementById("txtTime");

function Login() {
    const username = txtusername.value;
    const password = txtpassword.value;

    if (username && password) {
        // Form will be submitted via HTML form action
        return true;
    } else {
        alert("Please fill all fields");
        return false;
    }
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
    
    // Add form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            if (!Login()) {
                e.preventDefault();
            }
        });
    }
});
