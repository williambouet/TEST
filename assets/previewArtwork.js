
const artworkInput = document.getElementById('artwork_artworkFile_file')
const artworkThumb = document.getElementById('artworkImage')
artworkInput.addEventListener('change', (e) => {
    artworkThumb.src = URL.createObjectURL(e.target.files[0]);
})