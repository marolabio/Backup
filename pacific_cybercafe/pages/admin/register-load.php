<?php 

	include_once 'includes/dbh.inc.php';


    $sql = $conn->query("SELECT * FROM users");

    if ($sql->num_rows > 0) {

      echo "<div class = 'table-responsive'>
          <table class = 'table table-bordered table-hover table-condensed'>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Action</th>
            </tr>  
      ";
      while ($row = mysqli_fetch_assoc($sql)) {
        echo "
          <tr id = '$row[user_id]'>
            <td data-target = 'user_first'>$row[user_first]</td>
            <td data-target = 'user_last'>$row[user_last]</td>
            <td data-target = 'user_email'>$row[user_email]</td>
            <td>
              <button class = 'btn btn-info edit' data-id = '$row[user_id]'>Edit</button>
              <button class = 'btn btn-danger delete' data-id = '$row[user_id]'>Delete</button>
            </td>
          </tr>
        ";  
      }
      echo "</table></div>";

    }else{
      echo "<div class = 'alert alert-success'>No records found</div>";
    }

    


?>

<script>
    $(document).on("click", ".delete", function () {
         var user_id = $(this).data('id');
          $(".deleteUser #user_id").val( user_id );
          $('#deleteUser').modal('show'); 
    });

    $(document).on("click", ".edit", function (){

      var user_id = $(this).data('id');
      var user_first = $('#'+user_id).children('td[data-target=user_first]').text();
      var user_last = $('#'+user_id).children('td[data-target=user_last]').text();
      var user_email = $('#'+user_id).children('td[data-target=user_email]').text();

       // Set value to be updated
       $("#user_id").val(user_id);
       $('#user_first').val(user_first);
       $('#user_last').val(user_last);
       $('#user_email').val(user_email);

       $('#password').attr("disabled", true);
       $('#password1').attr("disabled", true);
       $('#type').attr("disabled", true);

       // Change heading and classes
       $('#panel-heading').html('Update Account');
       $('#btn-submit').html('Update');
       $('#btn-submit').removeClass('btn-success');
       $('#btn-submit').addClass('btn-primary');

       // Change form action
       var newAction = 'register-edit.php';
       $('#form-id').attr('action', newAction);

    });
</script>


