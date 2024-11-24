const div = document.querySelector(".main-back")
const pgHeader = document.querySelector(".lbl-new-item")

lblTime = document.getElementById("txtTime");

let LoggedUser;
let Items = [];
let newItems = [];

let anItem = {};

let itemId;

    const txtTitle = document.getElementById("txtTitle")
    const txtDesc = document.getElementById("txtDesc")
    const txtDate = document.getElementById("dtDate")

function fgetSystemTime(){
    setInterval(() => {
        const dt_date = new Date()
        let hour = dt_date.getHours();
        let min = dt_date.getMinutes();
        let sec = dt_date.getSeconds();

        if(hour < 10)
        {
            hour = "0" + hour;
        }

        if(min < 10)
        {
            min = "0" + min;
        }

        if(sec < 10)
        {
            sec = "0" + sec;
        }

        const displayTime = hour + ":" + min + ":" + sec;
        lblTime.innerHTML = displayTime;
    }, 1000)
}

window.addEventListener("DOMContentLoaded", () => {

    fgetSystemTime()

})