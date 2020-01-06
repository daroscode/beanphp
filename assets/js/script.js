//Carregando Datatables
$(document).ready(function() {
	function loadUserTable(){
        
    }
});

//Mensagem para erro ao logar no sistema.
$().ready(function() {
	setTimeout(function () {
		$('.return_message').fadeOut('slow');
	}, 2500);
});

//Rotina para fazer logo e links do welcome surgirem devagar
$().ready(function() {
	setTimeout(function () {
		$('#logo_welcome').fadeIn('slow');
	}, 1500);
});

$().ready(function() {
	setTimeout(function () {
		$('#logo_links').fadeIn('slow');
	}, 2500);
});
