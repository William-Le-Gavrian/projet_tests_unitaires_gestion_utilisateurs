document.addEventListener("DOMContentLoaded", function () {
    const userForm = document.getElementById("userForm");
    const userList = document.getElementById("userList");
    const userIdField = document.getElementById("userId");

    function fetchUsers() {
        fetch("api.php")
            .then(response => response.json())
            .then(users => {
                userList.innerHTML = "";
                users.forEach(user => {
                    const li = document.createElement("li");
                    const userInfos = document.createElement("p");
                    const userAge = document.createElement("p");
                    const div = document.createElement("div");
                    userInfos.innerHTML = `${user.name} (${user.email})`;
                    userAge.innerHTML = `${user.age} ans`;
                    div.innerHTML = `
                        <button onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.age}')">✏️</button>
                        <button onclick="deleteUser(${user.id})">❌</button>`;
                    li.appendChild(userInfos);
                    li.appendChild(userAge);
                    li.appendChild(div);
                    userList.appendChild(li);
                });
            });
    }

    userForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const age = document.getElementById("age").value;
        const userId = userIdField.value;

        if (userId) {
            fetch("api.php", {
                method: "PUT",
                body: new URLSearchParams({ id: userId, name, email, age }),
                headers: { "Content-Type": "application/x-www-form-urlencoded" }
            }).then(() => {
                fetchUsers();
                userForm.reset();
                userIdField.value = "";
            });
        } else {
            fetch("api.php", {
                method: "POST",
                body: new URLSearchParams({ name, email, age }),
                headers: { "Content-Type": "application/x-www-form-urlencoded" }
            }).then(() => {
                fetchUsers();
                userForm.reset();
            });
        }
    });

    window.editUser = function (id, name, email, age) {
        document.getElementById("name").value = name;
        document.getElementById("email").value = email;
        document.getElementById("age").value = age;
        userIdField.value = id;
    };

    window.deleteUser = function (id) {
        fetch(`api.php?id=${id}`, { method: "DELETE" })
            .then(() => fetchUsers());
    };

    fetchUsers();
});
