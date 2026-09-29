document.querySelectorAll('[data-prepare-image]').forEach((input) => {
    input.addEventListener('change', async () => {
        const file = input.files && input.files[0];
        if (!file) return;

        if (!['image/jpeg', 'image/png'].includes(file.type)) {
            alert('Please select a JPG or PNG image.');
            input.value = '';
            return;
        }

        const size = Number(input.dataset.prepareImage || 600);
        const image = new Image();
        const sourceUrl = URL.createObjectURL(file);

        try {
            await new Promise((resolve, reject) => {
                image.onload = resolve;
                image.onerror = reject;
                image.src = sourceUrl;
            });

            const cropSize = Math.min(image.naturalWidth, image.naturalHeight);
            const sourceX = (image.naturalWidth - cropSize) / 2;
            const sourceY = (image.naturalHeight - cropSize) / 2;
            const canvas = document.createElement('canvas');
            canvas.width = size;
            canvas.height = size;

            const context = canvas.getContext('2d');
            context.fillStyle = '#ffffff';
            context.fillRect(0, 0, size, size);
            context.drawImage(
                image,
                sourceX,
                sourceY,
                cropSize,
                cropSize,
                0,
                0,
                size,
                size
            );

            const blob = await new Promise((resolve) => {
                canvas.toBlob(resolve, 'image/jpeg', 0.85);
            });

            if (!blob) throw new Error('Image preparation failed.');
            if (blob.size > 2 * 1024 * 1024) throw new Error('Prepared image exceeds 2 MB.');

            const prepared = new File(
                [blob],
                file.name.replace(/\.[^.]+$/, '') + '-prepared.jpg',
                { type: 'image/jpeg' }
            );
            const transfer = new DataTransfer();
            transfer.items.add(prepared);
            input.files = transfer.files;

            const preview = document.querySelector(input.dataset.preview);
            if (preview) preview.src = URL.createObjectURL(prepared);
        } catch (error) {
            alert(error.message || 'The image could not be prepared.');
            input.value = '';
        } finally {
            URL.revokeObjectURL(sourceUrl);
        }
    });
});

