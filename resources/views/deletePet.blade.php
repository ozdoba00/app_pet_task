<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<h1><a href="{{route('index')}}">MAIN PAGE</a></h1>

<h1>Delete Pet</h1>

<form id="deletePetForm">
    @csrf 

    <label for="petId">Pet ID:</label>
    <input type="number"  min="1" id="petId" name="petId" required>

    <button type="button" onclick="deletePet()">Delete Pet</button>
</form>

<div id="success" style="display: none;">
    <h2>Pet removed successfully</h2>
</div>

<div id="error" style="display: none">
        
</div>
<script>
    function deletePet() {
        let petId = document.getElementById('petId').value;

        $.ajax({
            url: "{{ route('pets.deletePet') }}", 
            type: 'DELETE',
            data: {
                id: petId,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                document.getElementById('success').style.display = 'block';
                document.getElementById('error').style.display = 'none';
            },
            error: function (error) {
                searchError();
            }
        });
    }

    function searchError()
        {
            document.getElementById('success').style.display = 'none';
            document.getElementById('error').style.display = 'block';
            document.getElementById('error').innerHTML='<h2>Failed to fetch pet</h2>';
        }
</script>