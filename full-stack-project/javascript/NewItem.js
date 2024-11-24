const btnSave = document.getElementById("Save")
const div = document.querySelector(".main-back")
const pgHeader = document.querySelector(".lbl-new-item")
let anItem = {}
let Items = [];

const txtTitle = document.getElementById("txtTitle")
const txtDesc = document.getElementById("txtDesc")
const txtDate = document.getElementById("dtDate")

lblTime = document.getElementById("txtTime");

let LoggedUser;

function AddNew()
{
    const lblunfeed = document.getElementById("lblunFeedback")
    const lblpassfeed = document.getElementById("lbpaFeedback")
    const lblrepassfeed = document.getElementById("lbrepaFeedback")

     if(txtTitle.value === "")
    {
        lblunfeed.innerHTML = "Empty Title"
        lblunfeed.style.color = "red"

        return;
    }
    else{
        lblunfeed.innerHTML = ""
    }

    if(txtDesc.value === "")
    {
        lblpassfeed.innerHTML = "Empty Description"
        lblpassfeed.style.color = "red"

        return
    }
    else{
        lblpassfeed.innerHTML = ""
    }

    if(txtDate.value === "")
    {
        lblrepassfeed.innerHTML = "Empty Due Date"
        lblrepassfeed.style.color = "red"

        return
    }
    else{
        lblrepassfeed.innerHTML = ""
    }

    anItem.userid = LoggedUser;
    anItem.Title = txtTitle.value;
    anItem.Description = txtDesc.value;
    anItem.Date = txtDate.value;
    anItem.id = 0;

    if(!fCheckIfItemExists()) {

        Items = getItemsFromStorage();

        if(Items !== null)
        {
            anItem.id = Items.length;
        }
        else{
            Items = [];
        }

        Items.push(anItem);
        localStorage.set

        localStorage.setItem("Items", JSON.stringify(Items))

        div.style.background = "rgb(75, 180, 54)";

        pgHeader.innerHTML = "Saved successfully"
        
        setTimeout(() => {
            div.style.background = "coral";
            pgHeader.innerHTML = "New Item"
        }, 4000);

        fClearFleids(txtTitle, txtDesc, txtDate);
    }
}

function getItemsFromStorage(){

    if(!localStorage.getItem("Items"))
    {
        return [];
    }
    
    return JSON.parse(localStorage.getItem("Items"));
}

function fCheckIfItemExists(){

    const Founditems = getItemsFromStorage()

    for(item of Founditems) 
    {
        if(item.userid == LoggedUser)
        {
            if(item.Title == txtTitle.value && item.Description == txtDesc.value && item.Date == txtDate.value)
            {
                alert("Item already exists");
                return true;
            }
            else if(item.Title == txtTitle.value){

                alert("Item with this title exists");
                return true;
            }
        }
    }

    return false;
}

function fClearFleids(txtTitle, txtDesc, txtDate)
{
    txtTitle.value = "";
    txtDesc.value = "";
    txtDate.value = "";
    txtDate.valueAsDate = new Date();
}

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

window.addEventListener("DOMContentLoaded", () =>{

    fgetSystemTime()

    if(sessionStorage.getItem("LoggedUser") === null)
    {
        window.location.replace("UnauthorizedAccess.php");
    }
    else
    {
        LoggedUser = sessionStorage.getItem("LoggedUser")

        // const dtToday = new Date();
    
        // let month = dtToday.getMonth() + 1;
        // let day = dtToday.getDate();
        // const year = dtToday.getFullYear();

        // if(month < 10)
        // {
        //     month = '0' + month.toString();
        // }
            
        // if(day < 10){
        //     day = '0' + day.toString();
        // }
            
        
        // let maxDate = year + '-' + month + '-' + day;
    
        // or instead:
        // var maxDate = dtToday.toISOString().substr(0, 10);
    
        // txtDate.setAttribute('min', maxDate);

        const DateDt = new Date().toLocaleDateString();
        
        const NewDate = DateDt.split("/")


        let dayD = NewDate[0]
        let monD = NewDate[1]
        if(NewDate[0] < 10)
        {
            dayD = "0" + NewDate[0]
        }

        if(NewDate[1] < 10)
        {
            monD = "0" + NewDate[1]
        }
        const dt = NewDate[NewDate.length - 1] + "-" + dayD + "-" + monD

        txtDate.valueAsDate = new Date();

        txtDate.setAttribute('min', dt)
    }
})

btnSave.addEventListener("click", AddNew)