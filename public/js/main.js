function numeroEdicao(n){

	let numStr = '';

	//dezenas
	if(n >= 10){
		switch (parseInt(n / 10)){
			case 1:
				numStr += 'X';
			break;
			case 2:
				numStr += 'XX';
			break;
			case 3:
				numStr += 'XXX';
			break;
			case 4:
				numStr += 'XL';
			break;
			case 5:
				numStr += 'L';
			break;
			case 6:
				numStr += 'LX';
			break;
			case 7:
				numStr += 'LXX';
			break;
			case 8:
				numStr += 'LXXX';
			break;
			case 9:
				numStr += 'XC';
			break;
			case 10:
				numStr += 'C';
			break;
		}

		n = n % 10;
	}

	//unidades
	switch (n){
		case 1:
			numStr += 'I';
		break;
		case 2:
			numStr += 'II';
		break;
		case 3:
			numStr += 'III';
		break;
		case 4:
			numStr += 'IV';
		break;
		case 5:
			numStr += 'V';
		break;
		case 6:
			numStr += 'VI';
		break;
		case 7:
			numStr += 'VII';
		break;
		case 8:
			numStr += 'VIII';
		break;
		case 9:
			numStr += 'IX';
		break;
	}

	return numStr;
}
