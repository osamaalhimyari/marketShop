<!-- Hidden file input for image selection -->
<input type="file" id="images" name="images[]" multiple class="hidden" onchange="handleFileChange(event)">

<!-- Trigger button for file selection -->
<button type="button" onclick="document.getElementById('images').click()" class="mt-2 bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    {{ __('clickToUpload') }}
</button>

<!-- Preview container for displaying selected images with delete option -->
<div id="previewContainer" class="flex flex-wrap gap-4 mt-4"></div>

<!-- Hidden input to store uploaded image paths -->
<input type="hidden" id="imagePaths" name="imagePaths">

<script>
    let uploadedImagePaths = []; // To store paths of uploaded images

    function handleFileChange(event) {
        const files = Array.from(event.target.files);
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = ''; // Clear previous previews

        files.forEach((file, index) => {
            // Create wrapper for image and delete button
            const imageWrapper = document.createElement('div');
            imageWrapper.className = 'relative inline-block border border-gray-300 rounded-lg overflow-hidden shadow-sm';

            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.className = 'w-24 h-24 object-cover rounded-lg';
                imageWrapper.appendChild(imgElement);
            };
            reader.readAsDataURL(file);

            // Upload Progress Indicator
            const progressBar = document.createElement('div');
            progressBar.className = 'w-24 h-1 bg-gray-300 mt-1 relative';
            imageWrapper.appendChild(progressBar);

            const progressFill = document.createElement('div');
            progressFill.className = 'h-full bg-green-500 transition-all';
            progressBar.appendChild(progressFill);

            // Start upload
            uploadImage(file, progressFill, index);

            // Delete button
            const deleteButton = document.createElement('button');
            deleteButton.textContent = '✕';
            deleteButton.className = 'absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center focus:outline-none';
            
            // Handle delete button click
            deleteButton.onclick = function() {
                uploadedImagePaths.splice(index, 1); // Remove path from array
                document.getElementById('imagePaths').value = JSON.stringify(uploadedImagePaths);
                handleFileChange({ target: { files: Array.from(event.target.files).filter((_, i) => i !== index) } }); // Re-render previews
            };

            imageWrapper.appendChild(deleteButton);
            previewContainer.appendChild(imageWrapper);
        });
    }

    function uploadImage(file, progressFill, index) {
        const formData = new FormData();
        formData.append('image', file);

        const xhr = new XMLHttpRequest();
        const url = `{{ route('delete-image') }}`;
        xhr.open('POST', url, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

        // Track upload progress
        xhr.upload.onprogress = function(event) {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                progressFill.style.width = percentComplete + '%';
            }
        };

        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                uploadedImagePaths[index] = response.path; // Store the image path
                document.getElementById('imagePaths').value = JSON.stringify(uploadedImagePaths); // Update hidden field
            } else {
                console.error('Upload failed:', xhr.responseText);
            }
        };

        xhr.send(formData);
    }
</script>
