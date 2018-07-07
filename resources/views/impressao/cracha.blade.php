
<ul>

@foreach($pessoas as $pessoa)

<li style="width: 65mm; height: 140mm; background: #f00; float: left;">
	<img src="http://localhost:8088/cracha/qr-code/{{$pessoa->id}}">
	<h2>{{$pessoa->nome}}</h2>
	<h3>Autor</h3>
</li>

@endforeach

</ul>
