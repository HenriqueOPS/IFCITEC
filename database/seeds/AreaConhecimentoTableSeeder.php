<?php

use Illuminate\Database\Seeder;
use App\AreaConhecimento;

class AreaConhecimentoTableSeeder extends Seeder
{
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $areas = [
            [
                'area_conhecimento' => 'Matemática e suas tecnologias/Ciências da Natureza e suas tecnologias',
            ],
            [
                'area_conhecimento' => 'Ciências Humanas e suas tecnologias/Linguagens, códigos e suas tecnologias',
            ],
            [
                'area_conhecimento' => 'Ciências Exatas e Biológicas',
                'descricao' => 'Animais e plantas, biologia, química, ciências planetárias, terrestres, matemática, física, medicina e saúde, etc.'
            ],
            [
                'area_conhecimento' => 'Ciências Humanas, Comportamentais e Artes',
                'descricao' => 'Psicologia, educação, teorias do conhecimento, metodologia e didática, história, sociologia, filosofia, linguística, administração, política, economia, artes, etc.'
            ],
            [
                'area_conhecimento' => 'Ciências Sociais Aplicadas',
                'descricao' => 'Economia, direito, contabilidade, administração e comunicação – jornalismo, relações públicas e publicidade, etc.',
            ],
            [
                'area_conhecimento' => 'Informática',
                'descricao' => 'Engenharia da computação, algoritmo, banco de dados, inteligência artificial, comunicação e redes, análise e desenvolvimento de sistemas, sistemas operacionais, linguagem de programação, jogos digitais, aplicativos móveis, informática educativa, etc.',
            ],
            [
                'area_conhecimento' => 'Engenharias',
                'descricao' => 'Elétrica, eletrônica, mecatrônica, mecânica, materiais, civil, etc.',
            ],
            [
                'area_conhecimento' => 'Meio-ambiente',
                'descricao' => 'Gerenciamento de ecossistemas, engenharia ambiental, gerenciamento de recursos, gerenciamento de resíduos, reciclagem, educação ambiental, política ambiental, poluição, toxicologia, contaminação, etc.',
            ],
        ];
        
        foreach ($areas as $area){
            $areaEloquent = new AreaConhecimento();
            $areaEloquent->fill($area);
            $areaEloquent->save();
        }
    }

}