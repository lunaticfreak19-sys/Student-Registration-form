<?php
include 'db.php';

$result = $conn->query("SELECT id, reg_no, full_name, course, gender, email FROM students ORDER BY id DESC");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Records | Technical University of Kenya</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="sheet wide">
    <div class="letterhead">
      <div class="mark">
        <img class="crest" src="tuklogo.png" alt="Technical University of Kenya logo" />
        <div class="divider"></div>
        <div>
          <h1>Student Records Office</h1>
          <p>Registered Students</p>
        </div>
      </div>
      <div class="serial">TOTAL: <?php echo $result ? $result->num_rows : 0; ?></div>
    </div>

    <div class="body-block">
      <a class="back-link" href="index.html">&larr; Back to Registration Form</a>

      <?php if (isset($_GET['updated'])): ?>
        <div class="notice">Student record updated successfully.</div>
      <?php elseif (isset($_GET['deleted'])): ?>
        <div class="notice deleted">Student record deleted.</div>
      <?php endif; ?>

      <div class="intro">
        <h2>All Students</h2>
      </div>

      <?php if ($result && $result->num_rows > 0): ?>
      <table class="admin-table">
        <tr>
          <th>ID</th>
          <th>Reg. No.</th>
          <th>Full Name</th>
          <th>Course</th>
          <th>Gender</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['reg_no']); ?></td>
          <td><?php echo htmlspecialchars($row['full_name']); ?></td>
          <td><?php echo htmlspecialchars($row['course']); ?></td>
          <td><?php echo htmlspecialchars($row['gender']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td>
            <a class="pill-btn pill-edit" href="edit_student.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a class="pill-btn pill-delete" href="delete_student.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Delete this student record? This cannot be undone.');">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </table>
      <?php else: ?>
        <p class="empty-note">No students registered yet. <a href="index.html">Register the first one</a>.</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
<?php $conn->close(); ?>
