<!-- resources/views/findPetsByStatus.blade.php -->

<head>
    <!-- Inne tagi nagłówka -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Inne tagi nagłówka -->
</head>
<h1><a href="{{route('index')}}">MAIN PAGE</a></h1>

<h1>Find Pets by Status</h1>

<form id="findPetsForm">
    @csrf

    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="available">Available</option>
        <option value="pending">Pending</option>
        <option value="sold">Sold</option>
    </select>
    <button type="button" onclick="findPets()">Find Pets</button>
</form>

<!-- Wyświetlenie wyników wyszukiwania -->
<div id="foundPetsDetails" style="display: none;">
    <h2>Found Pets Details</h2>
    <ul id="foundPetsList"></ul> <!-- Lista zwierząt -->
</div>

<script>
    function findPets() {
        var status = document.getElementById('status').value;

        // Wywołanie AJAX
        $.ajax({
            url: "{{ route('pets.findByStatus') }}",
            type: "GET",
            data: {
                status: status
            },
            success: function (response) {
                displayFoundPets(response);
            },
            error: function () {
                $('#searchResults').html('Failed to fetch pets');
            }
        });
    }

    function displayFoundPets(pets) {
        // Wyświetlanie danych znalezionych zwierząt
        let petsList = document.getElementById('foundPetsList');
        petsList.innerHTML = '';
        
        pets.forEach(pet => {
            let li = document.createElement('li');
            li.innerHTML = `<strong>ID:</strong> ${pet.id}, <strong>Name:</strong> ${pet.name}, <strong>Status:</strong> ${pet.status}, <strong>Tags:</strong> <ul>${getTagsList(pet.tags)}</ul>`;
            petsList.appendChild(li);
        });

        document.getElementById('foundPetsDetails').style.display = 'block';
    }

    function getTagsList(tags) {
        let tagsList = '';
        tags.forEach(tag => {
            tagsList += `<li>${tag.name}</li>`;
        });
        return tagsList;
    }
</script>
