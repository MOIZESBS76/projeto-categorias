<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        form { max-width: 500px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <h1>Editar Categoria</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/categories/{{ $category->id }}" method="POST">
        @csrf
        @method('PUT')
        
        <label>Nome:</label>
        <input type="text" name="name" required value="{{ $category->name }}">

        <label>Descrição:</label>
        <textarea name="description" rows="4">{{ $category->description }}</textarea>

        <button type="submit">Atualizar</button>
        <a href="/categories">Voltar</a>
    </form>
</body>
</html>