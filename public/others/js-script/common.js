

function toogleEdit(){

  var current_state = $('fieldset').attr('disabled');
  $('fieldset').attr('disabled',!current_state);

  if(current_state){

      console.log('unlock');
      $('.btn-edit-toogle').html('<i class="fas fa-unlock"></i>');
  }
  else{
      console.log('lock');
      $('.btn-edit-toogle').html('<i class="fas fa-lock"></i>');
  }

}
