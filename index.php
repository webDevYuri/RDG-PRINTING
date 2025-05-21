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
        <p class="text-danger fw-bold" id="ImportantNotice">
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
            input.addEventListener('input', () => {
              const hasBannedWord = inputsToCheck.some(field => {
                const value = field.value.toLowerCase();
                return bannedWords.some(word => value.includes(word));
              });

              if (hasBannedWord) {
                $('#submitBtn')
                  .text('Remove inappropriate word')
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

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById("customerUploadForm");
      const fileInput = document.getElementById("attachFile");
      const submitBtn = form.querySelector('button[type="submit"]');
      const attachedFiled = document.getElementById("attachedFiled");
      const maxTotalSize = 20 * 1024 * 1024;

      let filesArray = [];

      function getTotalSize(files) {
        return files.reduce((acc, file) => acc + file.size, 0);
      }
      function updateSubmitButton() {
        const totalSize = getTotalSize(filesArray);
        const totalMB = (totalSize / (1024 * 1024)).toFixed(2);
        const infoDiv = document.getElementById("fileSizeInfo");
        infoDiv.textContent = `Total selected file size: ${totalMB} MB`;

        if (totalSize > maxTotalSize) {
          submitBtn.textContent = "Your attachment exceed max file allowed";
          submitBtn.classList.add("btn-danger");
          submitBtn.disabled = true;
        } else if (filesArray.length === 0) {
          submitBtn.textContent = "Submit";
          submitBtn.classList.remove("btn-danger");
          submitBtn.disabled = true; 
        } else {
          submitBtn.textContent = "Submit";
          submitBtn.classList.remove("btn-danger");
          submitBtn.disabled = false;
        }
      }

      function renderFiles() {
        attachedFiled.innerHTML = "";
        filesArray.forEach((file, index) => {
          const fileDiv = document.createElement("div");
          fileDiv.className = "border rounded px-2 py-1 d-flex align-items-center gap-2";

          fileDiv.style.cursor = "default";
          fileDiv.style.position = "relative";

          const nameSpan = document.createElement("span");
          nameSpan.textContent = `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
          fileDiv.appendChild(nameSpan);

          const removeBtn = document.createElement("button");
          removeBtn.type = "button";
          removeBtn.innerHTML = "<i class='bi bi-x'></i>";
          removeBtn.className = "btn btn-sm btn-danger ms-auto";
          removeBtn.style.lineHeight = "1";
          removeBtn.style.padding = "0 6px";
          removeBtn.title = "Remove file";

          removeBtn.addEventListener("click", () => {
            filesArray.splice(index, 1);
            renderFiles();
            updateSubmitButton();
          });

          fileDiv.appendChild(removeBtn);
          attachedFiled.appendChild(fileDiv);
        });
      }

      fileInput.addEventListener("change", function () {
        const newFiles = Array.from(fileInput.files);
        newFiles.forEach((newFile) => {
          if (!filesArray.some(f => f.name === newFile.name && f.size === newFile.size)) {
            filesArray.push(newFile);
          }
        });

        renderFiles();
        updateSubmitButton();
        fileInput.value = "";
      });

      form.addEventListener("submit", function (e) {
        if (filesArray.length === 0) {
          e.preventDefault();
          Swal.fire({
            icon: "warning",
            title: "No Files",
            text: "Please attach at least one file before submitting.",
            confirmButtonText: "Okay"
          });
          return;
        }

        const totalSize = getTotalSize(filesArray);
        if (totalSize > maxTotalSize) {
          e.preventDefault();
          Swal.fire({
            icon: 'error',
            title: 'File Too Large',
            text: 'Total file size exceeds 20MB. Please upload smaller or fewer files.',
            confirmButtonText: 'Okay'
          });
          return;
        }
        e.preventDefault();
        const formData = new FormData(form);

        formData.delete("attachFile[]");
        filesArray.forEach((file) => formData.append("attachFile[]", file));

        fetch(form.action, {
          method: form.method,
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          Swal.fire({
            icon: 'success',
            title: 'Uploaded!',
            text: 'Your files have been sent!',
            confirmButtonText: 'Okay'
          }).then(() => {
            form.reset();
            filesArray = [];
            renderFiles();
            updateSubmitButton();
            window.history.replaceState({}, document.title, window.location.pathname);
          });
        })
        .catch(error => {
          Swal.fire({
            icon: 'error',
            title: 'Upload failed',
            text: 'There was an error uploading your files. Please try again.',
            confirmButtonText: 'Okay'
          });
          console.error(error);
        });
      });

      submitBtn.disabled = true;
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('customerUploadForm');
      const attachFile = document.getElementById('attachFile');

      form.addEventListener('submit', (event) => {
        const requiredFields = form.querySelectorAll('[required]');
        let allFilled = true;

        requiredFields.forEach(field => {
          if (!field.value.trim()) {
            allFilled = false;
          }
        });

        if (attachFile.files.length === 0) {
          allFilled = false;
        }

        if (!allFilled) {
          event.preventDefault();
          Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please fill in all required fields and attach at least one file.',
            confirmButtonText: 'Okay'
          });
        }
      });

      const params = new URLSearchParams(window.location.search);
      if (params.get('upload') === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Uploaded!',
          text: 'Your files have been sent!',
          confirmButtonText: 'Okay'
        }).then(() => {
        const newUrl = window.location.href.split('?')[0]; 
        window.history.replaceState({}, document.title, newUrl); 
      });
      }
    });
  </script>
  <script src="assets/js/file-validator.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</body>
</html>
