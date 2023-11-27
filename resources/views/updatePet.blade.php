<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<h1><a href="{{route('index')}}">MAIN PAGE</a></h1>

<h1>Update Pet</h1>

<form id="updatePetForm">
    @csrf
    <label for="updatePetId">Pet ID:</label>
    <input type="number" min="1" id="updatePetId" name="updatePetId">

    <label for="updateName">New Name:</label>
    <input type="text" id="updateName" name="updateName">

    <label for="updateStatus">New Status:</label>
    <select name="updateStatus" id="updateStatus">
        <option value="available">Available</option>
        <option value="pending">Pending</option>
        <option value="sold">Sold</option>
    </select>

    <label for="updateTags">New Tags (words separated by a comma: "test, test1") :</label>
    <input type="text" id="updateTags" name="updateTags">

    <button type="button" onclick="updatePet()">Update Pet</button>
</form>


<div id="addedPetDetails" style="display: none;">
    <h2>Udpated Pet Details</h2>
    <p><strong>ID:</strong> <span id="addedPetId"></span></p>
    <p><strong>Name:</strong> <span id="addedPetName"></span></p>
    <p><strong>Status:</strong> <span id="addedPetStatus"></span></p>
    <p><strong>Tags:</strong>
        <ul id="addedPetTags"></ul> <!-- Lista tagów -->
    </p>
</div>

<script>
    function updatePet() {
        let petId = document.getElementById('updatePetId').value;
        let name = document.getElementById('updateName').value;
        let status = document.getElementById('updateStatus').value;
        let tags = document.getElementById('updateTags').value;

        $.ajax({
            url: "{{ route('pets.updatePet') }}",
            type: "PUT",
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
                //...
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