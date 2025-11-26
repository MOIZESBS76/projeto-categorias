<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        a { margin-right: 10px; color: #2196F3; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .btn-create { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn-create:hover { background-color: #45a049; }
        .btn-delete { color: red; }
    </style>
</head>
<body>
    <h1>Categorias</h1>
    
    @if($message = Session::get('success'))
        <p style="color: green;">{{ $message }}</p>
    @endif

    <a href="/categories/create" class="btn-create">+ Criar Categoria</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="/categories/{{ $category->id }}/edit">Editar</a>
                        <form action="/categories/{{ $category->id }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Tem certeza?')">Deletar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhuma categoria encontrada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>