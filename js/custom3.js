function maskCPF(numberCPF){
    var cpf = numberCPF.value;
    
    if (isNaN(cpf[cpf.length - 1])) { // Proibir caractere que não seja número
        numberCPF.value = cpf.substring(0, cpf.length - 1);
        return;
    }
    
    if(cpf.length === 2 || cpf.length === 6){
        numberCPF.value += ".";
    }
    if(cpf.length === 10){
        numberCPF.value += "/";
    }
    if(cpf.length === 15){
        numberCPF.value += "-";
    }
}
