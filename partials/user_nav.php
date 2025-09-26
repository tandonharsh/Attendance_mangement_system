<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="welcome.php">Attendance Management System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page"  href="take_attend.php">Mark Attendance</a>
          </li> 
          <li class="nav-item">
            <a class="nav-link active" aria-current="page"  href="get_attend.php">Get Attendance</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page"  href="edit_attend.php">Update Attendance</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page"  href="logout.php" onclick="logout()">Logout</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Actions
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="add_student.php">Add Student</a></li>
              <li><a class="dropdown-item" href="remove_student.php">Remove Student</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>