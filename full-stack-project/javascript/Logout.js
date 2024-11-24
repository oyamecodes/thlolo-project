const btnLogout = document.getElementById("logout")

btnLogout.addEventListener("click", () => {
    sessionStorage.clear()
    window.location.replace("logout.php");
})