$(document).ready(function(){

		$('button.close').click(function(e){

			e.preventDefault();

			//$(this).attr('data-dismiss')
			var dataDismiss = $(this).data('dismiss');

			//'.'+ dataDismiss devient '.alert' closest() va sélectionner l'élément le plus proche

			$(this).closest('.'+dataDismiss).remove();
		})
});