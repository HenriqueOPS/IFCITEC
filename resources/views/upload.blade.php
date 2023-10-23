<form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data">
{{ csrf_field() }}
    <input type="file" name="arquivo">
    <button type="submit">Enviar</button>
</form>
