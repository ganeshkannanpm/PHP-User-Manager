<!DOCTYPE html>
<html>
<head>
    <title>User Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">User Management System</h2>

    <div class="mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add User</button>
    </div>

    <div id="userTable">
        <!-- User list will load here via AJAX -->
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Add User</h5>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Edit User</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="mb-2">
            <label>Name</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" id="edit_email" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Phone</label>
            <input type="text" name="phone" id="edit_phone" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

function fetchUsers() {
    $.ajax({
        url: "ajax/fetch.php",
        type: "GET",
        success: function (data) {
            $("#userTable").html(data);
        }
    });
}

$(document).ready(function () {
    $("#addUserForm").submit(function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "ajax/insert.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (res) {
                alert(res.message);
                if (res.status === 'success') {
                    $("#addUserForm")[0].reset();
                    $("#addUserModal").modal('hide');
                    fetchUsers(); // to reload the table
                }
            }
        });
    });

    // Fetch users (next step)
    function fetchUsers() {
        $.ajax({
            url: "ajax/fetch.php",
            type: "GET",
            success: function (data) {
                $("#userTable").html(data);
            }
        });
    }

    fetchUsers(); // Load on page load
});

// Handle Edit Button Click
$(document).on("click", ".editBtn", function () {
    let row = $(this).closest("tr");
    let id = $(this).data("id");
    let name = row.find("td:eq(1)").text();
    let email = row.find("td:eq(2)").text();
    let phone = row.find("td:eq(3)").text();

    $("#edit_id").val(id);
    $("#edit_name").val(name);
    $("#edit_email").val(email);
    $("#edit_phone").val(phone);
    $("#editUserModal").modal('show');
});

// Submit Edit Form
$("#editUserForm").submit(function (e) {
    e.preventDefault();
    let formData = $(this).serialize();

    $.ajax({
        url: "ajax/update.php",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function (res) {
            alert(res.message);
            if (res.status === 'success') {
                $("#editUserModal").modal('hide');
                fetchUsers();
            }
        }
    });
});

// Handle Delete Button
$(document).on("click", ".deleteBtn", function () {
    let id = $(this).data("id");

    if (confirm("Are you sure you want to delete this user?")) {
        $.ajax({
            url: "ajax/delete.php",
            type: "POST",
            data: { id: id },
            dataType: "json",
            success: function (res) {
                alert(res.message);
                if (res.status === 'success') {
                    fetchUsers(); // 👈 this line refreshes the list
                }
            }
        });
    }
});



</script>

</body>
</html>
