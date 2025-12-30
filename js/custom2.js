



function maskQtd(numberQtd){
    var cpf = numberQtd.value;
    
    if (isNaN(cpf[cpf.length - 1])) { // Proibir caractere que não seja número
        numberQtd.value = cpf.substring(0, cpf.length - 1);
        return;
    }
    
    
}
