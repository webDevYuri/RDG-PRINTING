<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css"/>
  <link rel="stylesheet" href="assets/css/client.css" >
  <link rel="icon" href="assets/logo/logo.png" type="image/x-icon">
  <title>Upload your file | RDG Printing</title>
</head>
<body class="d-flex flex-column justify-content-center align-items-center">

  <div class="container col-12 col-sm-10 col-md-8 col-lg-6 py-3">
    <form action="backend/process/upload.php" method="post" enctype="multipart/form-data" class="shadow-sm rounded p-4" id="customerUploadForm">
      <h2 class="text-center mb-4 text-uppercase fw-bolder text-opacity-75">Upload your file</h2>

      <div class="form mb-3 p-3 d-flex flex-column justify-content-center align-items-center bg-white shadow-sm">
        <img src="assets/logo/upload.png" alt="UploadLogo" class="img-fluid w-25" id="uploadLogo">
        <input
          type="file"
          class="form-control"
          id="attachFile"
          name="attachFile[]"
          accept=".jpg,.jpeg,.png,.doc,.docx,.pdf"
          multiple
        >
        <label for="attachFile" class="btn btn-primary mb-3" id="attachBtn" tabindex="0">Browse files</label>
        <small class="text-center text-sm" id="acceptedFileTypeText">Accepted file: JPEG, JPG, PNG, DOC, DOCX, PDF</small>
        <small class="text-center text-sm fw-bold text-primary mt-1" id="fileSizeInfo"></small>
        <small class="text-center text-sm fw-bolder" id="maxFileSize">Max Size: 20mb</small>
        <div id="attachedFiled" class="d-flex flex-wrap gap-2 my-2"></div>
        <p class="text-danger fw-bold text-sm" id="ImportantNotice">
            <span class="fw-bolder text-sm">
              IMPORTANT: 
            </span>
            Make sure your information is correct.
        </p>
      </div>

      <div class="form-floating mb-3">
        <input
          type="text"
          class="form-control"
          id="floatingInputName"
          name="name"
          placeholder="Your Name"
          required
          autocomplete="off"
        >
        <label for="floatingInputName">Your Name *</label>
      </div>

      <div class="form-floating mb-3">
        <input
          type="email"
          class="form-control"
          id="floatingInputEmail"
          name="email"
          placeholder="Email Address"
          required
          autocomplete="off"
        >
        <label for="floatingInputEmail">Email Address *</label>
      </div>

      <div class="form-floating mb-3">
        <select
          class="form-select"
          id="floatingSelect"
          name="service"
          aria-label="Floating label select"
          required
        >
          <option selected disabled value=""></option>
          <option value="print">Print</option>
          <option value="2x2">2x2</option>
          <option value="passport size">Passport Size</option>
          <option value="1x1">1x1</option>
        </select>
        <label for="floatingSelect">Choose a Service</label>
      </div>

      <div class="form-floating mb-3">
          <textarea
              style="height: 150px; line-height: 1.7;"
              class="form-control pt-4 pb-2"
              id="floatingJobInstructions"
              name="job_instructions"
              placeholder="Job Instructions"
              required
          ></textarea>
          <label for="floatingJobInstructions">Leave a message *</label>
      </div>

      <button type="submit" class="btn btn-primary w-100" id="submitBtn">Submit</button>
    </form>
  </div>


   <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
  <script>
        <?php
        if (!empty($_SESSION['errors'])) {
            $message = implode("<br>", $_SESSION['errors']);
            echo "Swal.fire('Error', `$message`, 'error');";
            unset($_SESSION['errors']);
        }

        if (!empty($_SESSION['success'])) {
            echo "Swal.fire('Success', '{$_SESSION['success']}', 'success');";
            unset($_SESSION['success']);
        }
        ?>
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      let bannedWords = [];
      $.ajax({
        url: 'backend/process/banned-words.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          bannedWords = data.map(word => word.toLowerCase());

          const inputsToCheck = [
            document.getElementById('floatingInputName'),
            document.getElementById('floatingInputEmail'),
            document.getElementById('floatingJobInstructions')
          ];

          inputsToCheck.forEach(input => {
            const nameRegex = /^[a-zA-Z\s.'-]{2,}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            input.addEventListener('input', () => {
              const nameValue = inputsToCheck[0].value.trim();
              const emailValue = inputsToCheck[1].value.trim();
              const instructionsValue = inputsToCheck[2].value.trim();

              const hasBannedWord = bannedWords.some(word =>
                nameValue.toLowerCase().includes(word) ||
                emailValue.toLowerCase().includes(word) ||
                instructionsValue.toLowerCase().includes(word)
              );

              const isNameValid = nameRegex.test(nameValue);
              const isEmailValid = emailRegex.test(emailValue);

              if (hasBannedWord) {
                $('#submitBtn')
                  .text('Remove inappropriate word')
                  .prop('disabled', true)
                  .removeClass('btn-primary')
                  .addClass('btn-danger');
              } else if (!isNameValid) {
                $('#submitBtn')
                  .text('Enter your real name')
                  .prop('disabled', true)
                  .removeClass('btn-primary')
                  .addClass('btn-danger');
              } else if (!isEmailValid) {
                $('#submitBtn')
                  .text('Enter a valid email')
                  .prop('disabled', true)
                  .removeClass('btn-primary')
                  .addClass('btn-danger');
              } else {
                $('#submitBtn')
                  .text('Submit')
                  .prop('disabled', false)
                  .removeClass('btn-danger')
                  .addClass('btn-primary');
              }
            });
          }); 
        } 
      }); 
  </script>
  <script src="assets/js/file-validator.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
