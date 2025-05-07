<?php
$host = "localhost";
$username = "root";
$password = "Rkaviya@123";
$database = "php_student_db";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['update_id']) ? $_POST['update_id'] : '';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];
    $gender = $_POST['gender'];
    $hobby = isset($_POST['hobby']) ? $_POST['hobby'] : '';
    $remarks = $_POST['remarks'];
    $img_name = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $img_name = "uploads/" . time() . "_" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $img_name);
    }

    if (!empty($id)) {
        if (!empty($img_name)) {
            $stmt = $conn->prepare("UPDATE students SET name=?, email=?, password=?, dob=?, department=?, gender=?, hobby=?, remarks=?, image=? WHERE id=?");
            $stmt->bind_param("sssssssssi", $name, $email, $password, $dob, $department, $gender, $hobby, $remarks, $img_name, $id);
        } else {
            $stmt = $conn->prepare("UPDATE students SET name=?, email=?, password=?, dob=?, department=?, gender=?, hobby=?, remarks=? WHERE id=?");
            $stmt->bind_param("ssssssssi", $name, $email, $password, $dob, $department, $gender, $hobby, $remarks, $id);
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO students (name, email, password, dob, department, gender, hobby, remarks, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $email, $password, $dob, $department, $gender, $hobby, $remarks, $img_name);
    }

    $stmt->execute();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student form</title>
     <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Select2 CSS & JS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  
 

    <style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2980b9;
        --accent-color: #e74c3c;
        --light-color: #ecf0f1;
        --dark-color: #2c3e50;
        --success-color: #2ecc71;
        --warning-color: #f39c12;
        --border-radius: 5px;
        --box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f5f7fa;
        margin: 0;
        padding: 20px;
    }

    .container {
        display: flex;
        width: 100%;
        justify-content: space-between;
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .child-div {
        flex: 1;
        border: 1px solid #ddd;
        margin: 10px;
        padding: 25px;
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: var(--transition);
    }

    .child-div:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .form-container {
        flex:1;
        display: flex;
        flex-direction: column;
    }

    h2, h3 {
        color: var(--dark-color);
        margin-top: 0;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary-color);
    }

    label {
        display: block;
        margin: 15px 0 5px;
        font-weight: 600;
        color: var(--dark-color);
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        font-size: 16px;
        transition: var(--transition);
    }

    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    }

    input[type="radio"] {
        margin-right: 5px;
    }

    #hobby-options {
        margin: 10px 0;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: var(--border-radius);
    }

    #hobby-options label {
        display: block;
        margin: 8px 0;
        font-weight: normal;
    }

    input[type="submit"],
    input[type="reset"],
    button,
    input[type="button"] {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        margin: 15px 10px 0 0;
        border-radius: var(--border-radius);
        cursor: pointer;
        font-size: 16px;
        transition: var(--transition);
    }

    input[type="submit"]:hover,
    input[type="reset"]:hover,
    button:hover,
    input[type="button"]:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
    }

    input[type="reset"] {
        background-color: var(--light-color);
        color: var(--dark-color);
    }

    input[type="file"] {
        margin: 10px 0;
    }

    .table-container {
        flex:3;
        overflow-x: auto;
        padding: 10px;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-container th {
        background-color: var(--primary-color);
        color: white;
        padding: 12px;
        text-align: left;
    }

    .table-container td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .table-container tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .table-container tr:hover {
        background-color: #e9f7fe;
    }

    .table-container img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid var(--light-color);
    }

    .table-container button {
        background-color: var(--warning-color);
        padding: 8px 15px;
        margin: 0;
    }

    .table-container input[type="submit"] {
        background-color: var(--accent-color);
        padding: 8px 15px;
        margin: 0;
    }

    @media (max-width: 1024px) {
        .container {
            flex-direction: column;
        }
        
        .child-div {
            width: 100%;
            margin: 10px 0;
        }
    }

    </style>

    <script>
        $(document).ready(function() {
    $('#hobby').select2({
        tags:true,
        placeholder: "Select hobbies"
    });
});

$('#hobby').val(selectedHobbiesArray).trigger('change');


        function editStudent(id, name, email, password, dob, department, gender, hobby, remarks) {
            document.getElementById('update_id').value = id;
            document.querySelector('input[name="name"]').value = name;
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="password"]').value = password;
            document.querySelector('input[name="dob"]').value = dob;
            document.querySelector('select[name="department"]').value = department;
            document.querySelector(`input[name="gender"][value="${gender}"]`).checked = true;
            updateHobbies(gender);

            setTimeout(() => {
                const hobbyRadio = document.querySelector(`input[name="hobby"][value="${hobby}"]`);
                if (hobbyRadio) hobbyRadio.checked = true;
            }, 100);

            document.querySelector('textarea[name="remarks"]').value = remarks;

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="child-div form-container">
            <h3>Student Register Form</h3>
            <form action="#" method="post" enctype="multipart/form-data">
                <label for="name">Student Name:</label>
                <input type="text" name="name" required><br>

                <label for="email">Email: </label>
                <input type="email" name="email" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" required><br>

                <label for="dob">Birth date:</label>
                <input type="date" name="dob" required><br>

                <label for="department">Department:</label>
                <select name="department">
                    <option value="CSE">CSE</option>
                    <option value="ECE">ECE</option>
                    <option value="EEE">EEE</option>
                </select><br><br>

                <label for="gender">Gender:</label>
                <input type="radio" name="gender" value="male">Male
                <input type="radio" name="gender" value="female">Female<br><br>


                <label for="hobby">Hobby</label>
<select id="hobby" name="hobby[]" multiple="multiple" class="input-val" style="width: 100%;">
     <option selected >Gaming</option>
     <option>reading</option>     
</select>


                <label for="remarks">Remarks:</label><br>
                <textarea name="remarks" rows="3" cols="30"></textarea><br><br>

                <label for="image">Upload Photo:</label>
                <input type="file" name="image" accept="image/*"><br><br>

                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
                <input type="hidden" name="update_id" id="update_id">
            </form>
        </div>

        <div class="child-div table-container">
            <h2>Student Table</h2>
            <table>
                <tr>
                    <th>S.No</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Dept</th>
                    <th>Gender</th>
                    <th>Hobby</th>
                    <th>Age</th>
                    <th>Remarks</th>
                    <th>Delete</th>
                    <th>Update</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM students");
                $sno=1;
                while ($row = $result->fetch_assoc()) {

                    $dob = new DateTime($row['dob']);
                    $today = new DateTime();
                    $age = $today->diff($dob)->y;
                    echo "<tr>
                        <td>{$sno}</td>
                        <td><img src='{$row['image']}' alt='student image' style='width:60px; height:60px; object-fit:cover;'></td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['hobby']}</td>
                        <td>{$age}</td>
                        <td>{$row['remarks']}</td>
                        <td>
                            <form action='.\delete.php' method='post'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <input type='submit' value='Delete'>
                            </form>
                        </td>
                        <td>
                            <button onclick='editStudent(" . json_encode($row['id']) . ", " . json_encode($row['name']) . ", " . json_encode($row['email']) . ", " . json_encode($row['password']) . ", " . json_encode($row['dob']) . ", " . json_encode($row['department']) . ", " . json_encode($row['gender']) . ", " . json_encode($row['hobby']) . ", " . json_encode($row['remarks']) . ")'>Update</button>
                        </td>
                    </tr>";
                    $sno++;
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
