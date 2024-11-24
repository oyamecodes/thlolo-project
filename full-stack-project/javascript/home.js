let LoggedUser;
let UsersItems = [];
let LoggedUserItems = [];
let aItem = {};

let rowCount = 0;

const table = document.getElementById("tblItems");
const tableBody = document.getElementById("tblTbody");
const txtSearch = document.getElementById("txtSearch");
const notifications = document.querySelector(".dropdown-content");
const notiImg = document.querySelector(".dropbtn");

lblTime = document.getElementById("txtTime");

function ViewItem(element) {
    const itemId = element.getAttribute('data-id');
    window.location.href = `ViewTask.php?id=${itemId}`;
}

function DeleteItem(element) {
    const itemId = element.getAttribute('data-id');
    if (confirm("Are you sure you want to delete this item?")) {
        window.location.href = `delete.php?id=${itemId}`;
    }
}

function EditItem(element) {
    const itemId = element.getAttribute('data-id');
    window.location.href = `EditTask.php?id=${itemId}`;
}

function Search() {
    const searchTerm = txtSearch.value.toLowerCase();
    const filteredItems = UsersItems.filter(item => 
        item.title.toLowerCase().includes(searchTerm) || 
        item.description.toLowerCase().includes(searchTerm)
    );
    fGenerateSearchTable(filteredItems);
}

function fGenerateTable(items) {
    tableBody.innerHTML = '';
    items.forEach(item => {
        const row = tableBody.insertRow();
        row.insertCell(0).innerText = item.title;
        row.insertCell(1).innerText = item.description;
        row.insertCell(2).innerText = item.completion_date;
        row.insertCell(3).innerText = item.assigned_to;
        row.insertCell(4).innerText = item.status;
        const viewBtn = document.createElement('button');
        viewBtn.innerText = 'View';
        viewBtn.setAttribute('data-id', item.id);
        viewBtn.onclick = () => ViewItem(viewBtn);
        row.insertCell(5).appendChild(viewBtn);
        const editBtn = document.createElement('button');
        editBtn.innerText = 'Edit';
        editBtn.setAttribute('data-id', item.id);
        editBtn.onclick = () => EditItem(editBtn);
        row.insertCell(6).appendChild(editBtn);
        const deleteBtn = document.createElement('button');
        deleteBtn.innerText = 'Delete';
        deleteBtn.setAttribute('data-id', item.id);
        deleteBtn.onclick = () => DeleteItem(deleteBtn);
        row.insertCell(7).appendChild(deleteBtn);
    });
}

function fGenerateSearchTable(items) {
    fGenerateTable(items);
}

function fgetSystemTime() {
    const now = new Date();
    lblTime.innerText = now.toLocaleTimeString();
}

function fTodayDate() {
    const now = new Date();
    return now.toISOString().split('T')[0];
}

txtSearch.addEventListener("search", Search);

window.addEventListener("DOMContentLoaded", () => {
    fgetSystemTime();
    // Fetch and display items for the logged-in user
    // Example: fetchItemsForUser(LoggedUser);
});