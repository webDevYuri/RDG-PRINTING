document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("attachFile");
    const submitBtn = document.querySelector('form#customerUploadForm button[type="submit"]');
    const attachedFiled = document.getElementById("attachedFiled");
    const fileSizeInfo = document.getElementById("fileSizeInfo");
    const maxTotalSize = 20 * 1024 * 1024; 

    let filesArray = [];

    function syncFileInput() {
        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    function getTotalSize(files) {
        return files.reduce((acc, file) => acc + file.size, 0);
    }

    function updateSubmitButton() {
        const totalSize = getTotalSize(filesArray);
        const totalMB = (totalSize / (1024 * 1024)).toFixed(2);
        fileSizeInfo.textContent = `Total selected file size: ${totalMB} MB`;

        if (totalSize > maxTotalSize) {
            submitBtn.textContent = "Your attachment exceeds 20MB";
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

            const nameSpan = document.createElement("span");
            nameSpan.textContent = `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
            fileDiv.appendChild(nameSpan);

            const removeBtn = document.createElement("button");
            removeBtn.type = "button";
            removeBtn.innerHTML = "<i class='bi bi-x'></i>";
            removeBtn.className = "btn btn-sm btn-danger ms-auto";
            removeBtn.title = "Remove file";

            removeBtn.addEventListener("click", () => {
                filesArray.splice(index, 1);
                syncFileInput(); 
                renderFiles();
                updateSubmitButton();
            });

            fileDiv.appendChild(removeBtn);
            attachedFiled.appendChild(fileDiv);
        });
    }

    fileInput.addEventListener("change", function () {
        const newFiles = Array.from(fileInput.files);
        newFiles.forEach(newFile => {
            if (!filesArray.some(f => f.name === newFile.name && f.size === newFile.size)) {
                filesArray.push(newFile);
            }
        });

        syncFileInput();
        renderFiles();
        updateSubmitButton();
    });

    updateSubmitButton();
});