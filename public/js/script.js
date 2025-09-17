document.addEventListener('DOMContentLoaded', function() {
    const bannerList = document.getElementById('bannerList');
    const addBanner = document.getElementById('addBanner');

    addBanner.addEventListener('click', function() {
        const index = bannerList.children.length;
        const div = document.createElement('div');
        div.classList.add('banner-edit__list--items');
        div.innerHTML = `
            <img src="" class="banner-edit__list--img" style="display: none;">
            <input type="file" class="banner-edit__list--file" name="banners[${index}][file]">
            <button type="button" class="banner-edit__list--button">-</button>
        `;
        bannerList.appendChild(div);
    });

    bannerList.addEventListener('click', function(e) {
        if (e.target.classList.contains('banner-edit__list--button')) {
            e.target.closest('.banner-edit__list--items').remove();
        }
    });

    bannerList.addEventListener('change', function(e) {
        if (e.target.classList.contains('banner-edit__list--file')) {
            const fileInput =e.target;
            const file = fileInput.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const imgTag = fileInput.closest('.banner-edit__list--items').querySelector('.banner-edit__list--img');
                    imgTag.src = event.target.result;
                    imgTag.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    });
});
