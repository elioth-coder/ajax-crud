<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="float: left; box-sizing: border-box; width: 50%; padding: 15px;">
        <form id="MyForm">
            <input type="hidden" id="hiddenId" name="id">
            <input type="text" id="first_name" name="first_name" placeholder="Enter first name"><br>
            <input type="text" id="last_name" name="last_name" placeholder="Enter last name"><hr>
            <button id="submit" type="submit">Submit</button>
            <button id="cancel" type="button">Cancel</button>
        </form>
    </div>
    <div style="float:  left; box-sizing: border-box; width: 50%; padding: 15px;">
        <table id="NamesTable" border="1">
        <thead>
        <tr>
        <th>ID</th>
        <th>FIRST NAME</th>
        <th>LAST NAME</th>
        <th>ACTION</th>
        </thead>
        <tbody></tbody>
        </table>
    </div>
    <script>
    var formElements = [
        first_name,
        last_name,
        submit,
        cancel,
    ]

    function disableForm() {
        formElements.forEach((elem) => {
            elem.setAttribute("disabled", true);
        });
    }

    function enableForm() {
        formElements.forEach((elem) => {
            elem.removeAttribute("disabled");
        });
    }


    function clearForm() {
        first_name.value = "";
        last_name.value = "";
        hiddenId.value = "";
    }

    async function insert(formData) {
        let response = await fetch('create.php', {
            method: 'POST',
            body: formData,
        });
        
        let { status, message } = await response.json();

        alert(message);
        if(status=='success') {
            let rows = await fetchNames();
            populateTable(rows);
            clearForm();
        }
    }

    async function update(formData) {
        let response = await fetch('update.php', {
            method: 'POST',
            body: formData,
        });
        
        let { status, message } = await response.json();

        alert(message);
        if(status=='success') {
            let rows = await fetchNames();
            populateTable(rows);
            cancel.click();
        }
    }

    MyForm.onsubmit = async (e) => {
        e.preventDefault();
        let formData = new FormData(MyForm);

        disableForm();

        if(hiddenId.value != "") {
            await update(formData);
        } else {
            await insert(formData)
        }
        enableForm();

    }

    function populateTable(rows) {
        let content = "";

        rows.forEach((row) => {
            content += `
                <tr>
                <td>${row.id}</td>   
                <td>${row.first_name}</td>   
                <td>${row.last_name}</td>   
                <td>    
                    <button onclick='editName(${JSON.stringify(row)})'>Edit</button>
                    <button onclick="deleteName(${row.id});">Delete</button>
                </td>   
                </tr>
            `;
        });

        NamesTable.querySelector('tbody').innerHTML = content;
    }

    cancel.onclick = () => {
        clearForm();
        cancel.style.display = 'none';
    }

    async function deleteName(id) {
        let response = await fetch('delete.php?id=' + id);
        
        let { status, message } = await response.json();

        alert(message);

        if(status=='success') {
            let rows = await fetchNames();
            populateTable(rows);
        }
    }

    function editName(row) {
        hiddenId.value = row.id;
        first_name.value = row.first_name;
        last_name.value = row.last_name;
        cancel.style.display = 'inline-block';
    }

    async function fetchNames() {
        let response = await fetch('read.php');
        
        let { status, rows } = await response.json();

        return rows;
    }


    cancel.style.display = 'none';

    (async function() {
        let rows = await fetchNames();

        populateTable(rows);
    
    })();
    </script>
</body>
</html>