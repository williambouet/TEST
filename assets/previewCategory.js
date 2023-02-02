
const avatarInput = document.getElementById('category_categoryFile_file')
const avatarThumb = document.getElementById('category')
avatarInput.addEventListener('change', (e) => {
    avatarThumb.src = URL.createObjectURL(e.target.files[0]);
})