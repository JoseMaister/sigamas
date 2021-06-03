var ipts = $('input[type=radio]');

ipts.on('ifChanged', function() {

  var comentario = document.getElementById("com_" + this.name);
  if(this.value == "NG")
  {
    comentario.style.display = "block";
    comentario.setAttribute("required", "required")
  }
  else
  {
    comentario.style.display = "none";
    comentario.removeAttribute("required");
    var frmGroup = $(this).parents().filter('.form-group');
    frmGroup.removeClass('bad');
    frmGroup.find('div.alert').remove();
  }
});
