
const allFavButton = document.querySelectorAll(".toggleFollow")
let favoriteIsPending = false;


allFavButton.forEach(favButton => {

    favButton.addEventListener('click', e => {
        e.preventDefault();


        favoriteIsPending = true;

        let favoriteLink = event.currentTarget;
        let link = favoriteLink.href;

        if (!favoriteIsPending) {
            window.URL.href(link);
        }

        fetch(link, { method: "POST" })
            .then(res => res.json())
            .then(function (res) {
                let favoriteIcon = favoriteLink.firstElementChild;
                if (res.isInFavorite) {
                    favoriteIcon.classList.remove('bi-bookmark-heart');
                    favoriteIcon.classList.add('bi-bookmark-heart-fill');
                    favoriteIsPending = false;

                } else {
                    favoriteIcon.classList.remove('bi-bookmark-heart-fill');
                    favoriteIcon.classList.add('bi-bookmark-heart');
                    favoriteIsPending = false;
                }

            })
            .catch(function (error) {
                favoriteIsPending = false;
            })
    })

})

