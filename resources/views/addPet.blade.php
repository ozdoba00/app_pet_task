<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<h1><a href="{{route('index')}}">MAIN PAGE</a></h1>

<h1>Add a New Pet</h1>

<form id="addPetForm">
    @csrf

    <label for="id">Pet ID:</label>
    <input type="number"  min="1" id="id" name="id">

    <label for="name">Name:</label>
    <input type="text" id="name" name="name">

    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="available">Available</option>
        <option value="pending">Pending</option>
        <option value="sold">Sold</option>
    </select>

    <label for="tags">Tags (words separated by a comma: "test, test1") :</label>
    <input type="text" id="tags" name="tags">

    <button type="button" onclick="addPet()">Add Pet</button>
</form>


<div id="addedPetDetails" style="display: none;">
    <h2>Added Pet Details</h2>
    <p><strong>ID:</strong> <span id="addedPetId"></span></p>
    <p><strong>Name:</strong> <span id="addedPetName"></span></p>
    <p><strong>Status:</strong> <span id="addedPetStatus"></span></p>
    <p><strong>Tags:</strong>
        <ul id="addedPetTags"></ul>
    </p>
</div>

<script>
    function addPet() {
   
        let petId = document.getElementById('id').value;
        let name = document.getElementById('name').value;
        let status = document.getElementById('status').value;
        let tags = document.getElementById('tags').value;

        $.ajax({
            url: "{{ route('pets.addPet') }}",
            type: "POST",
            data: {
                id: petId,
                name: name,
                status: status,
                tags: tags
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                displayAddedPet(response);
            },
            error: function () {
                // ...
            }
        });
    }

    function displayAddedPet(pet) {

        document.getElementById('addedPetId').innerText = pet.id;
        document.getElementById('addedPetName').innerText = pet.name;
        document.getElementById('addedPetStatus').innerText = pet.status;
        let tagsList = document.getElementById('addedPetTags');
        tagsList.innerHTML = '';
        pet.tags.forEach(tag => {
            let li = document.createElement('li');
            li.innerText = tag.name; 
            tagsList.appendChild(li);
        });
        document.getElementById('addedPetDetails').style.display = 'block';
    }
</script>
