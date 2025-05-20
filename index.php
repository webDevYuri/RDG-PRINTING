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

  <div class="container col-12 col-sm-10 col-md-8 col-lg-6">
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
          required
        >
        <label for="attachFile" class="btn btn-primary mb-3" id="attachBtn">Browse files</label>
        <small class="text-center small-text" id="acceptedFileTypeText">Accepted file: JPEG, JPG, PNG, DOC, DOCX, PDF</small>
        <div id="attachedFiled" class="d-flex flex-wrap gap-2 my-2"></div>
        <p class="text-danger fw-bold small-text" id="ImportantNotice">
            <span class="fw-bolder">
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
          <option value="passport">Passport Size</option>
          <option value="1x1">1x1</option>
        </select>
        <label for="floatingSelect">Choose a Service</label>
      </div>

      <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const params = new URLSearchParams(window.location.search);
      if (params.get('upload') === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Uploaded!',
          text: 'Your files have been sent!',
          confirmButtonText: 'Okay'
        }).then(() => {
          window.history.replaceState({}, '', window.location.pathname);
        });
      }
    });
  </script>
  <script src="assets/js/file-validator.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</body>
</html>
