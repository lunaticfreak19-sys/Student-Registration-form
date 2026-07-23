<?php
include 'db.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header("Location: view_students.php");
    exit();
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT id, reg_no, full_name, course, gender, email FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: view_students.php");
    exit();
}

$student = $result->fetch_assoc();
$stmt->close();

// Same course list offered on the public registration form
$courses = [
    "Bachelor of Science in Computer Science",
    "Bachelor of Science in Information Technology",
    "Bachelor of Engineering in Civil Engineering",
    "Bachelor of Engineering in Electrical & Electronic Engineering",
    "Bachelor of Engineering in Mechanical Engineering",
    "Bachelor of Architecture",
    "Diploma in Building Technology",
    "Diploma in Business Management",
    "Other"
];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Student | Technical University of Kenya</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="sheet">
    <div class="letterhead">
      <div class="mark">
        <img class="crest" src="tuklogo.png" alt="Technical University of Kenya logo" />
        <div class="divider"></div>
        <div>
          <h1>Student Records Office</h1>
          <p>Edit Student Record</p>
        </div>
      </div>
      <div class="serial">ID: <?php echo htmlspecialchars($student['id']); ?></div>
    </div>

    <div class="body-block">
      <a class="back-link" href="view_students.php">&larr; Back to Student List</a>

      <div class="intro">
        <h2>Update details</h2>
      </div>

      <form action="update_student.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>" />

        <div class="field">
          <label for="reg_no">Registration No.<span class="req">*</span></label>
          <div class="control">
            <input type="text" id="reg_no" name="reg_no"
                   value="<?php echo htmlspecialchars($student['reg_no']); ?>" required />
          </div>
        </div>

        <div class="field">
          <label for="full_name">Full Name<span class="req">*</span></label>
          <div class="control">
            <input type="text" id="full_name" name="full_name"
                   value="<?php echo htmlspecialchars($student['full_name']); ?>" required />
          </div>
        </div>

        <div class="field">
          <label for="course">Course<span class="req">*</span></label>
          <div class="control">
            <select id="course" name="course" required>
              <?php foreach ($courses as $c): ?>
                <option value="<?php echo htmlspecialchars($c); ?>"
                  <?php echo ($student['course'] === $c) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($c); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="field">
          <label>Gender<span class="req">*</span></label>
          <div class="control">
            <div class="gender-options">
              <?php foreach (["Female", "Male", "Prefer not to say"] as $g): ?>
                <label>
                  <input type="radio" name="gender" value="<?php echo $g; ?>"
                    <?php echo ($student['gender'] === $g) ? 'checked' : ''; ?> required />
                  <?php echo $g; ?>
                </label>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <div class="field">
          <label for="email">Email Address<span class="req">*</span></label>
          <div class="control">
            <input type="email" id="email" name="email"
                   value="<?php echo htmlspecialchars($student['email']); ?>" required />
          </div>
        </div>

        <div class="actions">
          <div class="fine-print">Changes are saved directly to the students table.</div>
          <button type="submit" class="submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
              <polyline points="20 6 9 17 4 12" />
            </svg>
            Update Student
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
<?php $conn->close(); ?>
