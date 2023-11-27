

<head>
    <!-- Inne tagi nagłówka -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Inne tagi nagłówka -->
</head>
<h1><a href="{{route('index')}}">MAIN PAGE</a></h1>
<h1>Find Pet by ID</h1>

    <form id="findPetForm">
        @csrf

        <label for="petId">Pet ID:</label>
        <input type="number"  min="1" id="petId" name="petId">
        <button type="button" onclick="findPet()">Find Pet</button>
    </form>

    <div id="foundPetDetails" style="display: none;">
        <h2>Found Pet Details</h2>
        <p><strong>ID:</strong> <span id="foundPetId"></span></p>
        <p><strong>Name:</strong> <span id="foundPetName"></span></p>
        <p><strong>Status:</strong> <span id="foundPetStatus"></span></p>
        <p><strong>Tags:</strong>
            <ul id="foundPetTags"></ul> <!-- Lista tagów -->
        </p>
    </div>

    <div id="error" style="display: none">
        
    </div>

    <script>
        function findPet() {
            let petId = document.getElementById('petId').value;

            // Wywołanie AJAX
            $.ajax({
                url: "{{ route('pets.findById') }}",
                type: "GET",
                data: {
                    id: petId
                },
                success: function (response) {
                    displayFoundPet(response);
                },
                error: function () {
                    searchError();
                }
            });
        }

        function searchError()
        {
            document.getElementById('foundPetDetails').style.display = 'none';
            document.getElementById('error').style.display = 'block';
            document.getElementById('error').innerHTML='<h2>Failed to fetch pet</h2>';
        }
        function displayFoundPet(pet) {
        document.getElementById('error').style.display = 'none';
        document.getElementById('foundPetId').innerText = pet.id;
        document.getElementById('foundPetName').innerText = pet.name;
        document.getElementById('foundPetStatus').innerText = pet.status;

        // Przetwarzanie tagów na listę
        let tagsList = document.getElementById('foundPetTags');
        tagsList.innerHTML = '';
        pet.tags.forEach(tag => {
            let li = document.createElement('li');
            li.innerText = tag.name;
            tagsList.appendChild(li);
        });

        document.getElementById('foundPetDetails').style.display = 'block';
    }
    </script>
