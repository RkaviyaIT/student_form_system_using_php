<?php
$host="localhost";
$username="root";
$password="Rkaviya@123";
$database="php_student_db";
$conn = new mysqli($host, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM students WHERE id=$id");
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $gender = $_POST['gender'];
    $hobby = $_POST['hobby'];
    $remarks = $_POST['remarks'];

    $sql = "UPDATE students SET name=?, email=?, department=?, gender=?, hobby=?, remarks=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $email, $department, $gender, $hobby, $remarks, $id);
    $stmt->execute();
    header("Location: register.php");
    exit();
}
?>

<?php if (isset($row)): ?>
<form method="post" action="update.php">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
    Email: <input type="email" name="email" value="<?php echo $row['email']; ?>"><br>
    Department: <input type="text" name="department" value="<?php echo $row['department']; ?>"><br>
    Gender:
    <input type="radio" name="gender" value="male" <?php if($row['gender']=='male') echo 'checked'; ?>>Male
    <input type="radio" name="gender" value="female" <?php if($row['gender']=='female') echo 'checked'; ?>>Female<br>
    Hobby: <input type="text" name="hobby" value="<?php echo $row['hobby']; ?>"><br>
    Remarks: <textarea name="remarks"><?php echo $row['remarks']; ?></textarea><br>
    <input type="submit" value="Update Student">
</form>


<?php endif; ?>
