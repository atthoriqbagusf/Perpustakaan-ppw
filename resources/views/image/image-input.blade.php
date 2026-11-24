<input type="file" name="images[]" id="images" class="form-control"
       accept="image/jpeg,image/png,image/gif,image/webp" multiple>
<div id="sizeError" class="text-danger small d-none mt-1"></div>
<div id="preview" class="d-flex flex-wrap gap-2 mt-2"></div>

<script>
    (function () {
        const input = document.getElementById('images');
        const preview = document.getElementById('preview');
        const sizeError = document.getElementById('sizeError');
        const MAX = 2 * 1024 * 1024;

        input.addEventListener('change', () => {
            preview.innerHTML = '';
            sizeError.classList.add('d-none');

            const tooBig = [...input.files].filter(f => f.size > MAX);
            if (tooBig.length) {
                sizeError.textContent = 'File melebihi 2 MB: ' + tooBig.map(f => f.name).join(', ');
                sizeError.classList.remove('d-none');
                input.value = '';
                return;
            }

            [...input.files].forEach(file => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.width = 80;
                img.height = 80;
                img.className = 'rounded object-fit-cover border';
                preview.appendChild(img);
            });
        });
    })();
</script>
