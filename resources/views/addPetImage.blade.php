<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<h1><a href="{{route('index')}}">MAIN PAGE</a></h1>

<h1>Upload Image for Pet</h1>

<form id="uploadImageForm" enctype="multipart/form-data">
    @csrf

    <label for="petId">Pet ID:</label>
    <input type="number" min="1" id="petId" name="petId" required>

    <label for="image">Choose Image:</label>
    <input type="file" id="image" name="image">

    <button type="button" onclick="uploadImage()">Upload Image</button>
</form>

<div id="addImageSuccess" style="display: none;">
    <h2>Image uploaded successfully</h2>
</div>
<script>
    function uploadImage() {
        let petId = document.getElementById('petId').value;

        let formData = new FormData();
        let image = document.getElementById('image').files[0];
        formData.append('id', petId); 
        formData.append('image', image);

        $.ajax({
            url: "{{ route('pets.addImagePet') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                displayImageSuccess();
            },
            error: function(error) {
                //...
            }
        });

    }

    function displayImageSuccess() {

        document.getElementById('addImageSuccess').style.display = 'block';
    }
</script>
