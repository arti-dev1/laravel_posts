<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Add New Post</h2>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form id="add_post">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var addform = document.querySelector("#add_post");
        addform.onsubmit = async function (e) {
            event.preventDefault();
            const token = localStorage.getItem('api_token');
            const title = document.querySelector("#title").value;
            const description = document.querySelector("#description").value;
            const image = document.querySelector("#image").files[0];
            var formData = new FormData();
            formData.append('title' , title);
            formData.append('description' , description);
            formData.append('image' , image);

            let responce = await  fetch(`/api/posts`,{
                    method : 'POST',
                    body : formData,
                    headers:{
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(responce => responce.json())
                .then(data => {
                    window.location.href = "http://localhost:8000/allposts";
                });
        }
    </script>
</body>
</html>
