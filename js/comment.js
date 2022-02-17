const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get('id');
const currentUserId=  localStorage.getItem("user_id");
const authorId = document.body.dataset.authorid;
const base_url = document.body.dataset.baseurl;
let commentsDiv = document.getElementById("comments"); 
const textarea = document.getElementById("comment-text");
const addComment = document.getElementById("add-comment");

function getComments(id){
    axios.get(base_url+"/api/comment/list.php?id=" + id).then(res=>{
        showComments(res.data);
    })
}

function showComments(comments){
    let commentsHTML = `<h2>${comments.length} комментов</h2>`;

    let deleteButton = "";

    for(let i = 0; i < comments.length; i++){
        
        if( currentUserId == authorId || currentUserId == comments[i].user_id  )deleteButton =  `<span onclick='removeComment(${comments[i].id})'> Удалить </span>`; 
        commentsHTML += `
        <div class="comment" id="comment-${comments[i].id}">
            <div class="comment-header">
                <div>
                    <img src="${base_url}/images/avatar.png" alt="">
                    ${comments[i].full_name}
                </div>
                ${deleteButton}
            </div>
            <p>
                ${comments[i].text}
            </p>
        </div>
        `;
    }
    commentsDiv.innerHTML = commentsHTML;
}
getComments(id);

addComment.onclick = function() {

    axios.post(base_url + "/api/comment/add.php", {
        text: textarea.value,
        blog_id: id
    }).then(res=> {

        getComments(id);
        // commentsDiv.innerHTML += `
        // <div class="comment">
        //     <div class="comment-header" id="${res.data.id}">
        //     <div>
        //         <img src="${base_url}/images/avatar.png" alt="">
        //         ${res.data.full_name}
        //         </div>
        //         <span onclick='removeComment(${res.data.id})'> Удалить </span>
                
        //     </div>
        //     <p>
        //         ${res.data.text}
        //     </p>
        // </div>
        // `;

        textarea.value = "";
        
    })
}
function removeComment(commentId){
    axios.delete(base_url + "/api/comment/delete.php?id="+commentId).then(res=>{
        // document.getElementById("comment-" + commentId).remove();
        getComments(id);
    });
}