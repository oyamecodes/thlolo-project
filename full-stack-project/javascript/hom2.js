let LoggedUser;
let UsersItems = [];
let LoggedUserItems = []
let aItem = {};

let rowCount = 0;

const table = document.getElementById("tblItems");
const tableBody = document.getElementById("tblTbody");
const txtSearch = document.getElementById("txtSearch");
const notifications = document.querySelector(".dropdown-content")
const notiImg = document.querySelector(".dropbtn")

lblTime = document.getElementById("txtTime");

function ViewItem(element) {
    // Extract just the numeric ID from the element ID
    const taskId = element.id.split('view-')[1];
    if (taskId) {
        window.location.href = `ViewTask.php?id=${taskId}`;
    } else {
        console.error('Invalid task ID');
    }
}

function DeleteItem(element) {
    if (confirm("Are you sure you want to delete this task?")) {
        const taskId = element.id.split('delete-')[1];
        if (taskId) {
            window.location.href = `delete.php?id=${taskId}`;
        }
    }
}

function EditItem(element) {
    // Remove 'edit-' from the ID to get just the number
    const taskId = element.id.replace('edit-', '');
    if (taskId) {
        window.location.href = `EditTask.php?id=${taskId}`;
    } else {
        console.error('Invalid task ID');
    }
}

function Search()
{

   for(i = 0; i <= table.rows.length; i++) {

    if(table.rows.length != 1)
    {
        table.deleteRow(1);
    }

   }

    const tb = document.createElement("tr")

        LoggedUser = sessionStorage.getItem("LoggedUser")
        const lens = JSON.parse(localStorage.getItem("Items"))
        
        if(localStorage.getItem("Items") !== null)
        {
            
            UsersItems = JSON.parse(localStorage.getItem("Items"))
            LoggedUserItems = []

            for(Useritems of UsersItems)
            {
                if(Useritems.userid == LoggedUser)
                {
                    LoggedUserItems.push(Useritems);
                }
            }

            rowCount = 0;

            for(item of LoggedUserItems.reverse())
            {

                if(item.Title.toLowerCase().includes(txtSearch.value.toLowerCase())){
                    fGenerateSearchTable(item)
                }
            }
            
            table.appendChild(tableBody)
        }
}

let notiItem = '';
function fGenerateTable(item) {
    
    let rowID;
    const row = document.createElement("tr")

    rowCount++;
    

    for(let i = 0; i < Object.keys(item).length; i++)
    {
    
        if(Object.keys(item)[i] !== "id")
        {
            const cell = document.createElement("td")

            let cellData;
        
            if(Object.keys(item)[i] === "userid") 
            {
                cellData = document.createTextNode(`${rowCount}`)
            }
            else
            {
                if(Object.keys(item)[i] !== "Date")
                {
                    cellData = document.createTextNode(`${item[Object.keys(item)[i]].substring(0, 11)} ...`)
                    
                }
                else
                {
                    if(`${item[Object.keys(item)[i]]}` == fTodayDate()) 
                    {
                        // console.log(`date ${}`)

                        if(item["Description"].toLowerCase().includes("send an email") || item["Description"].toLowerCase().includes("send email")){
                            notiItem += `${'<div class="item"><div>' + item["Description"].substring(0, 35) + '</div><a href="mailto:">Send</a></div>'}`
                        }
                        else{
                            notiItem += `${'<div class="item"><div>' + item["Description"].substring(0, 35) + '</div></div>'}`
                        }
                        notiImg.src = "images/9042242_bell_notification_icon.png";
                        
                    }
                    cellData = document.createTextNode(`${item[Object.keys(item)[i]]}`)
                }
            }
            
            // notiItem += `${'<div class="item"><div>Send email to Sfisonxumalo69]@gmail.com</div><button value="send">Send</button></div>'}`
            
            cell.appendChild(cellData);
            row.appendChild(cell);
        } 
        else {
            rowID = `${item[Object.keys(item)[i]]}`
        }
    }

    notifications.innerHTML = notiItem ;

    const cellactions = document.createElement("td")

    const div = document.createElement("div")
    div.classList.add("icons");

    const im1 = document.createElement("img")

    im1.src = "images/eye.png"
    im1.setAttribute("id", "view-" + rowID)
    im1.addEventListener("click", () =>{ViewItem(im1)});

    const im2 = document.createElement("img")
    im2.src = "images/pencil.png"
    im2.setAttribute("id", "edit-" + rowID)
    im2.addEventListener("click", () =>{EditItem(im2)});

    const im3 = document.createElement("img")
    im3.src = "images/delete (1).png"
    im3.setAttribute("id", "delete-" + rowID)
    im3.addEventListener("click", () =>{DeleteItem(im3)});

    div.appendChild(im1)
    div.appendChild(im2)
    div.appendChild(im3)

    cellactions.appendChild(div)
    row.appendChild(cellactions)

    tableBody.appendChild(row);
}

function fGenerateSearchTable(item) {
    
    let rowID;
    const row = document.createElement("tr")

    rowCount++;
    

    for(let i = 0; i < Object.keys(item).length; i++)
    {
    
        if(Object.keys(item)[i] !== "id")
        {
            const cell = document.createElement("td")

            let cellData;
        
            if(Object.keys(item)[i] === "userid") 
            {
                cellData = document.createTextNode(`${rowCount}`)
            }
            else
            {
                if(Object.keys(item)[i] !== "Date")
                {
                    cellData = document.createTextNode(`${item[Object.keys(item)[i]].substring(0, 8)} ...`)
                    
                }
                else
                {
                    
                    cellData = document.createTextNode(`${item[Object.keys(item)[i]]}`)
                }
            }
            
            // notiItem += `${'<div class="item"><div>Send email to Sfisonxumalo69]@gmail.com</div><button value="send">Send</button></div>'}`
            
            cell.appendChild(cellData);
            row.appendChild(cell);
        } 
        else {
            rowID = `${item[Object.keys(item)[i]]}`
        }
    }

    const cellactions = document.createElement("td")

    const div = document.createElement("div")
    div.classList.add("icons");

    const im1 = document.createElement("img")

    im1.src = "images/eye.png"
    im1.setAttribute("id", "view-" + rowID)
    im1.addEventListener("click", () =>{ViewItem(im1)});

    const im2 = document.createElement("img")
    im2.src = "images/pencil.png"
    im2.setAttribute("id", "edit-" + rowID)
    im2.addEventListener("click", () =>{EditItem(im2)});

    const im3 = document.createElement("img")
    im3.src = "images/delete (1).png"
    im3.setAttribute("id", "delete-" + rowID)
    im3.addEventListener("click", () =>{DeleteItem(im3)});

    div.appendChild(im1)
    div.appendChild(im2)
    div.appendChild(im3)

    cellactions.appendChild(div)
    row.appendChild(cellactions)

    tableBody.appendChild(row);
}

txtSearch.addEventListener("search", Search)

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

function fTodayDate()
{
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
    
        return dt;
}

window.addEventListener("DOMContentLoaded", () =>{

    fgetSystemTime()

})