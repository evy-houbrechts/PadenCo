function toggleVisibility(id) {
    const field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}