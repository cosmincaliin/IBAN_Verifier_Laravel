{{-- resources/views/validate_iban.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar IBAN</title>
</head>

<body>
    <h1>Validar IBAN</h1>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <form action="{{ url('/valida-iban') }}" method="POST">
        @csrf
        <label for="iban">IBAN:</label>
        <input type="text" id="iban" name="iban" required>
        <button type="submit">Validar</button>
    </form>
</body>

</html>
