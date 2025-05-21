const form = document.getElementById('customerUploadForm');
const attachFile = document.getElementById('attachFile');
const attachedFiledDiv = document.getElementById('attachedFiled');
const nameInput = document.getElementById('floatingInputName');
const emailInput = document.getElementById('floatingInputEmail');
const serviceSelect = document.getElementById('floatingSelect');

attachFile.setAttribute('multiple', '');

const validExt = ['jpg','jpeg','png','doc','docx','pdf'];

attachFile.addEventListener('change', () => {
attachedFiledDiv.innerHTML = '';
const files = Array.from(attachFile.files);

for (let file of files) {
      const ext = file.name.split('.').pop().toLowerCase();
      if (!validExt.includes(ext)) {
      Swal.fire({
      icon: 'error',
      title: 'Invalid file type',
      text: `"${file.name}" is not allowed.\nPlease upload only JPEG, JPG, PNG, DOC, DOCX, or PDF.`,
      });
      attachFile.value = '';
      attachedFiledDiv.innerHTML = '';
      return;
      }
}

files.forEach(file => {
      const p = document.createElement('p');
      p.className = 'border border-secondary rounded px-2 py-1 mb-1';
      p.style.fontSize = '0.9em';
      p.textContent = file.name;
      attachedFiledDiv.appendChild(p);
});
});

form.addEventListener('submit', (e) => {
e.preventDefault();
let valid = true;

function checkField(el) {
      if (!el.value.trim()) {
      el.classList.add('is-invalid');
      el.classList.remove('is-valid');
      valid = false;
      } else {
      el.classList.remove('is-invalid');
      el.classList.add('is-valid');
      }
}

const existingError = attachedFiledDiv.querySelector('.text-danger');
if (existingError) existingError.remove();

[nameInput, emailInput, serviceSelect].forEach(checkField);

if (!attachFile.files.length) {
      const err = document.createElement('small');
      err.className = 'text-danger';
      err.textContent = 'Please attach at least one file.';
      attachedFiledDiv.appendChild(err);
      valid = false;
}

if (valid) {
      form.submit();
}
});
