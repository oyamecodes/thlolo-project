const div = document.querySelector(".main-back");
const pgHeader = document.querySelector(".lbl-new-item");
let LoggedUser;

let users = [];

// Define variables at the top level but initialize them when DOM loads
let txtusername, txtpassword, txtrepassword, lblTime;

function UpdateProfile() {
    const username = txtusername.value;
    const password = txtpassword.value;
    const repassword = txtrepassword.value;

    if (password !== repassword) {
        alert("Passwords do not match");
        return;
    }

    if (username && password) {
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        fetch('update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                alert("Profile updated successfully");
                window.location.href = 'home.php';
            } else {
                alert("Error updating profile: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error updating profile");
        });
    } else {
        alert("Please fill all fields");
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables after DOM is loaded
    txtusername = document.getElementById("txtUsername");
    txtpassword = document.getElementById("txtPassword");
    txtrepassword = document.getElementById("txtRePassword");
    lblTime = document.getElementById("txtTime");

    const btnUpdate = document.getElementById("btnSubm");
    if (btnUpdate) {
        btnUpdate.addEventListener("click", UpdateProfile);
    }

    function fgetSystemTime() {
        const now = new Date();
        if (lblTime) {
            lblTime.innerText = now.toLocaleTimeString();
        }
    }

    // Initialize
    fgetSystemTime();
});