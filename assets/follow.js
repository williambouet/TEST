
const allFollowButton = document.querySelectorAll(".toggleFollow")
let followIsPending = false;


allFollowButton.forEach(followButton => {

    followButton.addEventListener('click', e => {
        e.preventDefault();


        followIsPending = true;

        let followLink = event.currentTarget;
        let linkFollow = followLink.href;

        if (!followIsPending) {
            window.URL.href(linkFollow);
        }

        fetch(linkFollow, { method: "POST" })
            .then(res => res.json())
            .then(function (res) {
                let followIcon = followLink.firstElementChild;
                if (res.isFollow) {
                    followIcon.classList.remove('bi-bookmark-heart');
                    followIcon.classList.add('bi-bookmark-heart-fill');
                    followIsPending = false;

                } else {
                    followIcon.classList.remove('bi-bookmark-heart-fill');
                    followIcon.classList.add('bi-bookmark-heart');
                    followIsPending = false;
                }

            })
            .catch(function (error) {
                followIsPending = false;
            })
    })

})

