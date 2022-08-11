<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Cadastrado()
 * @method static static NaoHomologado()
 * @method static static Homologado()
 * @method static static NaoAvaliado()
 * @method static static Avaliado()
 * @method static static NaoCompareceu()
 */
final class EnumSituacaoProjeto extends Enum {
	const Cadastrado 	= 1;
    const NaoHomologado = 2;
    const Homologado	= 3;
    const NaoAvaliado	= 4;
    const Avaliado		= 5;
    const NaoCompareceu	= 6;
}
