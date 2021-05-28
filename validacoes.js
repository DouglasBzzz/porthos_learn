/**
 * Created by dougl on 16/06/2017.
 */
function validarCadastroDocente() {
    var nome = formCadastrarse.nome.value;
    var login = formCadastrarse.login.value;
    var senha = formCadastrarse.senha.value;
    var confirmaSenha = formCadastrarse.ConfirmaSenha.value;

    var descInteresse = formCadInteresse.descricao.value;

    if (nome == '' || nome.length <=2){
        alert('Preencha o campo com seu nome completo');
        formCadastrarse.nome.focus();
        return  false;
    }

    if (senha != confirmaSenha){
        alert('A confirmação de senha não está correta! Verifique');
        formCadastrarse.confirmaSenha.focus();
        return false;
    }

    /*if( document.dados.tx_email.value=="" || document.dados.tx_email.value.indexOf('@')==-1 || document.dados.tx_email.value.indexOf('.')==-1 )
    {
        alert( "Preencha campo E-MAIL corretamente!" );
        document.dados.tx_email.focus();
        return false;
    } */ //validacao de email que vira a ser util

    if (descInteresse =='' || descInteresse.length<=3){
        alert('Preencha o interesse com uma informação válida');
        formCadInteresse.descricao.focus();
        return false;
    }
}
