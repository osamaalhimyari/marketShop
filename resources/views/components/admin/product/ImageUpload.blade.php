

<!-- Hidden file input for image selection -->
<input type="file" id="images" name="images[]" multiple style="display: none;" onchange="handleFileChange(event)">

<!-- Trigger button for file selection -->
<button type="button" onclick="document.getElementById('images').click()" class="mt-2 bg-gray-200 py-2 px-4 rounded">
    {{ __('clickToUpload') }}
</button>

<!-- Preview container for displaying selected images with delete option -->
<div id="previewContainer" style="display: flex; flex-wrap: wrap; margin-top: 1rem;"></div>

<script>
    let productImages = [];

    function handleFileChange(event) {
        const files = Array.from(event.target.files);
        productImages = files; // Store the files in an array
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = ''; // Clear previous previews

        files.forEach((file, index) => {
            // Create a wrapper for each image and delete button
            const imageWrapper = document.createElement('div');
            imageWrapper.style.position = 'relative';
            imageWrapper.style.display = 'inline-block';
            imageWrapper.style.margin = '5px';

            // Display image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.style.width = '100px';
                imgElement.style.borderRadius = '4px';
                imgElement.style.display = 'block';
                imageWrapper.appendChild(imgElement);
            };
            reader.readAsDataURL(file);

            // Add delete button
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'X';
            deleteButton.style.position = 'absolute';
            deleteButton.style.top = '5px';
            deleteButton.style.right = '5px';
            deleteButton.style.backgroundColor = 'red';
            deleteButton.style.color = 'white';
            deleteButton.style.border = 'none';
            deleteButton.style.borderRadius = '50%';
            deleteButton.style.cursor = 'pointer';
            deleteButton.style.width = '20px';
            deleteButton.style.height = '20px';

            // Handle delete button click
            deleteButton.onclick = function() {
                productImages.splice(index, 1); // Remove image from the array
                handleFileChange({ target: { files: productImages } }); // Re-render previews
            };

            imageWrapper.appendChild(deleteButton);
            previewContainer.appendChild(imageWrapper);
        });
    }
</script>
