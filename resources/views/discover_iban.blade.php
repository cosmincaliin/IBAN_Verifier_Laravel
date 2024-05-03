{{-- resources/views/discover_iban.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descubrir IBAN</title>
</head>

<body>
    <h1>Descubrir IBAN</h1>
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <form action="{{ url('/descubre-iban') }}" method="POST">
        @csrf
        <label for="iban">IBAN con asteriscos:</label>
        <input type="text" id="iban" name="iban" placeholder="ES**************" required>
        <button type="submit">Descubrir</button>
    </form>
</body>

</html>
