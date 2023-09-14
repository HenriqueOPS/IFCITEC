<html lang="pt-br">
<head>
	<meta charset="utf-8">
<style>
@media all {
	@page{
    size: A4 landscape;
    margin: 0;
	}
	*{
		margin:0;
		padding: 0;
		border: 0;
		-webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
		color-adjust: exact !important;                 /*Firefox*/
	}
	ul{
		list-style-type: none;
		display: flex;
		justify-content: flex-start;
		flex-wrap: wrap;
		align-items: center;
		align-content: center;
	}
	body {
      

		font-family: "Arial", sans-serif;

		margin-left: 0mm;
		margin-right: 0mm;
		background-size:100% 100%;
    	background-attachment: fixed;
	}


	ul li h2.fonte{
		font-size: 10mm;
		text-align: center;
	
	}

	ul li div.bloco{
	
		border: 1px solid #FF0000;
		border-radius:50px;
		width:100px;
		height:100px;
		background-color: #FF0000;
		line-height:50px;
		box-shadow: 2px 2px 5px #FF0000;
		color: #FFF;
		text-align: center;
	}

	ul li div.dados{
		text-align: center;
		
	}

    ul li.line-wrap{
		width: 100%;
		height: calc(30mm);
		display: block;
		background: none;
		border: 0;
	}
}
</style>
</head>
<body>

<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Capa.png'))) }}" alt="Imagem em base64" style="width: 297mm; height: 210mm;">
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Capa_2.png'))) }}" alt="Imagem em base64" style="width: 297mm; height: 210mm;">	
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Capa_3.png'))) }}" alt="Imagem em base64" style="width: 297mm; height: 210mm;">	
<ul >
 
     </li>
			<li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Níveis.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">
           
				<div class="content" style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
					<div class="dados">
						<h1 style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase;width:800px;">Ensino Fundamental</h1>
					
					</div>
				</div>
				
			</li>
           
    </li>
		</ul>
      
		@foreach($areasNivel3 as $area)
        <ul >
 
 </li>
        <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Categorias.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
       
            <div class="content"  style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
                <div class="dados">
                    <h1 style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase;width:800px;"> {{$area->area_conhecimento}}</h1>
                   
                </div>
            </div>
            
        </li>
       
</li>
    </ul>
    @php
					$projetos = $area->getClassificacaoProjetosCertificados($area->id, $edicao);
                    $cont=1;
				@endphp
                
				@foreach($projetos as $projeto)
                <ul >
 
 </li>
 @if($cont==1)
 <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/3Lug.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
 @endif
 @if($cont==2)
 <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/2Lug.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
 @endif
 @if($cont==3)
 <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/1Lug.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
 @endif
     
       
            <div class="content" style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
                <div class="dados">
                    <h1 style="font-size: 8mm; width:800px;"> {{$projeto->titulo}}<br><br></h1>
                    <h2 style="font-size: 8mm;width:800px;  "> {{$projeto->nome_curto}}</h2>
                </div>
            </div>
            
        </li>
       
</li>
    </ul>
    @php
    $cont++;
    @endphp
    @endforeach
    @endforeach
    <ul >
 
     </li>
			<li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Níveis.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">
           
				<div class="content" style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
					<div class="dados">
                    <h1 style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase;width:800px;">Ensino Médio, Ensino Médio Integrado ao Técnico e da Educação Profissional de Nível Técnico</h1>
	
					</div>
				</div>
				
			</li>
           
    </li>
		</ul>
    @foreach($areasNivel2 as $area)
        <ul >
 
 </li>
        <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Categorias.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
       
            <div class="content"  style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
                <div class="dados">
                    <h1 style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase;width:800px;"> {{$area->area_conhecimento}}</h1>
                   
                </div>
            </div>
            
        </li>
       
</li>
    </ul>
    @php
					$projetos = $area->getClassificacaoProjetosCertificados($area->id, $edicao);
                    $cont=1;
				@endphp
                
				@foreach($projetos as $projeto)
                <ul >
 
 </li>
 @if($cont==1)
 <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/3Lug.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
 @endif
 @if($cont==2)
 <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/2Lug.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
 @endif
 @if($cont==3)
 <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/1Lug.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
 @endif
     
       
            <div class="content"  style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
                <div class="dados">
                    <h1 style=" font-size: 8mm; width:800px; "> {{$projeto->titulo}}<br><br></h1>
                    <h2 style="font-size: 8mm;  width:800px;"> {{$projeto->nome_curto}}</h2>
                </div>
            </div>
            
        </li>
       
</li>
    </ul>
    @php
    $cont++;
    @endphp
    @endforeach
    @endforeach
    <ul >
 
     </li>
			<li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/FeirasAfiliadas.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">
           
				<div class="content" style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
					<div class="dados">
						
					
					</div>
				</div>
				
			</li>
           
    </li>
		</ul>  <ul >
 
 <li>
        <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Mostratec.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
       
            <div class="content" style="  display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;">
                <div class="dados">
                
                    @php
					$projetos = $area->getClassificacaoProjetosCertificados2(2, $edicao);
                   
				@endphp
                
                </div>
            </div>
            
        </li>
       
</li>
    </ul>
    @foreach($projetos as $projeto)
                <ul >
 
 </li>
 
 <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/TemplateAfiliadas.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
     
    
            <div class="content" style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
                <div class="dados">
                    <h1  style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase;width:800px;">Ensino Médio, Ensino Médio Integrado ao Técnico e da Educação Profissional de Nível Técnico <br><br></h1>
                    <p style="font-size: 6mm;width:800px;  ">{{$projeto->titulo}}<br><br></p>
                    <h2 style="font-size: 6mm;width:800px;  "> {{$projeto->nome_curto}}</h2>
                </div>
            </div>
            
        </li>
       
