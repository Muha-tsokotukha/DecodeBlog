const urlParams = new URLSearchParams(window.location.search);
const nickname = urlParams.get('nickname');
const base_url = document.body.dataset.baseurl;
const blogsDiv = document.querySelector(".blogs");   
const currentUserId = localStorage.getItem("user_id");

let inProgress = false;
let page = 0;

function getBlogs(){
    inProgress = true;
    axios.get(`${base_url}/api/blog/list?nickname=${nickname}&page=${page}`).then(res=>{
        showBlogs(res.data);
        inProgress = false;
    });
}

function showBlogs(blogs){
    let blogsHTML = ``;

    if(blogs.length===0 && page == 0){
        blogsDiv.innerHTML = "<h2> 0 blogs </h2>"
    }

    for(let i=0;i< blogs.length; i++){
        let dropDown = ``;
        if( currentUserId == blogs[i].autor_id ){
            dropDown = `
            <span class="link">
						<img src="${base_url}/images/dots.svg" alt="">
						Еще

						<ul class="dropdown">
							<li> <a href="${base_url}/editblog?id=${blogs[i].id}">Редактировать</a> </li>
							<li><a href="${base_url}/api/blog/delete?id=${blogs[i].id}" class="danger">Удалить</a></li>
						</ul>
					</span>
            `
        }
        blogsHTML += `

        <div class="blog-item">
				<img class="blog-item--img" src="${base_url+blogs[i].img}" alt="">
				<div class="blog-header">
					<h3>${blogs[i].title}</h3>
                    ${dropDown}
				</div>
				<p class="blog-desc">
				${blogs[i].description}
				</p>

				<div class="blog-info">
					<span class="link">
						<img src="${base_url}/images/date.svg" alt="">
						${blogs[i].date}
					</span>
					<span class="link">
						<img src="${base_url}/images/visibility.svg" alt="">
						${blogs[i].views}
					</span>
					<a class="link">
						<img src="${base_url}/images/message.svg" alt="">
						<?=mysqli_num_rows(mysqli_query($con, "SELECT id FROM comments WHERE blog_id=".$row["id"]))?>
					</a>
					<span class="link">
						<img src="${base_url}/images/forums.svg" alt="">
						${blogs[i].name}
					</span>
					<a class="link">
						<img src="${base_url}/images/person.svg" alt="">
						${blogs[i].nickname}
					</a>
				</div>
			</div>
        `;
    }
    if( blogs.length > 0 )blogsDiv.innerHTML += blogsHTML;
}

getBlogs();

window.onscroll = function(){

    if(window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 2 && !inProgress ){
        page++;
        getBlogs();
    }
}