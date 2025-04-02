<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
   
    <div class="container mt-5">
        <div class="row d-flex justify-content-end">
            <div class="col-auto">
                <a href="{{ route('addpost') }}" class="btn btn-primary" >Add Post</a>
            </div>
            <div class="col-auto">
                <button id="logoutBtn" class="btn btn-danger">Logout</button>
            </div>
        </div>
        <h1 class="mb-4">All Posts</h1>
        <div id="postsContainer"></div>
        
    </div>
    <!--single post modal-->
    <div class="modal fade" id="singlepost" data-bs-backdrop="singlepost" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Single Post</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    <!-- Optional: Add Bootstrap JS (for buttons like 'edit', 'view' to be functional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="b crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        document.querySelector("#logoutBtn").addEventListener('click',function(){
            const token = localStorage.getItem('api_token');
            fetch('/api/logout',{
                method:'POST',
                headers:{
                    'Authorization': `Bearer ${token}`,
                }
            })
            .then(responce => responce.json())
            .then(data => {
                console.log(data);
                window.location.href = "http://localhost:8000/";
            })
        });

        function loadData(){
            const token = localStorage.getItem('api_token');
            fetch('/api/posts',{
                method:'GET',
                headers:{
                    'Authorization': `Bearer ${token}`,
                }
            })
            .then(responce => responce.json())
            .then(data => {
                var allpost = data.data.posts;
                const postsContainer = document.querySelector("#postsContainer");
                var tabledata =  `<table class="table table-bordered">
                        <tr class="table-dark">
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>`;
                        allpost.forEach(post => {
                            tabledata += `<tr>
                                <td><img src="/uploads/${post.image}" width="150px" /></td>  
                                <td><h6>${post.title}</h6></td>
                                <td><p>${post.description}</p></td>
                                <td><Button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#singlepost"  data-bs-postid="${post.id}"> View </Button></td>
                            </tr>`;
                        })
                        postsContainer.innerHTML= tabledata;
                  
            })
        }
        loadData();

        //open single post modal
        var single_modal = document.querySelector("#singlepost");
        if (single_modal) {
            single_modal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                const id = button.getAttribute('data-bs-postid')
                const token = localStorage.getItem('api_token');
                const modalBody = document.querySelector("#singlepost .modal-body");
                fetch(`/api/posts/${id}`,{
                    method:'GET',
                    headers:{
                        'Authorization': `Bearer ${token}`,
                        'Content-Type' : 'application/json'
                    }
                })
                .then(responce => responce.json())
                .then(data => {
                    const post = data.data;
                    modalBody.innerHTML = `
                        Title : ${post.title}
                        <br>
                        Description : ${post.description}
                        <br>
                        <img width="150px" src="/uploads/${post.image}"/>
                    `;
                 })
        })
    }

    </script>
