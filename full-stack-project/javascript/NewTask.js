const btnSave = document.getElementById("Save");
const div = document.querySelector(".main-back");
const pgHeader = document.querySelector(".lbl-new-item");
let anItem = {};
let Items = [];

const txtTitle = document.getElementById("txtTitle");
const txtDesc = document.getElementById("txtDesc");
const txtDate = document.getElementById("dtDate");

lblTime = document.getElementById("txtTime");

let LoggedUser;

function AddNew() {
    const title = txtTitle.value;
    const desc = txtDesc.value;
    const date = txtDate.value;

    if (title && desc && date) {
        anItem = {
            title: title,
            description: desc,
            completion_date: date,
            assigned_to: LoggedUser,
            status: 'pending'
        };
        Items.push(anItem);
        localStorage.setItem('Items', JSON.stringify(Items));
        alert("Task added successfully");
        fClearFleids(txtTitle, txtDesc, txtDate);
    } else {
        alert("Please fill all fields");
    }
}

function getItemsFromStorage() {
    const storedItems = localStorage.getItem('Items');
    if (storedItems) {
        Items = JSON.parse(storedItems);
    }
}

function fCheckIfItemExists(title) {
    return Items.some(item => item.title === title);
}

function fClearFleids(txtTitle, txtDesc, txtDate) {
    txtTitle.value = '';
    txtDesc.value = '';
    txtDate.value = '';
}

function fgetSystemTime() {
    const now = new Date();
    lblTime.innerText = now.toLocaleTimeString();
}

window.addEventListener("DOMContentLoaded", () => {
    fgetSystemTime();
    if (sessionStorage.getItem("LoggedUser") === null) {
        window.location.replace("UnauthorizedAccess.php");
    } else {
        LoggedUser = sessionStorage.getItem("LoggedUser");
        getItemsFromStorage();
    }
});

btnSave.addEventListener("click", AddNew);