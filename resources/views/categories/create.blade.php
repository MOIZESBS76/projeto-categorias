<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Categoria</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { max-width: 500px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .error { color: red; font-size: 12px; }
    </style>
</head>
<body>
    <h1>Criar Nova Categoria</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/categories" method="POST">
        @csrf
        
        <label>Nome:</label>
        <input type="text" name="name" required value="{{ old('name') }}">

        <label>Descrição:</label>
        <textarea name="description" rows="4">{{ old('description') }}</textarea>

        <button type="submit">Criar</button>
        <a href="/categories">Voltar</a>
    </form>
</body>
</html>