</li>
    </ul>
  
    @endforeach
    @php
					$projetos = $area->getClassificacaoProjetosCertificados3(3, $edicao);
                   
				@endphp
                @foreach($projetos as $projeto)
                <ul >
 
 </li>
 <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Mostratec jr.png'))) }}" alt="Imagem em base64" style="width: 297mm; height: 210mm;">	

 <li  style=" background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/TemplateAfiliadas.png'))) }}');
    background-repeat: no-repeat;
    background-size: cover;
    width: 297mm; height: 210mm;">
     
    
            <div class="content" style="  display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
                <div class="dados">
                    <h1  style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase;width:800px;">Ensino fundamental<br><br></h1>
                    <p style="font-size: 6mm;width:800px;  ">{{$projeto->titulo}}<br><br></p>
                    <h2 style="font-size: 6mm;width:800px;  "> {{$projeto->nome_curto}}</h2>
                </div>
            </div>
            
        </li>
       
</li>
    </ul>
  
    @endforeach
    

<ul>
    <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/FEBIC.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">

        <div class="content" style="display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
            <div class="dados">
           
        </div> @php
                $projetos = $area->getClassificacaoProjetosCertificados4(2, $edicao);
                $cont=1;
                @endphp

    </li>
</ul>
@foreach($projetos as $projeto)
   @if($cont==3 || $cont==4)
        <ul>
            <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/TemplateAfiliadas.png'))) }}');
                background-repeat: no-repeat;
                background-size: cover;
                width: 297mm; height: 210mm;">

                <div class="content" style="display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;">
                    <div class="dados">
                        <h1 style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase; width:800px;">Ensino Médio, Ensino Médio Integrado ao Técnico e da Educação Profissional de Nível Técnico <br><br></h1>
                        <p style="font-size: 6mm;width:800px;">{{$projeto->titulo}}<br><br></p>
                        <h2 style="font-size: 6mm;width:800px;">{{$projeto->nome_curto}}</h2>
                    </div>
                </div>

            </li>
        </ul>
  @endif
  @php
  $cont++;
  @endphp
 
@endforeach
    <ul>
    <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Febrace.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">

        <div class="content" style="display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
            <div class="dados">
                @php
                $projetos = $area->getClassificacaoProjetosCertificados4(2, $edicao);
                $cont=1;
                @endphp
            </div>
        </div>

    </li>
</ul>

@foreach($projetos as $projeto)
   @if($cont==5)
        <ul>
            <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/TemplateAfiliadas.png'))) }}');
                background-repeat: no-repeat;
                background-size: cover;
                width: 297mm; height: 210mm;">

                <div class="content" style="display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;">
                    <div class="dados">
                        <h1 style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase; width:800px;">Ensino Médio, Ensino Médio Integrado ao Técnico e da Educação Profissional de Nível Técnico <br><br></h1>
                        <p style="font-size: 6mm;width:800px;">{{$projeto->titulo}}<br><br></p>
                        <h2 style="font-size: 6mm;width:800px;">{{$projeto->nome_curto}}</h2>
                    </div>
                </div>

            </li>
        </ul>
  @endif
  @php
  $cont++;
  @endphp
 
@endforeach

<ul>
    <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/FEMIC.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">

        <div class="content" style="display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
            <div class="dados">

        </div> @php
                $projetos = $area->getClassificacaoProjetosCertificados4(2, $edicao);
                $cont=1;
                @endphp

    </li>
</ul>
@foreach($projetos as $projeto)
   @if($cont==6 || $cont==7)
        <ul>
            <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/TemplateAfiliadas.png'))) }}');
                background-repeat: no-repeat;
                background-size: cover;
                width: 297mm; height: 210mm;">

                <div class="content" style="display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;">
                    <div class="dados">
                        <h1 style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase; width:800px;">Ensino Médio, Ensino Médio Integrado ao Técnico e da Educação Profissional de Nível Técnico <br><br></h1>
                        <p style="font-size: 6mm;width:800px;">{{$projeto->titulo}}<br><br></p>
                        <h2 style="font-size: 6mm;width:800px;">{{$projeto->nome_curto}}</h2>
                    </div>
                </div>

            </li>
        </ul>
  @endif
  @php
  $cont++;
  @endphp
 
@endforeach
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Voto Popular.png'))) }}" alt="Imagem em base64" style="width: 297mm; height: 210mm;">


<ul>
    <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Prêmios Destaque.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">

        <div class="content" style="display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
            <div class="dados">
      
 </div>

        </div>

    </li>
</ul>
  <ul>
    <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/Bolsas.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">

        <div class="content" style="display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">


        </div>

    </li>
</ul>
<ul>
    <li style="background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/TemplateLimpo.png'))) }}');
        background-repeat: no-repeat;
        background-size: cover;
        width: 297mm; height: 210mm;">

        <div class="content" style="display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;">
            <div class="dados">
                <h1 style="margin-top: 10mm; font-size: 16mm; text-transform: uppercase; width:800px;">Muito obrigado!<br></h1>
                <p style="margin-top: 10mm; font-size: 12mm; text-transform: uppercase; width:800px;">Nos vemos na próxima edição!</p>
            </div>
        </div>

    </li>
</ul>


  
</body>
</html>
