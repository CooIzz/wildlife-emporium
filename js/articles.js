
//like button and comment section
document.addEventListener ('DOMContentLoaded', () =>{
    const likeBtn = document.getElementById('like-btn');
    const commentText = document.getElementById('comment-text');
    const commentSubmitBtn = document.getElementById('comment-submit-btn');

    //like button
    if(likeBtn){
        likeBtn.addEventListener('click', (e) =>{
            //check if user log in
            if(typeof IS_LOGGED_IN !== 'undefined' && !IS_LOGGED_IN){
                e.preventDefault();
                alert("Please log in to like the article");
                window.location.href = "../account/login.php";
            }
        });
    }

    //comment section interaction handler
    const handleCommentAuth = (e) => {
        if(typeof IS_LOGGED_IN !== 'undefined' && !IS_LOGGED_IN){
            e.preventDefault(); // Stop click/focus default behavior
            alert("Please log in to leave a comment");
            window.location.href = "../account/login.php";
        }
    };

    if (commentText){
        commentText.addEventListener('click', handleCommentAuth);
    }
    if (commentSubmitBtn){
        commentSubmitBtn.addEventListener('click', handleCommentAuth);
    }
});

