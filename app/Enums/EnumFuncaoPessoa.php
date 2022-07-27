<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Usuario()
 * @method static static Organizador()
 * @method static static Avaliador()
 * @method static static Homologador()
 * @method static static Autor()
 * @method static static Coorientador()
 * @method static static Orientador()
 * @method static static Administrador()
 * @method static static Voluntario()
 */
final class EnumFuncaoPessoa extends Enum {
    const Usuario 		= 1;
    const Organizador 	= 2;
    const Avaliador		= 3;
    const Homologador	= 4;
    const Autor			= 5;
    const Coorientador	= 6;
    const Orientador	= 7;
    const Administrador	= 8;
    const Voluntario	= 9;
}
