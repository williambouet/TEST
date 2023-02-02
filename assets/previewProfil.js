
const avatarInput = document.getElementById('user_avatarFile_file')
const avatarThumb = document.getElementById('avatarImage')
avatarInput.addEventListener('change', (e) => {
    avatarThumb.src = URL.createObjectURL(e.target.files[0]);
})