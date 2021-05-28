/**
 * Created by dougl on 18/06/2017.
 */
/*$(document).ready(function () {
    $('#novaAula').click(function () {
        alert('botão clicado');
        return 0;
    });
});*/

$(document).ready(function(){
    /**REQUIRED**/
    $("input[required]").each(function(index) {
        /** Utiliza por padrão o placeholder caso não encontre, utiliza o texto do label **/
        var field = $(this).attr("placeholder") != null ? $(this).attr("placeholder") : $(this).parent().find("label").text();
        $(this).rules("add", {
            required : function(element) {
                if(!$(element).val().trim()) {
                    $(element).val("");
                    return true;
                }
                return false;
            },
            messages : {required : "Campo é de preenchimento obrigatório."}
        });
    });

});
